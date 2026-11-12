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
    'service' => [
        'name' => 'serviceIndex',
        'label' => 'app.nav.services',
        'hasIcon' => 'service',
        'uri' => 'service',
        'isExternal' => false,
    ],
    'reference' => [
        'name' => 'referenceIndex',
        'label' => 'app.nav.references',
        'hasIcon' => 'reference',
        'uri' => 'reference',
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

return [
    'name' => 'vades.dev',
    'logo' => 'vades-logo-text',
    'slogan' => 'Solid software and AI that works',
    'metaTitle' => 'Martin Vach | Solid software and AI that works',
    'metaDescription' => 'Senior software engineer with 20 years of experience. I help companies modernize their systems and add AI securely, with clear control of costs.',
    'metaKeywords' => 'software engineering, AI implementation, AI integration, legacy modernization, software consulting',
    'gatMeasurementId' => env('MY_VADES_GTAG_MEASUREMENT_ID'),
    'headerWidgets' => ['searchInContentType' => false, 'articleCategories' => false],
    'headerNav' => [
        $myAppNav['about'],
        $myAppNav['service'],
        $myAppNav['reference'],
        $myAppNav['contact'],

    ],
    'drawerNav' => [
        $myAppNav['home'],
        $myAppNav['service'],
        $myAppNav['reference'],
        $myAppNav['about'],
        $myAppNav['contact'],
    ],
    'footerNav' => [
        $myAppNav['home'],
        $myAppNav['service'],
        $myAppNav['reference'],
        $myAppNav['about'],
        $myAppNav['contact'],
    ],
];
