<?php
declare(strict_types=1);

namespace App\Data;

use Spatie\LaravelData\Data;
use Illuminate\Support\Carbon;

class ContentAnalytic extends Data
{
    /**
     * @param int $contentId
     * @param int $projectId
     * @param int $views
     * @param int $uniqueViews
     * @param int $downloads
     * @param Carbon|null $lastViewedAt
     * @param array|null $metadata
     */
    public function __construct(
        public int $contentId,
        public int $projectId,
        public int $views,
        public int $uniqueViews,
        public int $downloads,
        public ?Carbon $lastViewedAt,
        public ?array $metadata,
    ) {
    }
}