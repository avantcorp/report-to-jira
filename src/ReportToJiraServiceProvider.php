<?php

declare(strict_types=1);

namespace Avant\ReportToJira;

use Illuminate\Support\ServiceProvider;

class ReportToJiraServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/report-to-jira.php', 'report-to-jira');

        $this->app->singleton(JiraClient::class, fn () => new JiraClient(
            config('report-to-jira.email'),
            config('report-to-jira.api_token'),
            config('report-to-jira.project'),
            config('report-to-jira.client.base_url'),
        ));
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'report-to-jira');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        $this->publishes([
            __DIR__.'/../config/report-to-jira.php' => config_path('report-to-jira.php'),
        ], 'report-to-jira:config');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/report-to-jira'),
        ], 'report-to-jira:views');
    }
}
