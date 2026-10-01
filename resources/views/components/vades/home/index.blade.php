<x-default.layout :title="$page->metaTitle ?? $page->title"
                  :description="$page->metaDescription ?? $page->excerpt"
                  :keywords="$page->keywords">
    @if(!empty($page))
        <x-slot name="jumbotron">
            <x-ui.my-jumbotron class="">
                 {!! widget('vades-home-hero',['view' =>'widget-home-hero']) !!}
            </x-ui.my-jumbotron>
        </x-slot>

    @endif

    {!! widget('references') !!}

     @if(count($references) > 0)
            <section class="mt-8">
                <x-default.home.references :references="$references"/>
            </section>
        @endif

       

    

        <section class="my-homepage-section">
            <x-vades.home.features />
        </section>

        <section class="my-homepage-section">
             {!! widget('contact-form') !!}
        </section>

         {!! widget('articles') !!}

    @if($articles->isNotEmpty())
        <section class="my-homepage-section">
            <x-vades.home.articles :articles="$articles" />
        </section>
    @endif


</x-default.layout>
