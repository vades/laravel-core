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
        'uri' => 'photo-gallery',
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
        'uri' => 'about',
        'isExternal' => false,
        'params' => ['slug' => 'about'],
    ],
    'termsAndConditions' => [
        'name' => 'pageItem',
        'label' => 'app.nav.termsAndConditions',
        'hasIcon' => 'info-circle',
        'uri' => 'terms-conditions',
        'isExternal' => false,
        'params' => ['slug' => 'terms-and-conditions'],
    ],
];

return[
    'name' => 'ivnbg.com',
    'logo' => 'ivnbg-logo',
    'slogan' => 'Small guide to Nuremberg city',
    'metaTitle' => 'Nuremberg City Guide - Explore the Best of Nuremberg with Local Insights',
    'metaDescription' => 'Explore Nuremberg through the eyes of locals. Discover photo galleries, historical stories, hidden gems, and insider tips covering everything from the Imperial Castle to off-the-beaten-path courtyards.',
    'metaKeywords' => 'Nuremberg, guide, city, travel, places, articles, photo galleries',
    'gatMeasurementId' => env('MY_IVNBG_GTAG_MEASUREMENT_ID'),
    'headerWidgets' => ['searchInContentType'=>['place','article'],'placeCategories'=>true],
    'headerNav' => [
        $myAppNav['photoGalleryIndex'],
        $myAppNav['about'],

    ],
    'drawerNav' => [
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