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
        'params' => ['slug' => 'kontakt'],
    ],
    'about' => [
        'name' => 'pageItem',
        'label' => 'app.nav.about',
        'hasIcon' => 'info-circle',
        'uri' => 'about',
        'isExternal' => false,
        'params' => ['slug' => 'profil'],
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
    'name' => 'aitomatix.cz',
    'logo' => 'aitomatix-logo',
    'slogan' => 'AI bez humbuku',
    'metaTitle' => 'Aitomatix | Practical AI for Small and Mid-Sized Companies',
    'metaDescription' => 'Practical AI services for small and mid-sized companies: integration, private knowledge search, workflow automation, prompt skills and advice.',
    'metaKeywords' => 'AI services, AI integration, private AI, workflow automation, prompt engineering',
    'gatMeasurementId' => env('MY_AITOMATIX_GTAG_MEASUREMENT_ID'),
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
