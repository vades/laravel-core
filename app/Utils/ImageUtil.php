<?php
declare(strict_types=1);


namespace App\Utils;

class ImageUtil
{
   public static function isImageFile(string $filename): bool
   {
       $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'tiff', 'svg'];
       $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
       return in_array($extension, $imageExtensions, true);
   }
}