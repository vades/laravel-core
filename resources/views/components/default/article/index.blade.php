@inject('carbon', 'Carbon\Carbon')
<x-default.layout :title="$page->metaTitle"
                  :description="$page->metaDescription"
                  :keywords="$page->keywords">
    <x-slot name="jumbotron">
        <x-shared.jumbotron>
            <x-default.partials.page-header :page="$page" />
        </x-shared.jumbotron>
    </x-slot>
    <section class="grid gap-2 sm:grid-cols-2 lg:grid-cols-3 lg:gap-3 2xl:grid-cols-4 xl:gap-4">
        @foreach($contents as $item)
            <a href="{{ route('articleShow',  ['slug'=>$item->slug]) }}">
                <x-shared.card class="bg-bcg-blog sm:border border-bor-base">
                    <x-slot name="header">
                        <img class="mr-auto ml-auto"
                             src="{{$item->image_url}}"
                             alt="{{ $item->title}}">
                    </x-slot>
                    <x-slot name="body"
                            class="px-6 py-4">

                        <h2 class="text-2xl font-bold">{{ $item->title }}</h2>
                        <p class="text-sm mb-3">{{ $carbon::parse($item->created_at)->format('Y-m-d') }}</p>

                        <div class="mb-3">
                            {{ $item->description }}
                        </div>
                    </x-slot>
                    <x-slot name="footer"
                            class="p-3">
                        <div class="text-center pb-3">
                            <span class="button">{{__('readMore')}}</span>
                        </div>
                    </x-slot>
                </x-shared.card>
            </a>

        @endforeach
    </section>
    <section class="flex justify-center mt-8">
        {!! $contents->links() !!}

        {{-- <x-utils.pagination class="flex justify-center mt-8" /> --}}
    </section>
</x-default.layout>