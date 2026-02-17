<?php

use App\Enums\ContentContentType;
use App\Models\Category;
use Livewire\Component;

new class extends Component
{
    public string $type = '';
    public string $route = '';
    public string $label = '';
    public ?string $currentCategory = null;

    public function mount(
        string $type = ContentContentType::Article->value,
        string $route = 'articleIndex',
        string $label = 'articleCategories',
        ?string $currentCategory = null
    ) {
        $this->type = $type;
        $this->route = $route;
        $this->label = $label;
        $this->currentCategory = $currentCategory ?? request()->query('category');
    }

    public function render()
    {
        $categories = Category::publishedByType($this->type)
            ->withCount('contents')->where('contents_count','>',0)->get();

        return view('components.widgets.⚡categories-dropdown.categories-dropdown', [
            'categories' => $categories,
        ]);
    }
};