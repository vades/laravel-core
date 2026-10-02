Below is a complete minimal solution that supports:

```blade
{!! widget('gallery') !!}

{!! widget('gallery', [
    'id' => 123,
    'size' => 'medium',
]) !!}
```

and inside CMS content:

```markdown
[gallery]

[gallery id="123" size="medium"]
```

Both use the **same WidgetManager and renderer classes**.

---

# 1. Helper

## app/Helpers/widget.php

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

---

# 2. composer.json

```json
{
    "autoload": {
        "files": ["app/Helpers/widget.php"]
    }
}
```

Run:

```bash
composer dump-autoload
```

---

# 3. WidgetContentType Enum

## app/Enums/WidgetContentType.php

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
}
```

---

# 4. Widget Manager

## app/Services/Widgets/WidgetManager.php

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

        if (! $widget) {
            return '';
        }

        $rendererClass = $widget->content_type->renderer();

        return app($rendererClass)
            ->render($widget, $options);
    }
}
```

---

# 5. Abstract Renderer

## app/Services/Widgets/Renderers/AbstractWidgetRenderer.php

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

# 6. Standard Widget Renderer

## app/Services/Widgets/Renderers/WidgetRenderer.php

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

# 7. Feature Renderer

## app/Services/Widgets/Renderers/FeatureRenderer.php

```php
<?php

namespace App\Services\Widgets\Renderers;

use App\Models\Widget;

class FeatureRenderer extends AbstractWidgetRenderer
{
    public function render(
        Widget $widget,
        array $options = []
    ): string {

        return view('widgets.feature', [
            'widget' => $widget,
            'options' => $options,
        ])->render();
    }
}
```

---

# 8. Livewire Renderer

## app/Services/Widgets/Renderers/LivewireRenderer.php

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

# 9. Widget Blade View

## resources/views/widgets/widget.blade.php

```blade
<div class="widget">

    @if(!empty($options['title']))
        <h2>{{ $options['title'] }}</h2>
    @endif

    {!! $widget->rendered_content !!}

</div>
```

---

# 10. Feature Blade View

## resources/views/widgets/feature.blade.php

```blade
<section class="feature-widget">

    <h2>{{ $widget->title }}</h2>

    <pre>{{ json_encode($options, JSON_PRETTY_PRINT) }}</pre>

</section>
```

---

# 11. Livewire Blade View

## resources/views/widgets/livewire.blade.php

```blade
@livewire($widget->metadata['component'])
```

---

# 12. Shortcode Parser

## app/Services/Content/ShortcodeParser.php

```php
<?php

namespace App\Services\Content;

use App\Services\Widgets\WidgetManager;

class ShortcodeParser
{
    public function __construct(
        private WidgetManager $widgetManager
    ) {
    }

    public function parse(string $content): string
    {
        return preg_replace_callback(
            '/\[([a-zA-Z0-9\-_]+)(.*?)\]/',
            function ($matches) {

                $slug = $matches[1];

                $options = $this->parseAttributes(
                    $matches[2]
                );

                return $this->widgetManager
                    ->render($slug, $options);
            },
            $content
        );
    }

    private function parseAttributes(
        string $attributes
    ): array {

        preg_match_all(
            '/(\w+)="([^"]*)"/',
            $attributes,
            $matches,
            PREG_SET_ORDER
        );

        $result = [];

        foreach ($matches as $match) {
            $result[$match[1]] = $match[2];
        }

        return $result;
    }
}
```

---

# 13. Content Renderer

## app/Services/Content/ContentRenderer.php

```php
<?php

namespace App\Services\Content;

class ContentRenderer
{
    public function render(string $content): string
    {
        $content = app(ShortcodeParser::class)
            ->parse($content);

        return str($content)
            ->markdown()
            ->toString();
    }
}
```

---

# 14. Widget Model

Replace your accessor with:

```php
protected function renderedContent(): Attribute
{
    return Attribute::make(
        get: fn () => app(
            \App\Services\Content\ContentRenderer::class
        )->render(
            $this->content ?? ''
        )
    );
}
```

---

# Usage Examples

## Blade

```blade
{!! widget('gallery') !!}
```

```blade
{!! widget('gallery', [
    'id' => 123,
    'size' => 'medium',
]) !!}
```

---

## CMS Content

```markdown
Welcome to our website.

[gallery]

[gallery id="123" size="medium"]

[gallery id="456" size="large"]
```

All of these ultimately execute:

```php
app(WidgetManager::class)
    ->render($slug, $options);
```

so there is only **one widget system**, one renderer pipeline, and one place to maintain widget logic.
