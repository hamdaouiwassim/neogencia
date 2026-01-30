<?php

namespace Database\Seeders;

use App\Models\ChatbotModel;
use Illuminate\Database\Seeder;

class ChatbotModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $models = [
            ['name' => 'Mistral 7B Instruct v0.2', 'api_name' => 'mistralai/Mistral-7B-Instruct-v0.2', 'is_default' => true, 'sort_order' => 0],
        ];

        foreach ($models as $model) {
            ChatbotModel::firstOrCreate(
                ['api_name' => $model['api_name']],
                $model
            );
        }
    }
}
