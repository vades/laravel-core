<?php
declare(strict_types=1);

namespace App\Data;

use App\Enums\ContentContentType;
use Spatie\LaravelData\Data;

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
        public string $lang,
        public string $name,
    ) {
    }
}