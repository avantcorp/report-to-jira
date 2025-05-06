<?php

namespace Avant\ReportToJira\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateIssueRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'reporter_name'  => ['nullable', 'string'],
            'reporter_email' => ['nullable', 'string'],
            'url'            => ['nullable', 'url'],
            'description'    => ['required', 'string'],
        ];
    }
}
