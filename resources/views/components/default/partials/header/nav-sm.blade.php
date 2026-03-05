
<div x-data="{ drawerOpen: false }" {{$attributes->class(['flex items-center gap-4 lg:hidden'])}}">
        <!-- drawer init and toggle -->
        <div class="text-center">
                <x-ui.button variant="outline" size="sm" iconAfter="bars-3" @click="drawerOpen = true"></x-ui.button>
        </div>

        <!-- drawer component -->
        <div
                x-show="drawerOpen"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="translate-x-full"
                class="fixed top-0 right-0 z-40 h-screen p-4 overflow-y-auto bg-white w-80 dark:bg-neutral-900"
                tabindex="-1"
                aria-labelledby="drawer-right-label"
                style="display: none;">
                <div class="flex items-center justify-between mb-4 border-b border-black/10 dark:border-white/10 pb-2">
                        <h5 id="drawer-right-label">Menu</h5>
                        <x-ui.button variant="outline" size="sm" iconAfter="x-mark" @click="drawerOpen = false"></x-ui.button>
                </div>
                <x-ui.navlist>
                        @foreach($globalNav['header'] as $key => $val)
                                <x-ui.navlist.item icon="{{$val['icon'] ?? ''}}"
                                                  label="{{ __($val['label'] ?? '') }}"
                                                  href="{{ route($val['name'], $val['params'] ?? []) }}" />
                        @endforeach

                </x-ui.navlist>
        </div>
</div>