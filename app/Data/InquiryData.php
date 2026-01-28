<?php
declare(strict_types=1);

namespace App\Data;

use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapOutputName(SnakeCaseMapper::class)]
class InquiryData extends Data
{
    /**
     * @param int $projectId
     * @param int|null $userId
     * @param bool $isRead
     * @param bool $isSpam
     * @param bool $isArchived
     * @param string $name
     * @param string $email
     * @param string|null $subject
     * @param string $message
     * @param string|null $ipAddress
     * @param string|null $userAgent
     * @param Carbon|null $termsAcceptedAt
     * @param array|null $metadata
     */
    public function __construct(
        public int $projectId,
        public ?int $userId,
        public bool $isRead,
        public bool $isSpam,
        public bool $isArchived,
        public string $name,
        public string $email,
        public ?string $subject,
        public string $message,
        public ?string $ipAddress,
        public ?string $userAgent,
        public ?Carbon $termsAcceptedAt,
        public ?array $metadata,
    ) {
    }
}