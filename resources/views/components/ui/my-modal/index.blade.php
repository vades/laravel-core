<div x-show="showModal"
     id="modalWindow"
        {{$attributes->class(['hidden fixed z-50 inset-0 bg-gray-900 bg-opacity-80 flex items-center justify-center px-4 modal'])}}>
    <div class="relative w-full mx-auto max-w-[1800px] shadow-xl bg-white flex flex-col dark:bg-gray-700"
         style="height: calc(100vh - 2rem); max-height: calc(100vh - 2rem);">

        <header class="flex-none flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
            <div class="text-xl font-semibold text-gray-900 dark:text-gray-400">{{$title ?? ''}}</div>
            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" @click="closeModal()">
                <x-ui.my-img-svg img="close" classList="[&>svg]:text-gray-500" />
                <span class="sr-only">Close modal</span>
            </button>
        </header>

        @isset($body)
            <div {{$body->attributes->class(['flex-1 min-h-0 overflow-y-auto p-4 flex items-center justify-center'])}}>
                {{$body}}
            </div>
        @endisset

        @isset($footer)
            <footer class="flex-none flex items-center p-4 md:p-5 border-t border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-400">
                {{$footer}}
            </footer>
        @endisset
    </div>
</div>

<script type="text/javascript">
    document.addEventListener('alpine:init', () => {
        Alpine.data('modalControl', () => ({
            showModal: false,
            openModal() {
                this.showModal = !this.showModal;
                document.body.classList.toggle('overflow-y-hidden');
                document.getElementById('modalWindow').classList.remove('hidden');
            },
            closeModal() {
                this.showModal = false;
                document.body.classList.remove('overflow-y-hidden');
            },
            closeModalOnEscape(event) {
                if (event.keyCode === 27) {
                    this.closeModal();
                }
            }
        }));
    });
</script>