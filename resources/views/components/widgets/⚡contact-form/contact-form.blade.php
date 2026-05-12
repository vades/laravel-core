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
    <form wire:submit.prevent="submit">
        <fieldset class="fieldset">
            <label class="floating-label">
                <input type="text" placeholder="{{__('app.form.name')}}" class="input input-md"  wire:model="name" />
                
            </label>
       
      
        <x-ui.field >
            <x-ui.label>{{__('app.form.name')}}</x-ui.label>
            <x-ui.input
                    wire:model="name"
                    type="text"
                    placeholder="{{__('app.form.yourName')}}"
            />
            <x-ui.error name="name" />
        </x-ui.field>

         <label class="floating-label">
                <input type="text" placeholder="{{__('app.form.email')}}" class="input input-md"  wire:model="email" />
                
            </label>

        <x-ui.field>
           <x-ui.label>{{__('app.form.email')}}</x-ui.label>
            <x-ui.input
                    wire:model="email"
                    type="text"
                    placeholder="{{__('app.form.yourEmail')}}"
            />
            <x-ui.error name="email" />
        </x-ui.field>
         <label class="floating-label">
        <textarea class="textarea" placeholder="{{__('app.form.message')}}" wire:model="message"></textarea>
         </label>
        <x-ui.field>
            <x-ui.label>{{__('app.form.message')}}</x-ui.label>
            <x-ui.textarea
                    wire:model="message"
                    placeholder="{{__('app.form.leaveMessage')}}"
            />
            <x-ui.error name="message" />
        </x-ui.field>
         </fieldset>

         <fieldset class="fieldset">
        <div class="flex justify-center items-center gap-4">
            <a type="submit" class="btn btn-wide btn-primary">{{__('app.form.submit')}}</a>
        </div>
         </fieldset>
    </form>
</div>
