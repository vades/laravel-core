<?php
$myAppNav = [
    'home' => [
        'name' => 'home',
        'label' => 'app.nav.home',
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
    'name' => 'vades.dev',
    'logo' => 'vades-logo',
    'slogan' => 'Software Engineering',
    'metaTitle' => 'VADES Software Engineering | Finding Beauty in Everyday Moments',
    'metaDescription' => 'Transform the way you see the world. Martin Vach&#039;s photography reveals hidden beauty in everyday life, creating inspiring visual stories through unique perspective and masterful lighting.',
    'metaKeywords' => 'landscape, nature, travel, fine art, photography',
    'gatMeasurementId' => env('MY_VADES_GTAG_MEASUREMENT_ID'),
    'headerWidgets' => ['searchInContentType'=>false,'articleCategories'=>false],
    'headerNav' => [
        $myAppNav['about'],
        $myAppNav['contact'],

    ],
    'drawerNav' => [
        $myAppNav['about'],
        $myAppNav['contact'],
    ],
    'footerNav' => [
        $myAppNav['home'],
        $myAppNav['about'],
        $myAppNav['contact'],
    ],
];