<?php

declare(strict_types=1);

namespace Avant\ReportToJira;

use GuzzleHttp\Middleware;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Psr\Http\Message\RequestInterface;
use Spatie\GuzzleRateLimiterMiddleware\RateLimiterMiddleware;

class JiraClient
{
    public function __construct(
        protected string $email,
        protected string $apiToken,
        protected string $project,
        protected string $baseUrl,
    ) {}

    protected function request(): PendingRequest
    {
        return Http::withBasicAuth($this->email, $this->apiToken)
            ->withMiddleware(RateLimiterMiddleware::perMinute(100))
            ->withMiddleware(Middleware::mapRequest(function (RequestInterface $request) {
                return $request->withHeader('Accept', 'application/json');
            }))
            ->baseUrl($this->baseUrl);
    }

    public function createIssue(Issue $issue): bool
    {
        $issue->withProject($this->project);

        return !is_null(
            rescue(
                fn () => $this
                    ->request()
                    ->post('issue', $issue)
                    ->throw()
            )
        );
    }
}
