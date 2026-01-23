<?php
declare(strict_types=1);

namespace App\Data;

use Spatie\LaravelData\Data;
use App\Enums\ContentStatus;
use App\Enums\ContentVisibility;
use App\Enums\ContentContentType;
use App\Enums\Language;

class CategoryData extends Data
{
    /**
     * @param string $uuid
     * @param int $projectId
     * @param int|null $parentId
     * @param ContentStatus $status
     * @param ContentVisibility $visibility
     * @param ContentContentType $contentType
     * @param int $position
     * @param string $slug
     * @param Language $lang
     * @param string $title
     * @param string|null $excerpt
     * @param array|null $metadata
     */
    public function __construct(
        public string $uuid,
        public int $projectId,
        public ?int $parentId,
        public ContentStatus $status,
        public ContentVisibility $visibility,
        public ContentContentType $contentType,
        public int $position,
        public string $slug,
        public Language $lang,
        public string $title,
        public ?string $excerpt,
        public ?array $metadata,
    ) {
    }
}