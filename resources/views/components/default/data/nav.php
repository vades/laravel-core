<?php
$myAppNav = [
    'home' => [
        'name' => 'home',
        'label' => 'home',
        'uri' => 'home',
        'isExternal' => false,
    ],
    'articleIndex' => [
        'name' => 'articleIndex',
        'label' => 'app.nav.articleIndex',
        'uri' => 'blog',
        'isExternal' => false,
    ],
    'articleShow' => [
        'name' => 'articleShow',
        'label' => 'app.nav.articleShow',
        'uri' => 'blog/item-slug',
        'isExternal' => false,
        'params' => ['slug' => 'item-slug']
    ],
    'tagArticle' => [
        'name' => 'tagArticle',
        'label' => 'app.nav.tags',
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
        'label' => 'app.nav.contact',
        'hasIcon' => 'contact',
        'uri' => 'contact',
        'isExternal' => false,
        'params' => ['slug' => 'contact'],
    ],
    'about' => [
        'name' => 'pageItem',
        'label' => 'app.nav.about',
        'hasIcon' => 'info-circle',
        'uri' => 'nav.about',
        'isExternal' => false,
        'params' => ['slug' => 'about'],
    ],
    'termsAndConditions' => [
        'name' => 'pageItem',
        'label' => 'app.nav.termsAndConditions',
        'hasIcon' => 'info-circle',
        'uri' => 'nav.about',
        'isExternal' => false,
        'params' => ['slug' => 'terms-and-conditions'],
    ],
];

return[
    'slogan' => 'Laravel demo project',
    'header' => [
        $myAppNav['articleIndex'],
        $myAppNav['tagArticle'],
        $myAppNav['about'],
        $myAppNav['contact'],
    ],
    'footer' => [
        $myAppNav['articleIndex'],
        $myAppNav['tagArticle'],
        $myAppNav['about'],
        $myAppNav['contact'],
        $myAppNav['termsAndConditions'],
    ],
];