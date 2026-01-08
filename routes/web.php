<?php

use App\Services\DomainManagerService;

$manager = app(DomainManagerService::class);
$routeFile = base_path("routes/{$manager->getSlug()}.php");

if (file_exists($routeFile)) {
    ds("Loading domain route file: {$routeFile}");
    require_once $routeFile;
} else {
    ds("Loading fallback route file: routes/default.php");
    require_once base_path('routes/default.php');
}

