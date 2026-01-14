<?php

namespace Database\Seeders;

use App\Models\Agent;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgentSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories
        $nlpCategory = Category::where('slug', 'natural-language-processing')->first();
        $visionCategory = Category::where('slug', 'computer-vision')->first();
        $chatbotCategory = Category::where('slug', 'chatbots-conversational-ai')->first();
        $dataCategory = Category::where('slug', 'data-analysis')->first();
        $codeCategory = Category::where('slug', 'code-generation')->first();
        $contentCategory = Category::where('slug', 'content-creation')->first();
        $automationCategory = Category::where('slug', 'automation')->first();
        $researchCategory = Category::where('slug', 'research-analysis')->first();

        // Get or create a creator user
        $creator = User::firstOrCreate(
            ['email' => 'creator@example.com'],
            [
                'name' => 'Creator User',
                'role' => 'creator',
                'password' => bcrypt('password'),
            ]
        );

        $agents = [
            // NLP Agents
            [
                'name' => 'GPT-4 Assistant',
                'featured_image' => 'https://images.unsplash.com/photo-1677442136019-21780ecad995?w=800&h=600&fit=crop',
                'description' => 'Advanced natural language processing agent capable of understanding context, generating human-like text, and performing complex language tasks. Perfect for chatbots, content generation, and language translation.',
                'link' => 'https://openai.com/gpt-4',
                'documentation' => 'https://platform.openai.com/docs',
                'category_id' => $nlpCategory->id,
                'pricing_type' => 'paid',
                'price' => 20.00,
                'views' => 15420,
                'is_featured' => true,
            ],
            [
                'name' => 'Claude AI',
                'featured_image' => 'https://images.unsplash.com/photo-1676299080923-6c58e13e7f4b?w=800&h=600&fit=crop',
                'description' => 'Next-generation AI assistant with advanced reasoning capabilities, exceptional long-context handling, and strong ethical guidelines. Ideal for research, analysis, and complex problem-solving.',
                'link' => 'https://www.anthropic.com/claude',
                'documentation' => 'https://docs.anthropic.com',
                'category_id' => $nlpCategory->id,
                'pricing_type' => 'freemium',
                'price' => 15.00,
                'views' => 12890,
                'is_featured' => true,
            ],
            [
                'name' => 'BERT Language Model',
                'featured_image' => 'https://images.unsplash.com/photo-1555949963-aa79dcee981c?w=800&h=600&fit=crop',
                'description' => 'Bidirectional Encoder Representations from Transformers. State-of-the-art language understanding model for sentiment analysis, question answering, and text classification.',
                'link' => 'https://github.com/google-research/bert',
                'documentation' => 'https://github.com/google-research/bert/blob/master/README.md',
                'category_id' => $nlpCategory->id,
                'pricing_type' => 'free',
                'price' => 0,
                'views' => 8930,
                'is_featured' => false,
            ],

            // Computer Vision Agents
            [
                'name' => 'YOLO Object Detection',
                'featured_image' => 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?w=800&h=600&fit=crop',
                'description' => 'You Only Look Once - Real-time object detection system. Fast and accurate detection of objects in images and video streams. Perfect for surveillance, autonomous vehicles, and robotics.',
                'link' => 'https://github.com/ultralytics/yolov8',
                'documentation' => 'https://docs.ultralytics.com',
                'category_id' => $visionCategory->id,
                'pricing_type' => 'free',
                'price' => 0,
                'views' => 11200,
                'is_featured' => true,
            ],
            [
                'name' => 'DALL-E Image Generator',
                'featured_image' => 'https://images.unsplash.com/photo-1547036967-23d11aacaee0?w=800&h=600&fit=crop',
                'description' => 'Advanced AI image generation from text descriptions. Create stunning, realistic images from natural language prompts. Supports various artistic styles and detailed compositions.',
                'link' => 'https://openai.com/dall-e-3',
                'documentation' => 'https://platform.openai.com/docs/guides/images',
                'category_id' => $visionCategory->id,
                'pricing_type' => 'paid',
                'price' => 0.04,
                'views' => 9870,
                'is_featured' => false,
            ],
            [
                'name' => 'Face Recognition API',
                'featured_image' => 'https://images.unsplash.com/photo-1563191911-e65f8655ebf9?w=800&h=600&fit=crop',
                'description' => 'Accurate face detection and recognition system with high precision. Supports face matching, age estimation, emotion detection, and landmark detection. Ideal for security and authentication systems.',
                'link' => 'https://github.com/ageitgey/face_recognition',
                'documentation' => 'https://face-recognition.readthedocs.io',
                'category_id' => $visionCategory->id,
                'pricing_type' => 'free',
                'price' => 0,
                'views' => 6740,
                'is_featured' => false,
            ],

            // Chatbots & Conversational AI
            [
                'name' => 'LangChain Chatbot',
                'featured_image' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&h=600&fit=crop',
                'description' => 'Framework for building conversational AI applications with memory, context management, and tool integration. Supports multiple LLM providers and vector databases.',
                'link' => 'https://www.langchain.com',
                'documentation' => 'https://python.langchain.com/docs',
                'category_id' => $chatbotCategory->id,
                'pricing_type' => 'free',
                'price' => 0,
                'views' => 8650,
                'is_featured' => false,
            ],
            [
                'name' => 'Rasa Conversational AI',
                'featured_image' => 'https://images.unsplash.com/photo-1531746790731-6c087fecd65a?w=800&h=600&fit=crop',
                'description' => 'Open-source conversational AI framework for building contextual assistants. Includes NLU, dialogue management, and multi-turn conversation handling.',
                'link' => 'https://rasa.com',
                'documentation' => 'https://rasa.com/docs',
                'category_id' => $chatbotCategory->id,
                'pricing_type' => 'freemium',
                'price' => 0,
                'views' => 7230,
                'is_featured' => false,
            ],
            [
                'name' => 'Dialogflow Agent',
                'featured_image' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=800&h=600&fit=crop',
                'description' => 'Google Cloud conversational AI platform with natural language understanding, intent recognition, and multi-language support. Perfect for customer service chatbots.',
                'link' => 'https://cloud.google.com/dialogflow',
                'documentation' => 'https://cloud.google.com/dialogflow/docs',
                'category_id' => $chatbotCategory->id,
                'pricing_type' => 'freemium',
                'price' => 0,
                'views' => 10560,
                'is_featured' => true,
            ],

            // Data Analysis Agents
            [
                'name' => 'Pandas AI',
                'featured_image' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&h=600&fit=crop',
                'description' => 'AI-powered data analysis agent that uses natural language to analyze dataframes. Ask questions in plain English and get insights from your data automatically.',
                'link' => 'https://github.com/gventuri/pandas-ai',
                'documentation' => 'https://pandas-ai.readthedocs.io',
                'category_id' => $dataCategory->id,
                'pricing_type' => 'free',
                'price' => 0,
                'views' => 5420,
                'is_featured' => false,
            ],
            [
                'name' => 'AutoML Data Scientist',
                'featured_image' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=800&h=600&fit=crop',
                'description' => 'Automated machine learning platform that builds and optimizes ML models automatically. Handles feature engineering, model selection, and hyperparameter tuning.',
                'link' => 'https://www.automl.org',
                'documentation' => 'https://automl.github.io',
                'category_id' => $dataCategory->id,
                'pricing_type' => 'paid',
                'price' => 99.00,
                'views' => 3890,
                'is_featured' => false,
            ],

            // Code Generation Agents
            [
                'name' => 'GitHub Copilot',
                'featured_image' => 'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?w=800&h=600&fit=crop',
                'description' => 'AI pair programmer that suggests code completions as you type. Supports multiple programming languages and integrates seamlessly with popular IDEs.',
                'link' => 'https://github.com/features/copilot',
                'documentation' => 'https://docs.github.com/en/copilot',
                'category_id' => $codeCategory->id,
                'pricing_type' => 'paid',
                'price' => 10.00,
                'views' => 15670,
                'is_featured' => true,
            ],
            [
                'name' => 'CodeT5 Code Generator',
                'featured_image' => 'https://images.unsplash.com/photo-1516116216624-53e697fedbea?w=800&h=600&fit=crop',
                'description' => 'Open-source code generation model trained on code and natural language. Supports code completion, code summarization, and code translation across multiple languages.',
                'link' => 'https://github.com/salesforce/CodeT5',
                'documentation' => 'https://github.com/salesforce/CodeT5#readme',
                'category_id' => $codeCategory->id,
                'pricing_type' => 'free',
                'price' => 0,
                'views' => 6280,
                'is_featured' => false,
            ],
            [
                'name' => 'Tabnine AI Assistant',
                'featured_image' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=800&h=600&fit=crop',
                'description' => 'AI code completion tool that learns from your codebase. Provides intelligent suggestions based on context and coding patterns. Supports 30+ programming languages.',
                'link' => 'https://www.tabnine.com',
                'documentation' => 'https://www.tabnine.com/docs',
                'category_id' => $codeCategory->id,
                'pricing_type' => 'freemium',
                'price' => 12.00,
                'views' => 7540,
                'is_featured' => false,
            ],

            // Content Creation Agents
            [
                'name' => 'Jasper AI Writer',
                'featured_image' => 'https://images.unsplash.com/photo-1455390582262-044cdead277a?w=800&h=600&fit=crop',
                'description' => 'AI writing assistant for creating blog posts, marketing copy, social media content, and more. Generates high-quality, SEO-optimized content in seconds.',
                'link' => 'https://www.jasper.ai',
                'documentation' => 'https://jasper.ai/help',
                'category_id' => $contentCategory->id,
                'pricing_type' => 'paid',
                'price' => 49.00,
                'views' => 9430,
                'is_featured' => false,
            ],
            [
                'name' => 'Copy.ai Content Generator',
                'featured_image' => 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=800&h=600&fit=crop',
                'description' => 'AI-powered copywriting tool for generating ad copy, product descriptions, email campaigns, and creative content. Over 90 copywriting templates available.',
                'link' => 'https://www.copy.ai',
                'documentation' => 'https://help.copy.ai',
                'category_id' => $contentCategory->id,
                'pricing_type' => 'freemium',
                'price' => 0,
                'views' => 6870,
                'is_featured' => false,
            ],

            // Automation Agents
            [
                'name' => 'AutoGPT Agent',
                'featured_image' => 'https://images.unsplash.com/photo-1488590528505-98d2b5aba04b?w=800&h=600&fit=crop',
                'description' => 'Autonomous AI agent that can perform tasks independently by breaking them into subtasks and using the internet and other tools. Capable of complex multi-step workflows.',
                'link' => 'https://github.com/Significant-Gravitas/AutoGPT',
                'documentation' => 'https://docs.agpt.co',
                'category_id' => $automationCategory->id,
                'pricing_type' => 'free',
                'price' => 0,
                'views' => 13200,
                'is_featured' => true,
            ],
            [
                'name' => 'Zapier AI Integration',
                'featured_image' => 'https://images.unsplash.com/photo-1551650975-87deedd944c3?w=800&h=600&fit=crop',
                'description' => 'Automation platform with AI capabilities for connecting apps and automating workflows. Uses AI to suggest automations and optimize task sequences.',
                'link' => 'https://zapier.com',
                'documentation' => 'https://zapier.com/help',
                'category_id' => $automationCategory->id,
                'pricing_type' => 'paid',
                'price' => 29.99,
                'views' => 11240,
                'is_featured' => false,
            ],

            // Research & Analysis Agents
            [
                'name' => 'Perplexity Research Agent',
                'featured_image' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=800&h=600&fit=crop',
                'description' => 'AI research assistant that searches the web, analyzes sources, and synthesizes information into comprehensive answers. Provides citations and source links.',
                'link' => 'https://www.perplexity.ai',
                'documentation' => 'https://www.perplexity.ai/docs',
                'category_id' => $researchCategory->id,
                'pricing_type' => 'freemium',
                'price' => 0,
                'views' => 12450,
                'is_featured' => true,
            ],
            [
                'name' => 'Elicit Research Assistant',
                'featured_image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&h=600&fit=crop',
                'description' => 'AI research tool for automating literature reviews, extracting data from papers, and finding relevant research. Saves hours of manual research work.',
                'link' => 'https://elicit.org',
                'documentation' => 'https://elicit.org/faq',
                'category_id' => $researchCategory->id,
                'pricing_type' => 'freemium',
                'price' => 0,
                'views' => 5690,
                'is_featured' => false,
            ],
        ];

        foreach ($agents as $agentData) {
            Agent::updateOrCreate(
                [
                    'name' => $agentData['name'],
                ],
                array_merge($agentData, [
                    'user_id' => $creator->id,
                ])
            );
        }
    }
}
