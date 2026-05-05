@props(['src'])
<div  {{$attributes->class(['my-iframe-wrapper'])}}>
   <iframe
           class="my-iframe"
           allowfullscreen=""
           aria-hidden="false"
           tabindex="0"
           src="{{$src}}">
   </iframe>
</div>
