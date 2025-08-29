<?php

namespace Avant\ReportToJira;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Stringable;
use JsonSerializable;

class Issue implements Arrayable, JsonSerializable
{
    public function __construct(
        public ?string $reporterName,
        public ?string $reporterEmail,
        public ?string $url,
        public string $description,
        public ?string $project = null,
        public ?string $parentKey = null,
    ) {}

    public function withProject(string $project): static
    {
        $this->project = $project;

        return $this;
    }

    public function withParentKey(?string $parentKey): static
    {
        $this->parentKey = $parentKey;

        return $this;
    }

    public function toArray(): array
    {
        $content = [];

        $pretext = str($this->url)
            ->whenNotEmpty(fn (Stringable $str) => $str->append(PHP_EOL))
            ->when($this->reporterName || $this->reporterEmail,
                fn (Stringable $str) => $str
                    ->append(implode(' ', array_filter([
                        $this->reporterName,
                        $this->reporterEmail,
                    ])))
                    ->append(PHP_EOL)
            );
        if ($pretext->isNotEmpty()) {
            $content[] = [
                'type'    => 'paragraph',
                'content' => [['type' => 'text', 'text' => $pretext->toString()]],
            ];
        }

        $content[] = [
            'type'    => 'paragraph',
            'content' => [['type' => 'text', 'text' => $this->description]],
        ];

        $title = str($this->description)
            ->limit(30)
            ->unless($this->parentKey, fn(Stringable $title) => $title
                ->prepend(sprintf('%s: ', config('app.name')))
            )
            ->toString();

        return [
            'fields' => array_filter([
                'summary'     => $title,
                'labels'      => ['user-reported'],
                'project'     => ['key' => $this->project],
                'issuetype'   => ['name' => 'Task'],
                'parent'      => $this->parentKey ? ['key' => $this->parentKey] : null,
                'description' => [
                    'type'    => 'doc',
                    'version' => 1,
                    'content' => $content,
                ],
            ]),
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}