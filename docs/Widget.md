For a Laravel CMS-style project, this is the architecture I would implement from the start.

Benefits:

- Simple Blade API
- Type-safe widget types via Enum
- Dynamic content support
- Extensible renderers
- Clean separation of concerns
- Supports arbitrary options
- Easy caching
- No controller involvement

---

# Blade Usage

Simple:

```blade
{!! widget('homepage-hero') !!}
```

With options:

```blade
{!! widget('homepage-hero', [
    'title' => 'Welcome',
    'level' => 2,
]) !!}

{!! widget('blog-list', [
    'limit' => 5,
    'category' => 'featured',
]) !!}
```

---

# Helper

`app/Helpers/widget.php`

```php
<?php

use App\Services\Widgets\WidgetManager;

if (! function_exists('widget')) {

    function widget(
        string $slug,
        array $options = []
    ): string {
        return app(WidgetManager::class)
            ->render($slug, $options);
    }
}
```

Register:

```json
{
    "autoload": {
        "files": ["app/Helpers/widget.php"]
    }
}
```

```bash
composer dump-autoload
```

---

# WidgetContentType Enum

`app/Enums/WidgetContentType.php`

```php
<?php

namespace App\Enums;

use App\Services\Widgets\Renderers\FeatureRenderer;
use App\Services\Widgets\Renderers\LivewireRenderer;
use App\Services\Widgets\Renderers\WidgetRenderer;

enum WidgetContentType: string
{
    case Widget = 'widget';
    case Livewire = 'livewire';
    case Feature = 'feature';

    public function renderer(): string
    {
        return match ($this) {
            self::Widget => WidgetRenderer::class,
            self::Livewire => LivewireRenderer::class,
            self::Feature => FeatureRenderer::class,
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
```

---

# Widget Manager

`app/Services/Widgets/WidgetManager.php`

```php
<?php

namespace App\Services\Widgets;

use App\Models\Widget;
use Illuminate\Support\Facades\Cache;

class WidgetManager
{
    public function render(
        string $slug,
        array $options = []
    ): string {
        $widget = Cache::remember(
            "widget:{$slug}",
            now()->addHour(),
            fn () => Widget::query()
                ->publishedByType()
                ->where('slug', $slug)
                ->first()
        );

        if (!$widget) {
            return '';
        }

        $rendererClass = $widget->content_type->renderer();

        return app($rendererClass)
            ->render($widget, $options);
    }
}
```

---

# Abstract Renderer

`app/Services/Widgets/Renderers/AbstractWidgetRenderer.php`

```php
<?php

namespace App\Services\Widgets\Renderers;

use App\Models\Widget;

abstract class AbstractWidgetRenderer
{
    abstract public function render(
        Widget $widget,
        array $options = []
    ): string;
}
```

---

# Standard Content Widget

`app/Services/Widgets/Renderers/WidgetRenderer.php`

```php
<?php

namespace App\Services\Widgets\Renderers;

use App\Models\Widget;

class WidgetRenderer extends AbstractWidgetRenderer
{
    public function render(
        Widget $widget,
        array $options = []
    ): string {
        return view('widgets.widget', [
            'widget' => $widget,
            'options' => $options,
        ])->render();
    }
}
```

---

# Feature Renderer

`app/Services/Widgets/Renderers/FeatureRenderer.php`

```php
<?php

namespace App\Services\Widgets\Renderers;

use App\Models\Feature;
use App\Models\Widget;

class FeatureRenderer extends AbstractWidgetRenderer
{
    public function render(
        Widget $widget,
        array $options = []
    ): string {

        $limit = $options['limit'] ?? 10;

        $features = Feature::query()
            ->published()
            ->orderBy('position')
            ->limit($limit)
            ->get();

        return view('widgets.feature', [
            'widget' => $widget,
            'features' => $features,
            'options' => $options,
        ])->render();
    }
}
```

---

# Livewire Renderer

`app/Services/Widgets/Renderers/LivewireRenderer.php`

```php
<?php

namespace App\Services\Widgets\Renderers;

use App\Models\Widget;

class LivewireRenderer extends AbstractWidgetRenderer
{
    public function render(
        Widget $widget,
        array $options = []
    ): string {

        return view('widgets.livewire', [
            'widget' => $widget,
            'options' => $options,
        ])->render();
    }
}
```

---

# Standard Widget View

`resources/views/widgets/widget.blade.php`

```blade
<div class="widget">
    {!! $widget->rendered_content !!}
</div>
```

---

# Feature View

`resources/views/widgets/feature.blade.php`

```blade
<section>
    <h2>{{ $widget->title }}</h2>

    @foreach($features as $feature)
        <div>
            <h3>{{ $feature->title }}</h3>
            <p>{{ $feature->description }}</p>
        </div>
    @endforeach
</section>
```

---

# Livewire View

Example:

`resources/views/widgets/livewire.blade.php`

```blade
@livewire($widget->metadata['component'])
```

or

```blade
<livewire:contact-form />
```

---

# Example Widget Records

| slug              | content_type |
| ----------------- | ------------ |
| homepage-hero     | widget       |
| homepage-features | feature      |
| contact-form      | livewire     |

---

# Example Calls

Homepage hero:

```blade
{!! widget('homepage-hero', [
    'title' => 'Welcome'
]) !!}
```

Features:

```blade
{!! widget('homepage-features', [
    'limit' => 6
]) !!}
```

Blog list:

```blade
{!! widget('blog-list', [
    'limit' => 10,
    'category' => 'featured',
    'showImages' => true,
]) !!}
```

---

# Future Widget Type

Adding a new widget:

```php
case BlogList = 'blog-list';
```

```php
self::BlogList => BlogListRenderer::class,
```

Create:

```text
app/Services/Widgets/Renderers/BlogListRenderer.php
```

No changes to:

- helper
- manager
- blade syntax
- existing renderers

Only the enum and the new renderer need to be added, which keeps the system easy to maintain as the number of widget types grows.
