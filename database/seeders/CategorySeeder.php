<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Natural Language Processing', 'description' => 'AI agents for text understanding, generation, and processing'],
            ['name' => 'Computer Vision', 'description' => 'AI agents for image and video analysis'],
            ['name' => 'Chatbots & Conversational AI', 'description' => 'AI agents designed for conversation and customer service'],
            ['name' => 'Data Analysis', 'description' => 'AI agents for data processing and analytics'],
            ['name' => 'Code Generation', 'description' => 'AI agents that generate and assist with code'],
            ['name' => 'Content Creation', 'description' => 'AI agents for creating articles, images, and media'],
            ['name' => 'Automation', 'description' => 'AI agents for automating tasks and workflows'],
            ['name' => 'Research & Analysis', 'description' => 'AI agents for research and information gathering'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => Str::slug($category['name'])],
                [
                    'name' => $category['name'],
                    'description' => $category['description'],
                ]
            );
        }
    }
}
