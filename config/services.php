<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'chatbot' => [
        'base_url' => env('CHATBOT_BASE_URL', 'https://api.ai.cc/v1'),
        'api_key' => env('CHATBOT_API_KEY', ''),
        'model' => env('CHATBOT_MODEL', 'mistralai/Mistral-7B-Instruct-v0.2'),
        'temperature' => env('CHATBOT_TEMPERATURE', 0.7),
        'max_tokens' => env('CHATBOT_MAX_TOKENS', 256),
    ],

];
