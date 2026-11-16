<section class="my-home-hero">
    <div>
        <h1>{{$page->title}}</h1>
        <p>{{$page->excerpt}}</p>
        <a href="{{ route('pageItem',['slug' => 'about']) }}"
                class="btn btn-wide btn-outline btn-primary my-btn-raquo">Who's Building This</a>
    </div>
    <div>
        <x-ui.my-img-svg img="vades-hero" classList="home-hero-svg" />
    </div>
</section>
