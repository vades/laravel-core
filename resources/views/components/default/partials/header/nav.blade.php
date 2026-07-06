<div class="drawer drawer-end my-drawer">
    <input id="my-drawer-1" type="checkbox" class="drawer-toggle" />
    <div class="drawer-content">
        <!-- Navbar -->
        <div class="navbar">
            <div class="my-drawer-btn-wrapper">
                <label for="my-drawer-1" aria-label="open sidebar" class="btn btn-square btn-ghost">
                    <x-ui.my-img-svg img="bars-3" classList="[&>svg]:text-gray-500" />
                </label>
            </div>
            <div class="my-drawer-menu-horizontal">
                <ul class="menu menu-horizontal">
                    @foreach(config('myapp.headerNav') as $key => $val)
                        <li class="my-menu-item {{$val['name'].'-'.$val['uri']}} item-{{$key}}">
                            <a title="{{ __($val['label'] ?? '') }}" href="{{ route($val['name'], $val['params'] ?? []) }}" >{{ __($val['label'] ?? '') }}</a></li>

                    @endforeach
                </ul>
            </div>
        </div>

    </div>
    <div class="drawer-side">
        <label for="my-drawer-1" aria-label="close sidebar" class="drawer-overlay"></label>
        <ul class="menu">
            @foreach(config('myapp.headerNav') as $key => $val)
                <li class="my-menu-item {{$val['name'].'-'.$val['uri']}} item-{{$key}}">
                    <a title="{{ __($val['label'] ?? '') }}" href="{{ route($val['name'], $val['params'] ?? []) }}" >{{ __($val['label'] ?? '') }}</a></li>

            @endforeach
        </ul>
    </div>
</div>
