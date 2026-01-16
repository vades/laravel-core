<?php

namespace App\Enums;

enum ContentVisibility: string
{
    case Public = 'public';
    case Private = 'private';
    case Restricted = 'restricted';
    case Unlisted = 'unlisted';
}