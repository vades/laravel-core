<div class="mx-auto mt-4">
    @if ($errorMessage)
        <div role="alert" class="alert alert-error alert-soft">
            <span>{{ $errorMessage }}</span>
        </div>
    @endif
    @if (session()->has('success'))
        <div role="alert" class="alert alert-success alert-soft">
            <span>{{ session('success') }}</span>
        </div>
    @endif
    <form wire:submit="submit">
        <fieldset class="my-fieldset">
            <div class="my-form-field has-w-full">
                <label class="floating-label">
                    <span>{{__('app.form.name')}}</span>
                    <input type="text" id="name" placeholder="{{__('app.form.name')}}" class="input input-md input-primary"
                           wire:model="name"/>

                </label>
                @error('name')
                <span class="my-form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="my-form-field has-w-full">
                <label class="floating-label">
                    <span>{{__('app.form.email')}}</span>
                    <input type="text" id="email" placeholder="{{__('app.form.email')}}" class="input input-md input-primary"
                           wire:model="email"/>

                </label>
                @error('email')
                <span class="my-form-error">{{ $message }}</span>
                @enderror
            </div>
            <div class="my-form-field has-w-full">
                <label class="floating-label">
                    <span>{{__('app.form.message')}}</span>
                    <textarea class="textarea"  id="message" placeholder="{{__('app.form.message')}}" wire:model="message"></textarea>
                </label>
                @error('message')
                <span class="my-form-error">{{ $message }}</span>
                @enderror
            </div>
        </fieldset>

        <fieldset class="my-fieldset">
            <div class="my-form-submit">
                <button type="submit" class="btn btn-wide btn-primary">{{__('app.form.submit')}}</button>
            </div>
        </fieldset>
    </form>
</div>
