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

return [
    'name' => 'laravel-core.test',
    'logo' => 'laravel-core-logo',
    'slogan' => 'Laravel demo project',
    'metaTitle' => 'Laravel Core Demo Project',
    'metaDescription' => 'A Laravel demo project showcasing a content management system with articles, places, and photo galleries.',
    'metaKeywords' => 'Laravel, demo, project, content management, articles, places, photo galleries',
    'gatMeasurementId' => null,
    'headerWidgets' => ['searchInContentType'=>['place','article'],'articleCategories'=>true, 'placeCategories'=>true],
    'headerNav' => [
        $myAppNav['tagArticle'],
        $myAppNav['photoGalleryIndex'],
        $myAppNav['about'],
        $myAppNav['contact'],
    ],
    'footerNav' => [
        $myAppNav['articleIndex'],
        $myAppNav['tagArticle'],
        $myAppNav['placeIndex'],
        $myAppNav['photoGalleryIndex'],
        $myAppNav['about'],
        $myAppNav['contact'],
        $myAppNav['termsAndConditions'],
    ],
];