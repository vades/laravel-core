<?php

return [
   'projectSlug' => env('MY_PROJECT_SLUG'),
    'importDir' => env('MY_IMPORT_DIR'),
    'imagePlaceholder' => env('MY_IMAGE_PLACEHOLDER'),
    'image' => [
        'featured' => 'featured.jpg',
        'cover' => 'cover.jpg',
        'placeholder' => [
            'page' => 'storage/images/placeholders/page.jpg',
            'article' => 'storage/images/placeholders/article.jpg',
            'place' => 'storage/images/placeholders/place.jpg',
        ],
    ],
    'album' => [
        'default' => 'ivnbg',
        'dir' => [
            'source' => public_path() . '/storage/albums',
            'target' => public_path() . '/storage/albums',
        ],
        'file' => [
            'album' => 'albums.json',
            'event' => 'events.json',
            'image' => 'images.json',

        ],
        'url' => env('MY_ALBUM_URL'),
        'albumsUrl' => env('MY_ALBUM_ALBUMS_URL'),
        'eventsUrl' => env('MY_ALBUM_EVENTS_URL'),
        'imagesUrl' => env('MY_ALBUM_IMAGES_URL'),
        'srcDir' => 'src',
        'thumbDir' => 'thumb',
        'thumbWidth' => 200,
        'featured' => 'featured.jpg',
        'cover' => 'cover.jpg',
    ],

];