<section {{$attributes->class(['text-center my-10'])}}>
    <h1 class="text-4xl mb-4">{{$page->title}}</h1>
    <div class="text-lg mb-4">{{$page->excerpt}}</div>
    <div>  <a href="{{ route('pageItem',['slug' => 'about']) }}" class="btn btn-outline btn-primary my-btn-raquo">{{__('app.nav.readMoreAbout',['about'=> 'Nuremberg'])}}</a></div>

</section>
