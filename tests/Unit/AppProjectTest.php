<?php

use App\Enums\AppProject;

it('returns correct URL for each AppProject case', function () {
    expect(AppProject::Ivnbg->getUrl())->toBe('https://www.ivnbg.com');
    expect(AppProject::MartinVach->getUrl())->toBe('https://www.martinvach.com');
    expect(AppProject::MyPrompties->getUrl())->toBe('https://www.myprompties.com');
    expect(AppProject::Vades->getUrl())->toBe('https://www.vades.dev');
    expect(AppProject::Aitomatix->getUrl())->toBe('https://www.aitomatix.com');
    expect(AppProject::AitomatixCz->getUrl())->toBe('https://www.aitomatix.cz');
    expect(AppProject::LaravelCore->getUrl())->toBe('https://www.laravel-core-test.com');
});