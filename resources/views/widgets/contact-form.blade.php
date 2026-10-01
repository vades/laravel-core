<section class="my-widget my-widget-contact-form">
    <div>
     <h3 class="my-widget-title">
        @if($widget->has_icon)  <x-ui.my-img-svg img="{{ $widget->has_icon}}" classList="my-widget-icon" /> @endif
        {{ $widget->title }} {{ $widget->has_icon }}</h3>
        @if(!empty($widget->rendered_content))
     <div class="my-widget-body"> {!! $widget->rendered_content !!}</div>
      @endif
     @if(!empty($widget->footer))
            <div>
               {{ $widget->footer }}
            </div>
        @endif
      </div>
     <div>
        <livewire:widgets.contact-form />
    </div>
   </section>