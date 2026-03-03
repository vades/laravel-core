@php

    $img = $img ?? '';
   $fullPath = storage_path(config('myapp.image.svgPath').'/' . $img . '.svg');
@endphp
<span class="{{$classList ?? ''}}">
@if(file_exists($fullPath))
        {!! file_get_contents($fullPath) !!}
    @endif
</span>