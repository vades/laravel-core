<span {{$attributes->class(['relative inline-flex bg-skin-base text-skin-base font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300'])}}>
    <span>
         {{ $slot }}
    </span>

     @isset($notify)
        <span {{$notify->attributes->class(['absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -end-2 dark:border-gray-900'])}}>{{$notify}}</span>
    @endisset
</span>