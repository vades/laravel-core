<?php

return [
   'projectSlug' => env('MY_PROJECT_SLUG'),
    'importDir' => env('MY_IMPORT_DIR'),
    'imagePlaceholder' => env('MY_IMAGE_PLACEHOLDER'),
    'gatMeasurementId' => env('MY_GTAG_MEASUREMENT_ID'),
    'cacheDuration' => (int) env('MY_CACHE_DURATION', 86400),
    'image' => [
        'featured' => 'featured.jpg',
        'cover' => 'cover.jpg',
        'svgPath' => 'app/public/images/svg',
        'placeholder' => [
            'page' => 'storage/images/placeholders/page.jpg',
            'article' => 'storage/images/placeholders/article.jpg',
            'place' => 'storage/images/placeholders/place.webp',
        ],
    ],
    'album' => [
        'default' => 'ivnbg',
        'storageDir' => 'app/public/albums',
        'dir' => [
            'source' => storage_path() . '/app/public/albums',
            'target' => storage_path() . '/app/public/albums',
        ],
        'file' => [
            'albums' => 'albums.json',
            'events' => 'events.json',
            'images' => 'images.json',

        ],
        'url' => env('MY_ALBUM_URL'),
        'srcDir' => 'src',
        'thumbDir' => 'thumb',
        'thumbWidth' => 200,
        'featured' => 'featured.jpg',
        'cover' => 'cover.jpg',
    ],

];