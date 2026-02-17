@props(['src'])
<div  {{$attributes->class(['iframe'])}}>
   <iframe
           allowfullscreen=""
           aria-hidden="false"
           tabindex="0"
           src="{{$src}}">
   </iframe>
</div>