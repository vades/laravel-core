<section {{$attributes->class(['text-center my-10'])}}>
    <h1 class="text-4xl mb-4">The action title</h1>
    <div class="text-lg mb-4">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</div>
    <div>  <x-ui.button href="{{ route('pageItem',['slug' => 'about']) }}" variant="outline" size="lg">{{__('app.nav.readMoreAbout',['about'=> 'LARACO'])}}</x-ui.button></div>

</section>