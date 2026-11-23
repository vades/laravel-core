<x-default.layout :title="$page->metaTitle ?? $page->title" :description="$page->metaDescription ?? $page->excerpt" :keywords="$page->keywords">

    <x-slot name="jumbotron">
        <x-ui.my-jumbotron class="">
            {!! widget('home-hero') !!}
        </x-ui.my-jumbotron>
    </x-slot>

    <section class="my-homepage-section my-homepage-features">
        {!! widget('home-features') !!}
    </section>


    <section class="my-homepage-section">
        {!! widget('home-reference', ['class' => 'my-homepage-experience']) !!}
    </section>

    <section class="my-homepage-section">
        {!! widget('home-reference-carousel', ['view' => 'reference-carousel']) !!}
    </section>



    @if ($articles->isNotEmpty())
        <section class="my-homepage-section">
            <x-vades.home.articles :articles="$articles" />
        </section>
    @endif


    <section class="my-homepage-section">
        {!! widget('home-contact-form', ['class' => 'my-homepage-contact-form']) !!}
    </section>



</x-default.layout>
