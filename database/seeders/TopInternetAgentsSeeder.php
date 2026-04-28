<?php

namespace Database\Seeders;

use App\Models\Agent;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class TopInternetAgentsSeeder extends Seeder
{
    /**
     * Seed top AI agents by category:
     * chatbot, photo generation, audio generation, video generation.
     */
    public function run(): void
    {
        $chatbotCategory = Category::where('slug', 'chatbots-conversational-ai')->first();
        $contentCategory = Category::where('slug', 'content-creation')->first();
        $visionCategory = Category::where('slug', 'computer-vision')->first();

        if (! $chatbotCategory || ! $contentCategory || ! $visionCategory) {
            return;
        }

        $creator = User::firstOrCreate(
            ['email' => 'creator@example.com'],
            [
                'name' => 'Creator User',
                'role' => 'creator',
                'password' => bcrypt('password'),
            ]
        );

        $agents = [
            // Chatbots
            [
                'name' => 'ChatGPT',
                'featured_image' => 'https://images.unsplash.com/photo-1677442136019-21780ecad995?w=1200&h=800&fit=crop',
                'description' => 'General purpose conversational assistant for writing, coding, planning, and research tasks.',
                'link' => 'https://chat.openai.com',
                'documentation' => 'https://platform.openai.com/docs',
                'category_id' => $chatbotCategory->id,
                'pricing_type' => 'freemium',
                'price' => 20.00,
                'views' => 300000,
                'is_featured' => true,
                'is_approved' => true,
            ],
            [
                'name' => 'Claude',
                'featured_image' => 'https://images.unsplash.com/photo-1676299080923-6c58e13e7f4b?w=1200&h=800&fit=crop',
                'description' => 'Conversational AI focused on long-context reasoning, writing quality, and business productivity.',
                'link' => 'https://claude.ai',
                'documentation' => 'https://docs.anthropic.com',
                'category_id' => $chatbotCategory->id,
                'pricing_type' => 'freemium',
                'price' => 20.00,
                'views' => 220000,
                'is_featured' => true,
                'is_approved' => true,
            ],
            [
                'name' => 'Gemini',
                'featured_image' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?w=1200&h=800&fit=crop',
                'description' => 'Multimodal assistant by Google for chat, document analysis, and everyday AI workflows.',
                'link' => 'https://gemini.google.com',
                'documentation' => 'https://ai.google.dev/gemini-api/docs',
                'category_id' => $chatbotCategory->id,
                'pricing_type' => 'freemium',
                'price' => 19.99,
                'views' => 210000,
                'is_featured' => true,
                'is_approved' => true,
            ],
            [
                'name' => 'Perplexity',
                'featured_image' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=1200&h=800&fit=crop',
                'description' => 'Answer engine chatbot that combines conversation with live web sources and citations.',
                'link' => 'https://www.perplexity.ai',
                'documentation' => 'https://docs.perplexity.ai',
                'category_id' => $chatbotCategory->id,
                'pricing_type' => 'freemium',
                'price' => 20.00,
                'views' => 170000,
                'is_featured' => false,
                'is_approved' => true,
            ],

            // Photo generation
            [
                'name' => 'Midjourney',
                'featured_image' => 'https://images.unsplash.com/photo-1618005198919-d3d4b5a92eee?w=1200&h=800&fit=crop',
                'description' => 'Text-to-image generator known for artistic quality and visual style control.',
                'link' => 'https://www.midjourney.com',
                'documentation' => 'https://docs.midjourney.com',
                'category_id' => $visionCategory->id,
                'pricing_type' => 'paid',
                'price' => 10.00,
                'views' => 160000,
                'is_featured' => true,
                'is_approved' => true,
            ],
            [
                'name' => 'DALL-E 3',
                'featured_image' => 'https://images.unsplash.com/photo-1547036967-23d11aacaee0?w=1200&h=800&fit=crop',
                'description' => 'OpenAI image generation model for creative image synthesis from natural language prompts.',
                'link' => 'https://openai.com/dall-e-3',
                'documentation' => 'https://platform.openai.com/docs/guides/images',
                'category_id' => $visionCategory->id,
                'pricing_type' => 'paid',
                'price' => 0.04,
                'views' => 155000,
                'is_featured' => true,
                'is_approved' => true,
            ],

            // Audio generation
            [
                'name' => 'ElevenLabs Voice AI',
                'featured_image' => 'https://images.unsplash.com/photo-1511379938547-c1f69419868d?w=1200&h=800&fit=crop',
                'description' => 'AI voice generation for realistic narration, dubbing, and multilingual speech synthesis.',
                'link' => 'https://elevenlabs.io',
                'documentation' => 'https://elevenlabs.io/docs',
                'category_id' => $contentCategory->id,
                'pricing_type' => 'freemium',
                'price' => 5.00,
                'views' => 140000,
                'is_featured' => false,
                'is_approved' => true,
            ],
            [
                'name' => 'Suno',
                'featured_image' => 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=1200&h=800&fit=crop',
                'description' => 'Music generation platform that creates songs from prompts with vocals and instrumentation.',
                'link' => 'https://suno.com',
                'documentation' => 'https://help.suno.com',
                'category_id' => $contentCategory->id,
                'pricing_type' => 'freemium',
                'price' => 10.00,
                'views' => 145000,
                'is_featured' => false,
                'is_approved' => true,
            ],

            // Video generation
            [
                'name' => 'Runway Gen-3',
                'featured_image' => 'https://images.unsplash.com/photo-1574717024653-61fd2cf4d44d?w=1200&h=800&fit=crop',
                'description' => 'AI video generation and editing suite for text-to-video and production workflows.',
                'link' => 'https://runwayml.com',
                'documentation' => 'https://help.runwayml.com',
                'category_id' => $visionCategory->id,
                'pricing_type' => 'paid',
                'price' => 15.00,
                'views' => 130000,
                'is_featured' => true,
                'is_approved' => true,
            ],
            [
                'name' => 'Pika',
                'featured_image' => 'https://images.unsplash.com/photo-1492619375914-88005aa9e8fb?w=1200&h=800&fit=crop',
                'description' => 'Prompt-to-video tool focused on fast short-form generation and stylized scene creation.',
                'link' => 'https://pika.art',
                'documentation' => 'https://pika.art/faq',
                'category_id' => $visionCategory->id,
                'pricing_type' => 'freemium',
                'price' => 8.00,
                'views' => 120000,
                'is_featured' => false,
                'is_approved' => true,
            ],
        ];

        foreach ($agents as $agentData) {
            Agent::updateOrCreate(
                ['name' => $agentData['name']],
                array_merge($agentData, ['user_id' => $creator->id])
            );
        }
    }
}
