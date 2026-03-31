<?php

use App\Enums\ContentContentType;
use App\Models\Content;
use Livewire\Component;

new class extends Component
{
    public string $query = '';
    public $results = [];
    public int $selectedResult = 0;
    public string $placeholderText = 'Search in ....';
    public array $contentType = [];

    /**
     * Mount method to receive parameters from the parent view
     */
    public function mount(array $contentType = [], string $placeholderText = '')
    {
        $this->contentType = $contentType;
        $this->placeholderText = $placeholderText;
    }
    /**
     * This method is called whenever the 'query' public property is updated.
     * It performs a search for products based on the query.
     */
    public function updatedQuery()
    {
        $this->results = Content::published()
                             ->where(function($query) {
                                 $query->where('title', 'like', '%' . $this->query . '%')
                                       ->orWhere('excerpt', 'like', '%' . $this->query . '%');
                             })
                             ->whereIn('content_type', $this->contentType)
                             ->get();
        $this->selectedResult = 0; // Auswahl zurücksetzen bei neuer Suche
    }

    public function moveSelectionDown()
    {
        if (count($this->results) === 0) return;
        if ($this->selectedResult < count($this->results) - 1) {
            $this->selectedResult++;
        }
    }

    public function moveSelectionUp()
    {
        if (count($this->results) === 0) return;
        if ($this->selectedResult > 0) {
            $this->selectedResult--;
        }
    }

    /**
     * This method is called when a search result is clicked.
     * It sets the query to the name of the selected product and clears the search results.
     *
     * @param int $id The ID of the selected product.
     */
    public function selectResult($id = null)
    {
        try {
            // Wenn kein postId übergeben wurde, wähle das aktuell selektierte
            if ($id === null && isset($this->results[$this->selectedResult])) {
                $id = $this->results[$this->selectedResult]->id;
            }
            $item = Content::find($id);
            \Fruitcake\LaravelDebugbar\Facades\Debugbar::info("Selected item: " . ($item ? $item->title : 'None'));
            if ($item) {

                switch ($item->content_type->value) {
                    case ContentContentType::Page->value:
                        return redirect()->route('pageItem', $item->slug);
                    case ContentContentType::Article->value:

                        return redirect()->route('articleShow', $item->slug);
                    case ContentContentType::Place->value:
                        return redirect()->route('placeShow', $item->slug);
                    case ContentContentType::Tutorial->value:

                    case ContentContentType::Guide->value:
                        break;
                    default:
                        // Do nothing
                        break;
                }
            }
        } catch (\Throwable $e) {
            if (config('app.debug')) {
                throw $e;
            }
            // Im Produktionsmodus: Fehler ignorieren, nichts tun
        }
    }

    public function render()
    {
        return view('components.widgets.⚡search-suggestion.search-suggestion');
    }
};