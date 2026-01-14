<?php

namespace Database\Seeders;

use App\Models\PricingPlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PricingPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PricingPlan::firstOrCreate(
            ['name' => 'Basic'],
            [
            'name' => 'Basic',
            'description' => 'Perfect for individuals getting started',
            'price' => 9.99,
            'currency' => 'USD',
            'features' => [
                'Access to free agents',
                '10 paid agent queries per month',
                'Community support',
                'Basic documentation',
            ],
            'is_popular' => false,
            ]
        );

        PricingPlan::firstOrCreate(
            ['name' => 'Professional'],
            [
            'name' => 'Professional',
            'description' => 'For professionals and small teams',
            'price' => 29.99,
            'currency' => 'USD',
            'features' => [
                'Access to all free agents',
                '100 paid agent queries per month',
                'Priority support',
                'Advanced documentation',
                'API access',
                'Custom integrations',
            ],
            'is_popular' => true,
            ]
        );

        PricingPlan::firstOrCreate(
            ['name' => 'Enterprise'],
            [
            'name' => 'Enterprise',
            'description' => 'For large organizations',
            'price' => 99.99,
            'currency' => 'USD',
            'features' => [
                'Unlimited access to all agents',
                'Unlimited queries',
                '24/7 dedicated support',
                'Custom agent development',
                'Advanced API access',
                'White-label solutions',
                'SLA guarantee',
            ],
            'is_popular' => false,
            ]
        );
    }
}
