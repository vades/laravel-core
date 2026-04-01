<section {{$attributes->class(['text-center my-10'])}}>
    <h1 class="text-4xl mb-4">{{$page->title}}</h1>
    <div class="text-lg mb-4">{{$page->excerpt}}</div>
    <div>  <x-ui.button href="{{ route('pageItem',['slug' => 'about']) }}" variant="outline" size="lg">{{__('app.nav.readMoreAbout',['about'=> 'Nuremberg'])}}</x-ui.button></div>

</section>