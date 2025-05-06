<?php

declare(strict_types=1);

namespace Avant\ReportToJira\Http\Controllers;

use Avant\ReportToJira\Http\Requests\CreateIssueRequest;
use Avant\ReportToJira\Issue;
use Avant\ReportToJira\JiraClient;

class ReportToJiraController
{
    public function __invoke(JiraClient $jira, CreateIssueRequest $request)
    {
        $jira->createIssue(new Issue(
            reporterName : $request->get('reporter_name'),
            reporterEmail: $request->get('reporter_email'),
            url          : $request->get('url'),
            description  : $request->get('description'),
        ));

        return redirect()->back();
    }
}
