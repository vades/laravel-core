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
    'placeIndex' => [
        'name' => 'placeIndex',
        'label' => 'app.nav.placeIndex',
        'uri' => 'places',
        'isExternal' => false,

    ],
    'photoGalleryIndex' => [
        'name' => 'photoGalleryIndex',
        'label' => 'app.nav.photoGallery',
        'isExternal' => false,
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
    'name' => 'ivnbg.com',
    'logo' => 'ivnbg-logo',
    'slogan' => 'Small guide to Nuremberg city',
    'searchInContentType' =>['place','article'],
    'headerNav' => [
        /*$myAppNav['articleIndex'],
        $myAppNav['tagArticle'],*/
        $myAppNav['placeIndex'],
        $myAppNav['photoGalleryIndex'],
        $myAppNav['about'],

    ],
    'footerNav' => [
        /*$myAppNav['articleIndex'],
        $myAppNav['tagArticle'],*/
        $myAppNav['placeIndex'],
        $myAppNav['photoGalleryIndex'],
        $myAppNav['about'],
        $myAppNav['contact'],
        $myAppNav['termsAndConditions'],
    ],
];