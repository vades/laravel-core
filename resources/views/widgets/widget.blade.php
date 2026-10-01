<div class="my-widget my-widget-default">
    
     <p class="my-widget-title">
        @if($widget->has_icon)  <x-ui.my-img-svg img="{{ $widget->has_icon}}" classList="my-widget-icon" /> @endif
        {{ $widget->title }} {{ $widget->has_icon }}</p>
     <div class="my-widget-body"> {!! $widget->rendered_content !!}</div>
   
    <p class="my-widget-footer">{{ $widget->footer }}</p>
</div>