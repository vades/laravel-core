@php
    if(isset($page->user)){
        $page->user = null;
    }
@endphp
@inject('carbon', 'Carbon\Carbon')
<x-default.layout :title="$page->metaTitle"
                  :description="$page->metaDescription"
                  :keywords="$page->keywords">
    <x-slot name="jumbotron">
        <x-ui.my-jumbotron>
            <x-default.partials.page-header :page="$page" />
        </x-ui.my-jumbotron>
    </x-slot>
    <section class="base-grid">
        @foreach($articles as $item)
            @php($coverImage = !empty($item->cover_image_url) ? $item->cover_image_url : config('myapp.image.placeholder.article'))

                <x-shared.card>
                    <x-slot name="header">
                        <img class="card-image "
                             src="{{asset($coverImage)}}"
                             alt="{{ $item->title}}">
                    </x-slot>
                    <x-slot name="body">

                        <h2 class="card-title">  <a href="{{ route('articleShow',  ['slug'=>$item->slug]) }}">{{ $item->title }} </a></h2>
                        <p class="card-info">{{ $carbon::parse($item->created_at)->format('Y-m-d') }}</p>

                        <div class="card-excerpt">
                            {{ $item->excerpt }}
                        </div>
                    </x-slot>
                    <x-slot name="footer">
                        <a class="button "
                           href="{{ route('articleShow',  ['slug'=>$item->slug]) }}">{{__('app.nav.readMore')}}</a>
                    </x-slot>
                </x-shared.card>


        @endforeach
    </section>
    <section class="flex justify-center mt-8">
        {!! $articles->links() !!}

        {{-- <x-utils.pagination class="flex justify-center mt-8" /> --}}
    </section>
</x-default.layout>