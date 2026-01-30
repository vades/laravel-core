@php

    $img = $img ?? '';
   $fullPath = 'assets/img/svg/' . $img . '.svg';
@endphp
<span class="{{$classList ?? ''}}">
@if(file_exists($fullPath))
        {!! file_get_contents($fullPath) !!}
    @endif
</span>
