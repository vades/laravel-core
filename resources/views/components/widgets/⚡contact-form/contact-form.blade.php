<div class="mx-auto mt-4">
    @if ($errorMessage)
        <x-ui.alerts variant="error" icon="exclamation-circle">
            <x-ui.alerts.description> {{ $errorMessage }}</x-ui.alerts.description>
        </x-ui.alerts>
    @endif
    @if (session()->has('success'))
            <x-ui.alerts variant="success" icon="check-circle">
                <x-ui.alerts.description>{{ session('success') }} </x-ui.alerts.description>
            </x-ui.alerts>
    @endif
    <form wire:submit.prevent="submit">
        <x-ui.fieldset>
        <x-ui.field >
            <x-ui.label>{{__('app.form.name')}}</x-ui.label>
            <x-ui.input
                    wire:model="name"
                    type="text"
                    placeholder="{{__('app.form.yourName')}}"
            />
            <x-ui.error name="name" />
        </x-ui.field>

        <x-ui.field>
           <x-ui.label>{{__('app.form.email')}}</x-ui.label>
            <x-ui.input
                    wire:model="email"
                    type="text"
                    placeholder="{{__('app.form.yourEmail')}}"
            />
            <x-ui.error name="email" />
        </x-ui.field>
        <x-ui.field>
            <x-ui.label>{{__('app.form.message')}}</x-ui.label>
            <x-ui.textarea
                    wire:model="message"
                    placeholder="{{__('app.form.leaveMessage')}}"
            />
            <x-ui.error name="message" />
        </x-ui.field>
        </x-ui.fieldset>

        <x-ui.fieldset class="mt-4">
        <div class="flex justify-center items-center gap-4">
            <x-ui.button type="submit" variant="outline">{{__('app.form.submit')}}</x-ui.button>
        </div>
        </x-ui.fieldset>
    </form>
</div>