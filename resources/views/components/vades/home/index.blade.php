<x-default.layout :title="$page->metaTitle ?? $page->title" :description="$page->metaDescription ?? $page->excerpt" :keywords="$page->keywords">

    <x-slot name="jumbotron">
        <x-ui.my-jumbotron class="">
            {!! widget('vades-home-hero') !!}
        </x-ui.my-jumbotron>
    </x-slot>
    <section class="mt-8">
        {!! widget('references') !!}
    </section>
    <section class="my-homepage-section my-homepage-features">
        {!! widget('vades-home-features') !!}
        {{-- <x-vades.home.features /> --}}
    </section>

    <section class="my-homepage-section">
        {!! widget('vades-home-reference', ['class' => 'my-homepage-experience']) !!}
    </section>

    <section class="my-homepage-section">
        {!! widget('home-contact-form', ['class' => 'my-homepage-contact-form']) !!}
    </section>

    <section class="my-homepage-section">
        {!! widget('photo-gallery', ['path' => 'ivnbg/hauptmarkt', 'take' => 6, 'schuffle' => true]) !!}
    </section>

    {{-- <section class="my-homepage-section">
        {!! widget('photo-blog', ['path' => 'ivnbg/hauptmarkt']) !!}
    </section> --}}

    {!! widget('articles') !!}

    @if ($articles->isNotEmpty())
        <section class="my-homepage-section">
            <x-vades.home.articles :articles="$articles" />
        </section>
    @endif


</x-default.layout>
