<?php

use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

uses(TestCase::class);

it('renders carousel slide ids and navigation links from image indexes', function () {
    Storage::fake('public');
    Storage::disk('public')->put('images/vades/portfolio/one.jpg', 'image');
    Storage::disk('public')->put('images/vades/portfolio/two.jpg', 'image');
    Storage::disk('public')->put('images/vades/portfolio/three.jpg', 'image');

    $html = view('components.ui.my-carousel.index')->render();

    expect($html)->toContain('id="slide1"');
    expect($html)->toContain('id="slide2"');
    expect($html)->toContain('id="slide3"');

    expect($html)->toContain('href="#slide3" class="btn btn-circle">❮</a>');
    expect($html)->toContain('href="#slide2" class="btn btn-circle">❯</a>');

    expect($html)->toContain('href="#slide1" class="btn btn-circle">❮</a>');
    expect($html)->toContain('href="#slide3" class="btn btn-circle">❯</a>');

    expect($html)->toContain('href="#slide2" class="btn btn-circle">❮</a>');
    expect($html)->toContain('href="#slide1" class="btn btn-circle">❯</a>');
});

it('does not render carousel when there is one image or less', function () {
    Storage::fake('public');
    Storage::disk('public')->put('images/vades/portfolio/one.jpg', 'image');

    $html = view('components.ui.my-carousel.index')->render();

    expect($html)->not->toContain('class="carousel w-full"');
});
