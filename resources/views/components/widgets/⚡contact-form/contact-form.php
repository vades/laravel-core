<?php

use App\Models\Inquiry;
use App\Services\DomainManagerService;
use Livewire\Component;
use Illuminate\Http\Request;

new class extends Component
{

    public $name, $email, $message;
    public $errorMessage;

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email',
        'message' => 'required|min:5',
    ];

    public function submit(Request $request,DomainManagerService $domainManager)
    {
        $this->errorMessage = null;

        $this->validate();

        // Save data
        try {
            Inquiry::create([
                                'project_id' =>$domainManager->getProjectId(),
                                'subject' => 'Contact Form Submission',
                                'name' => $this->name,
                                'email' => $this->email,
                                'message' => $this->message,
                                'ip_address' =>  $request->ip(),
                                'user_agent' =>  $request->userAgent(),
                            ]);
            $this->reset(['name', 'email', 'message']);

            session()->flash('success', __('app.form.successContactForm'));
        } catch (\Exception $e) {
            $this->errorMessage = __('app.form.errorContactForm');
        }
    }

    public function render()
    {
        return view('components.widgets.⚡contact-form.contact-form');
    }
};