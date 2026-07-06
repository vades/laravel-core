<?php

return [
   'projectSlug' => env('MY_PROJECT_SLUG'),
    'importDir' => env('MY_IMPORT_DIR'),
    'imagePlaceholder' => env('MY_IMAGE_PLACEHOLDER'),
    'cacheDuration' => (int) env('MY_CACHE_DURATION', 86400),
    'auth'=>[
        'userName' => env('MY_USER_NAME'),
        'userEmail' => env('MY_USER_EMAIL'),
        'userPassword' => env('MY_USER_PASSWORD'),
    ],
    'image' => [
        'domain' => env('MY_IMAGE_DOMAIN'),
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
    // Project-specific settings
    'name' => '',
    'logo' => '',
    'slogan' => '',
    'searchInContentType' =>[],
    'metaTitle' => '',
    'metaDescription' => '',
    'metaKeywords' => '',
    'gatMeasurementId' => null,
    'headerNav' => [],
    'footerNav' => [ ],

];
