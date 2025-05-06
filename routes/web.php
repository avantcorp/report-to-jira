<?php

declare(strict_types=1);

use Avant\ReportToJira\Http\Controllers\ReportToJiraController;
use Illuminate\Support\Facades\Route;

Route::post('/report-to-jira', ReportToJiraController::class)->name('report-to-jira');
