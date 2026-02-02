<?php
$myAppNav = [
    'home' => [
        'name' => 'home',
        'label' => 'home',
        'uri' => 'home',
        'isExternal' => false,
    ],
    'blogList' => [
        'name' => 'blogList',
        'label' => 'blogList',
        'uri' => 'blog',
        'isExternal' => false,
    ],
    'blogItem' => [
        'name' => 'blogItem',
        'label' => 'blogItem',
        'uri' => 'blog/item-slug',
        'isExternal' => false,
        'params' => ['postId' => 'item-slug']
    ],
    'blogCategoryList' => [
        'name' => 'blogCategoryList',
        'label' => 'blogCategoryList',
        'uri' => 'blog/categories',
        'isExternal' => false,
    ],
    'blogTagList' => [
        'name' => 'blogTagList',
        'label' => 'blogTagList',
        'uri' => 'blog/tags',
        'isExternal' => false,
    ],
    'placeList' => [
        'name' => 'placeList',
        'label' => 'places',
        'uri' => 'places',
        'isExternal' => false,

    ],
    'placeItem' => [
        'name' => 'placeItem',
        'label' => 'placeItem',
        'uri' => 'places/place-item',
        'isExternal' => false,
        'params' => ['placeId' => 'place-item-slug'],
    ],
    'placeCategoryList' => [
        'name' => 'placeCategoryList',
        'label' => 'placeCategoryList',
        'uri' => 'places/categories',
        'isExternal' => false,
    ],
    'albumList' => [
        'name' => 'albumList',
        'label' => 'albumList',
        'uri' => 'albums',
        'isExternal' => false,
    ],
    'albumEventList' => [
        'name' => 'albumEventList',
        'label' => 'photoGallery',
        'uri' => 'albums/album-id',
        'isExternal' => false,
        'params' => ['albumId' => env('MY_PROJECT_NAME')],
    ],
    'albumGallery' => [
        'name' => 'albumGallery',
        'label' => 'gallery',
        'uri' => 'albums/album-id/event-id',
        'isExternal' => false,
        'params' => ['albumId' => 'album-id', 'eventId' => 'event-id'],
    ],
    'contact' => [
        'name' => 'pageItem',
        'label' => 'contact',
        'hasIcon' => 'contact',
        'uri' => 'contact',
        'isExternal' => false,
        'params' => ['slug' => 'contact'],
    ],
    'about' => [
        'name' => 'pageItem',
        'label' => 'about',
        'hasIcon' => 'info-circle',
        'uri' => 'about',
        'isExternal' => false,
        'params' => ['slug' => 'about'],
    ],
];

return[
    'header' => [
        $myAppNav['about'],
        $myAppNav['contact'],
    ],
    'footer' => [
        $myAppNav['about'],
        $myAppNav['contact'],
    ],
];