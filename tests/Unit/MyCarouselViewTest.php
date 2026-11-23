<?php

use Tests\TestCase;

uses(TestCase::class);

it('renders reference slides in Blade and uses Alpine only to toggle visibility', function () {
    $references = collect([
        (object) [
            'slug' => 'first-reference',
            'title' => 'First Reference',
            'featured_image_url' => 'https://example.test/first.jpg',
        ],
        (object) [
            'slug' => 'second-reference',
            'title' => 'Second Reference',
            'featured_image_url' => 'https://example.test/second.jpg',
        ],
    ]);

    $html = view('components.ui.my-carousel.index', ['images' => $references])->render();

    expect($html)
        ->toContain('src="https://example.test/first.jpg"')
        ->toContain('alt="First Reference"')
        ->toContain('First Reference')
        ->toContain('href="'.route('referenceShow', ['slug' => 'first-reference']).'"')
        ->toContain('bg-black/50')
        ->toContain('x-show="current === 0"')
        ->toContain('x-show="current === 1"')
        ->not->toContain('x-for')
        ->not->toContain(':src');
});

it('does not render a carousel with one or fewer references', function () {
    $html = view('components.ui.my-carousel.index', [
        'images' => collect([
            (object) [
                'slug' => 'only-reference',
                'title' => 'Only Reference',
                'featured_image_url' => 'https://example.test/only.jpg',
            ],
        ]),
    ])->render();

    expect(trim($html))->toBeEmpty();
});
