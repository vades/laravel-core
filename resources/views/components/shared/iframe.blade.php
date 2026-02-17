@props(['src'])
<div  {{$attributes->class(['relative pb-[56.25%] pt-8 h-0 overflow-hidden'])}}>
   <iframe class="absolute top-0 left-0 w-full h-full"
           allowfullscreen=""
           aria-hidden="false"
           tabindex="0"
           src="{{$src}}">
   </iframe>
</div>