<?php

return [
   'projectSlug' => env('MY_PROJECT_SLUG'),
    'importDir' => env('MY_IMPORT_DIR'),
    'imagePlaceholder' => env('MY_IMAGE_PLACEHOLDER'),
    'projects' => [
        'ivnbg' => 1,
        'martinvach' => 2,
        'prompties' => 3,
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