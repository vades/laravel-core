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
    'logo' => 'vades-logo-text',
    'slogan' => 'The Whole Stack. One Engineer.',
    'metaTitle' => 'Martin Vach — From IoT to AI: 20 Years of Shipping Software',
    'metaDescription' => 'Most engineers own one layer. Martin Vach has spent 20 years working across all of them — infrastructure, frontend, and AI — on projects that could not afford to fail.',
    'metaKeywords' => 'php, typescript, angular, laravel, symfony, mysql, postgresql, ai',
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
