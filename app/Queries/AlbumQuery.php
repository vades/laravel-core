<?php
declare(strict_types=1);


namespace App\Queries;

use App\Models\Content;
use App\Services\Album\AlbumService;
use App\Services\DomainManagerService;

class AlbumQuery
{
    public function __construct(private DomainManagerService $domainManager) {}

    public function homeImages(?int $take = null,): array
    {
        return collect(AlbumService::getImages($this->domainManager->getSlug()))
            ->shuffle()
            ->when($take > 0, fn($q) => $q->take($take))
            ->values()
            ->toArray()
        ;
    }

    public function imagesByDirectory(string $directory, ?int $take = null,): array
    {
        return collect(AlbumService::getImages($this->domainManager->getSlug()))
            ->where('directory', $directory)
            ->when($take > 0, fn($q) => $q->take($take))
            ->values()
            ->toArray();;
    }


    public function postImages(Content $content): ?array
    {
        if (blank($content['eventDirectory'])) {
            return null;
        }
        return null;

        /*  return collect(AlbumService::fetchPostImages())
              ->where('directory', $content['eventDirectory'])
              ->values()
              ->toArray();*/
    }
}