<?php

declare(strict_types=1);

namespace Avant\ReportIssues;

return [
    'email'     => env('RTJ_EMAIL'),
    'api_token' => env('RTJ_API_TOKEN'),
    'project'   => env('RTJ_PROJECT'),
    'client'    => [
        'base_url' => env('RTJ_CLIENT_BASE_URL', 'https://avantc.atlassian.net/rest/api/3'),
    ],
];
