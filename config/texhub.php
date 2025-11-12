<?php

return [
    // Ai Assistant
    'ai_token' => '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',
    'ai_base_url' => 'https://api.openai.com/v1',

    //Webhook
    "verify_token" => "1234567890",
    //Facebook App
    "facebook_app_client_id" => "1120338079453956",
    "facebook_app_client_secret" => "8980bf6d317d7d1b5778030311dade90",
    //Instagram App
    "instagram_app_client_id" => "1753572882259297",
    "instagram_app_client_secret" => "e9fe58ecc45e3a55f99cf439270967b7",
    "instagram_app_redirect_uri" => env('APP_URL') . '/callback',
    "login_whith_instagram_uri" => "https://www.instagram.com/oauth/authorize?force_reauth=true&client_id=1753572882259297&redirect_uri=https://admin.liddo.ai/callback&response_type=code&scope=instagram_business_basic%2Cinstagram_business_manage_messages%2Cinstagram_business_manage_comments%2Cinstagram_business_content_publish%2Cinstagram_business_manage_insights",
];
