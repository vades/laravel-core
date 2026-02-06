<?php

namespace App\Enums;

enum ContentContentType: string
{
    case Article = 'article';
    case Page = 'page';
    case Meta = 'meta';
    case Place = 'place';
    case Tutorial = 'tutorial';
    case Aiprompt = 'aiprompt';
}