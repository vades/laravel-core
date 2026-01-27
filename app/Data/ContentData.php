<?php
declare(strict_types=1);


namespace App\Data;

use App\Enums\Language;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Illuminate\Support\Carbon;
use App\Enums\ContentContentType;
use App\Enums\ContentStatus;
use App\Enums\ContentVisibility;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapOutputName(SnakeCaseMapper::class)]
class ContentData extends Data
{
    /**
     * @param string $uuid
     * @param int $projectId
     * @param int $userId
     * @param int|null $authorId
     * @param int|null $parentId
     * @param ContentContentType $contentType
     * @param ContentVisibility $visibility
     * @param string $lang
     * @param string $slug
     * @param string $title
     * @param string|null $subtitle
     * @param string|null $excerpt
     * @param string|null $content
     * @param array|null $metadata
     * @param int $position
     * @param bool $isFeatured
     * @param Carbon|null $publishedAt
     */
    public function __construct(
        public string $uuid,
        public int $projectId,
        public int $userId,
        public ?int $authorId,
        public ?int $parentId,
        public ContentContentType $contentType,
        public ContentStatus $status,
        public ContentVisibility $visibility,
        public Language $lang,
        public string $slug,
        public string $title,
        public ?string $subtitle,
        public ?string $excerpt,
        public ?string $content,
        public ?array $metadata,
        public int $position,
        public bool $isFeatured,
        public ?Carbon $publishedAt,
    ) {
    }
}