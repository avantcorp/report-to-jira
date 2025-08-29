<?php

declare(strict_types=1);

return [
    'email'      => env('RTJ_EMAIL'),
    'api_token'  => env('RTJ_API_TOKEN'),
    'project'    => env('RTJ_PROJECT'),
    'parent_key' => env('RTJ_PARENT_KEY'),
    'client'     => [
        'base_url' => env('RTJ_CLIENT_BASE_URL', 'https://avantc.atlassian.net/rest/api/3'),
    ],
];
