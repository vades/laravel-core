<div class="mx-auto mt-10 bg-white p-8 rounded-lg shadow">
    @if ($errorMessage)
        <x-shared.alert class="is-danger" >  {{ $errorMessage }}</x-shared.alert>
    @endif
    @if (session()->has('success'))
        <x-shared.alert class="is-success" >{{ session('success') }} </x-shared.alert>
    @endif
    <form wire:submit.prevent="submit">
        <div class="form-field">
            <label for="name" class="form-label">{{__('app.form.name')}}</label>
            <input
                    type="text"
                    id="name"
                    wire:model="name"
                    placeholder="{{__('app.form.yourName')}}"
                    class="form-input"
            />
            @error('name') <span class="form-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-field">
            <label for="email" class="form-label">{{__('app.form.email')}}</label>
            <input
                    type="email"
                    id="email"
                    wire:model="email"
                    placeholder="{{__('app.form.yourEmail')}}"
                    class="form-input"
            />
            @error('email') <span class="form-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-field">
            <label for="message" class="form-label">{{__('app.form.message')}}</label>
            <textarea
                    id="message"
                    wire:model="message"
                    placeholder="{{__('app.form.leaveMessage')}}"
                    rows="5"
                    class="form-input "
            ></textarea>
            @error('message') <span class="form-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-submit">
            <button
                    type="submit"
                    class="button-secondary"
            >
                {{__('app.form.submit')}}
            </button>
        </div>
    </form>
</div>