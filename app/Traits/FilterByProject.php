<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Services\DomainManagerService;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait FilterByProject
{
    protected static function bootFilterByProject()
    {
        // 1. Filter Queries
        static::addGlobalScope('project_scope', function (Builder $builder) {
            $manager = app(DomainManagerService::class);
            $projectId = $manager->getProjectId();

            if ($projectId) {
                $builder->where('project_id', $projectId);
            } else {
                // Safety: If no project identified, return no results
                $builder->whereRaw('1 = 0');
            }
        });

        // 2. Auto-assign ID on Create
        static::creating(function (Model $model) {
            $manager = app(DomainManagerService::class);
            if (!$model->project_id && $manager->getProjectId()) {
                $model->project_id = $manager->getProjectId();
            }
        });
    }
}
