<?php

namespace Tests\Feature;

use App\Models\Agent;
use App\Models\AgentInvocation;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AgentInvokeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Config::set('agent_runtime.url', 'http://agent-runtime.test');
        Config::set('agent_runtime.secret', 'test-secret');
    }

    private function makeCategory(): Category
    {
        return Category::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
            'description' => 'Test',
        ]);
    }

    private function makeHostedAgent(User $owner, bool $approved = false): Agent
    {
        return Agent::create([
            'user_id' => $owner->id,
            'category_id' => $this->makeCategory()->id,
            'name' => 'Hosted Agent',
            'description' => 'Description',
            'link' => 'https://example.com',
            'documentation' => null,
            'price' => 0,
            'pricing_type' => 'free',
            'views' => 0,
            'is_featured' => false,
            'is_approved' => $approved,
            'execution_mode' => 'hosted',
            'langflow_flow_id' => 'flow-123',
            'langflow_revision' => null,
            'langsmith_project' => null,
        ]);
    }

    public function test_invoke_requires_authentication(): void
    {
        $owner = User::factory()->create();
        $agent = $this->makeHostedAgent($owner, true);

        $response = $this->postJson(route('agents.invoke', $agent), ['input' => 'hello']);

        $response->assertStatus(401);
    }

    public function test_invoke_forbidden_for_unapproved_non_owner(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $agent = $this->makeHostedAgent($owner, false);

        Http::fake([
            'http://agent-runtime.test/*' => Http::response([
                'success' => true,
                'output' => 'ok',
                'trace_url' => null,
                'langsmith_run_id' => null,
                'source' => 'langchain',
            ], 200),
        ]);

        $response = $this->actingAs($other)->postJson(route('agents.invoke', $agent), ['input' => 'hello']);

        $response->assertForbidden();
        $this->assertSame(0, AgentInvocation::count());
    }

    public function test_invoke_allowed_for_owner_when_unapproved(): void
    {
        $owner = User::factory()->create();
        $agent = $this->makeHostedAgent($owner, false);

        Http::fake([
            'http://agent-runtime.test/*' => Http::response([
                'success' => true,
                'output' => 'owner-ok',
                'trace_url' => null,
                'langsmith_run_id' => null,
                'source' => 'langchain',
            ], 200),
        ]);

        $response = $this->actingAs($owner)->postJson(route('agents.invoke', $agent), ['input' => 'hello']);

        $response->assertOk()->assertJson(['success' => true, 'output' => 'owner-ok']);
        $this->assertSame(1, AgentInvocation::count());
    }

    public function test_invoke_allowed_for_approved_agent_as_other_user(): void
    {
        $owner = User::factory()->create();
        $buyer = User::factory()->create();
        $agent = $this->makeHostedAgent($owner, true);

        Http::fake([
            'http://agent-runtime.test/*' => Http::response([
                'success' => true,
                'output' => 'buyer-ok',
                'trace_url' => null,
                'langsmith_run_id' => null,
                'source' => 'langchain',
            ], 200),
        ]);

        $response = $this->actingAs($buyer)->postJson(route('agents.invoke', $agent), ['input' => 'hi']);

        $response->assertOk()->assertJson(['success' => true, 'output' => 'buyer-ok']);
    }

    public function test_invoke_returns_422_for_external_agent(): void
    {
        $owner = User::factory()->create();
        $category = $this->makeCategory();
        $agent = Agent::create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
            'name' => 'External',
            'description' => 'Desc',
            'link' => 'https://example.com',
            'documentation' => null,
            'price' => 0,
            'pricing_type' => 'free',
            'views' => 0,
            'is_featured' => false,
            'is_approved' => true,
            'execution_mode' => 'external',
            'langflow_flow_id' => null,
        ]);

        $response = $this->actingAs($owner)->postJson(route('agents.invoke', $agent), ['input' => 'hello']);

        $response->assertStatus(422);
    }

    public function test_invoke_returns_503_when_runtime_not_configured(): void
    {
        Config::set('agent_runtime.secret', '');

        $owner = User::factory()->create();
        $agent = $this->makeHostedAgent($owner, true);

        $response = $this->actingAs($owner)->postJson(route('agents.invoke', $agent), ['input' => 'hello']);

        $response->assertStatus(503);
    }

    public function test_admin_can_invoke_unapproved_hosted_agent(): void
    {
        $owner = User::factory()->create();
        $admin = User::factory()->create(['role' => 'admin']);
        $agent = $this->makeHostedAgent($owner, false);

        Http::fake([
            'http://agent-runtime.test/*' => Http::response([
                'success' => true,
                'output' => 'admin-ok',
                'trace_url' => null,
                'langsmith_run_id' => null,
                'source' => 'langchain',
            ], 200),
        ]);

        $response = $this->actingAs($admin)->postJson(route('agents.invoke', $agent), ['input' => 'hello']);

        $response->assertOk()->assertJson(['success' => true, 'output' => 'admin-ok']);
    }
}
