<?php
declare(strict_types=1);


namespace App\Queries;

use App\Models\Content;
use App\Services\Album\AlbumService;
use App\Services\DomainManagerService;

class AlbumQuery
{
    public function __construct(private DomainManagerService $domainManager) {}

   public  function homeImages(): array
    {
        return collect(AlbumService::getImages($this->domainManager->getSlug()))
            ->shuffle()
            ->take(6)
            ->values()
            ->toArray();
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