<?php

use App\Enums\AppProject;
use App\Services\DomainManagerService;
use Illuminate\Http\Request;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function () {
    config()->set('myapp.projectSlug', null);
});

it('uses the enum mapping for the request host', function (string $host, string $expectedSlug) {
    $service = new DomainManagerService(Request::create("https://{$host}"));

    expect($service->getSlug())->toBe($expectedSlug);
})->with([
    'aitomatix.com with www' => ['www.aitomatix.com', AppProject::Aitomatix->value],
    'aitomatix.com without www' => ['aitomatix.com', AppProject::Aitomatix->value],
    'aitomatix.cz with www' => ['www.aitomatix.cz', AppProject::AitomatixCz->value],
    'aitomatix.cz without www' => ['aitomatix.cz', AppProject::AitomatixCz->value],
    'local project domain' => ['laravel-core.test', AppProject::LaravelCore->value],
]);

it('uses the configured project slug before the host mapping', function () {
    config()->set('myapp.projectSlug', 'manual-project');

    $service = new DomainManagerService(Request::create('https://www.aitomatix.cz'));

    expect($service->getSlug())->toBe('manual-project');
});

it('uses the default slug for an unmapped host', function () {
    $service = new DomainManagerService(Request::create('https://unmapped.example'));

    expect($service->getSlug())->toBe(AppProject::LaravelCore->value);
});
