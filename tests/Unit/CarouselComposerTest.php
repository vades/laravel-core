<?php

use App\View\Composers\CarouselComposer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Tests\TestCase;

use function Pest\Laravel\mock;

uses(TestCase::class);

it('shares only jpg gif and png carousel images as public urls', function () {
    Storage::fake('public');

    Storage::disk('public')->put('images/vades/portfolio/one.jpg', 'image');
    Storage::disk('public')->put('images/vades/portfolio/two.gif', 'image');
    Storage::disk('public')->put('images/vades/portfolio/three.png', 'image');
    Storage::disk('public')->put('images/vades/portfolio/FOUR.JPG', 'image');
    Storage::disk('public')->put('images/vades/portfolio/notes.txt', 'text');

    $view = mock(View::class);

    $view->shouldReceive('with')
        ->once()
        ->withArgs(function (array $data): bool {
            if (! array_key_exists('composerImages', $data)) {
                return false;
            }

            expect($data['composerImages'])->toBeArray();
            expect($data['composerImages'])->toHaveCount(4);

            $expectedImages = [
                'images/vades/portfolio/one.jpg',
                'images/vades/portfolio/two.gif',
                'images/vades/portfolio/three.png',
                'images/vades/portfolio/FOUR.JPG',
            ];

            foreach ($expectedImages as $expectedImage) {
                expect(collect($data['composerImages'])->contains(function (string $url) use ($expectedImage): bool {
                    return Str::endsWith($url, '/storage/'.$expectedImage);
                }))->toBeTrue();
            }

            expect(collect($data['composerImages'])->contains(function (string $url): bool {
                return Str::endsWith($url, '/storage/images/vades/portfolio/notes.txt');
            }))->toBeFalse();

            return true;
        });

    (new CarouselComposer)->compose($view);
});
