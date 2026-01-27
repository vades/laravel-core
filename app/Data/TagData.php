<?php
declare(strict_types=1);

namespace App\Data;

use App\Enums\ContentContentType;
use App\Enums\Language;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapOutputName(SnakeCaseMapper::class)]
class TagData extends Data
{
    /**
     * @param int $projectId
     * @param ContentContentType $contentType
     * @param string $lang
     * @param string $name
     */
    public function __construct(
        public int $projectId,
        public ContentContentType $contentType,
        public Language $lang,
        public string $name,
    ) {
    }
}