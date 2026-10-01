<section class="my-home-hero">
    <div>
        <h1>{{ $widget->title }}</h1>
         <div class="my-widget-body"> {!! $widget->rendered_content !!}</div>
    </div>
    <div>
         @if($widget->has_icon)  <x-ui.my-img-svg img="{{ $widget->has_icon}}" classList="home-hero-svg" /> @endif
    </div>
</section>