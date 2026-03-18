<?php

namespace App\Services\Album;

use Carbon\Carbon;
use Exception;

class AlbumGeneratorService
{
    private string $sourceDir;

    private string $targetDir;

    private string $url;

    private AlbumDataResource $albums;
    private array $events = [];
    private array $images = [];

    private array $errors = [];

    public function getErrors(): array
    {
        return $this->errors;
    }

    private array $success = [];

    public function getSuccess(): array
    {
        return $this->success;
    }


    public function __construct(string $url)
    {
        $this->sourceDir = config('myapp.album.dir.source');
        $this->targetDir = config('myapp.album.dir.target');
        $this->url = $url;
        $this->albums = new AlbumDataResource();

    }

    /**
     * @throws Exception
     */
    public function handle(): void
    {

        $this->readAlbumDir($this->sourceDir);
        $this->readEventDir($this->sourceDir);


    }

    private function readAlbumDir(string $sourceDir): void
    {
        $directories = array_filter(glob($sourceDir . '/*'), 'is_dir');
        if (empty($directories)) {
            throw new Exception('No album directories found in: ' . $this->sourceDir);
        }

        $directories = array_map('basename', $directories);
        $this->albums->data = $this->parseCoverFiles($directories, $sourceDir);
        $filePath = config('myapp.album.dir.target') . '/' . config('myapp.album.file.albums');
        $this->storeJsonFile($this->albums, $filePath);
        //dd( 'done readAlbumDir');
    }

    private function readEventDir($sourceDir): void
    {
        $events = [];

        foreach ($this->albums->data as $album) {
            $directories = array_filter(glob($sourceDir . '/' . $album['id'] . '/*'), 'is_dir');


            if (empty($directories)) {
                throw new Exception('No event directories found in: ' . $this->sourceDir);
            }

            $directories = array_map('basename', $directories);
            $event = new AlbumDataResource();
            $event->data = $this->parseCoverFiles($directories, $sourceDir . '/' . $album['id'], $album['id']);
            $this->events[$album['id']] = $event;
        }

        foreach ($this->events as $album => $eventList) {
            $targetFilePath = config('myapp.album.dir.target') . '/' .$album. '/'.config('myapp.album.file.events');
            $this->storeJsonFile($eventList, $targetFilePath);
            $this->readImageDir($this->sourceDir,  $eventList->data);
        }

    }

    private function readImageDir($sourceDir, $eventList): void
    {
        foreach ($eventList as $event) {
            $srcDir = $sourceDir . '/' . $event['id'] . '/' . config('myapp.album.srcDir');
            $thumbDir = $sourceDir . '/' . $event['id'] . '/' . config('myapp.album.thumbDir');
            if (!is_dir($srcDir)) {
                throw new Exception('No image directories found in: ' . $this->sourceDir);
            }
            $imageFiles = glob($srcDir . '/*.{jpg,gif,png}', GLOB_BRACE);
            if (empty($imageFiles)) {
                throw new Exception('No images found in: ' . $srcDir);
            }


            foreach ($imageFiles as $imageFile) {
                $this->parseImageFile($imageFile, $event, $thumbDir);
            }
        }

        $targetFilePath = config('myapp.album.dir.target') . '/' . config('myapp.album.file.images');

        foreach ($this->images as $album => $imageList) {
            $targetFilePath = config('myapp.album.dir.target') . '/' .$album. '/'.config('myapp.album.file.images');
            $images = new AlbumDataResource();
            $images->data =$imageList;
            //dd($images);
            $this->storeJsonFile($images, $targetFilePath);
        }



    }

    private function parseCoverFiles(array $directories, string $sourceDir, ?string $parentDir = null): array
    {

        $items = [];
        foreach ($directories as $directory) {
            $path = $sourceDir . '/' . $directory;

            $coverPath = $path . '/' . config('myapp.album.cover');
            if (!file_exists($coverPath)) {
                $this->errors[] = 'WARNING: No cover found in directory: ' . $path;
                continue;
            }

            if (file_exists($coverPath) && @getimagesize($coverPath, $imageData)) {
                $parentPath = $parentDir ? $parentDir . '/' : '';
                $cover = $this->url . '/' . $parentPath.$directory . '/' . config('myapp.album.cover');
                // $iptc = $this->getIptcData($imageData); // Remove this line
            } else {
                $this->errors[] = 'WARNING: Invalid cover image found in directory: ' . $path;
                continue;
            }

            $featuredPath = $path . '/' . config('myapp.album.featured');
            if (!file_exists($featuredPath)) {
                $this->errors[] = 'WARNING: No featured found in directory: ' . $path;
            }
            $featured = null;
            if (file_exists($featuredPath) && @getimagesize($featuredPath, $featuredData)) {
                $parentPath = $parentDir ? $parentDir . '/' : '';
                $featured = $this->url . '/' . $parentPath.$directory . '/' . config('myapp.album.featured');
            } else {
                $this->errors[] = 'WARNING: Invalid featured image found in directory: ' . $path;
            }
            $options = [
                'id' => ($parentDir ? $parentDir . '/' : '') . $directory,
                'directory' => $directory,
                'parentId' => $parentDir ?? null,
                'src' => $cover,
                'featured' => $featured,
                'thumbnail' => null,
                'iptc' => $this->getIptcData($coverPath), // Pass image path
            ];
            $items[] = $this->parseAlbumImage($options);


        }

        return $items;
    }

    private function parseImageFile(string $imageFile, array $event, string $thumbDir): void
    {
        $imageData = [];
        if (!file_exists($imageFile) && !@getimagesize($imageFile, $imageData)) {
            $this->errors[] = 'WARNING: Invalid  image found: ' . $imageFile;
        }



        $fileName = basename($imageFile);
        $imagePath = $event['id'] . '/' . config('myapp.album.srcDir') . '/' . $fileName;
        $thumUrl = $this->url . '/' . $event['id'] . '/' . config('myapp.album.thumbDir') . '/' . $fileName;
        if (!is_dir($thumbDir)) {
            mkdir($thumbDir, 0777, true);
        }
        $thumbPath = $thumbDir . '/' . $fileName;

        if (!file_exists($thumbPath)) {
            $this->generateThumbnail($imageFile, $thumbPath, config('myapp.album.thumbWidth'));
        }
        $options = [
            'id' => $imagePath,
            'directory' => $event['directory'],
            'parentId' => $event['id'],
            'src' => $this->url . '/' . $imagePath,
            'thumbnail' => $thumUrl,
            'iptc' => $this->getIptcData($imageFile), // Pass image path
            //'exif' => @exif_read_data($imageFile, 'ANY_TAG', true),
        ];


        $this->images[ $event['parentId']][] = $this->parseAlbumImage($options);




    }
    private function parseAlbumImage(array $options): array
    {
        return [
            'id' => $options['id'],
            'directory' => $options['directory'],
            'parentId' => $options['parentId'],
            'src' => $options['src'],
            'thumbnail' => $options['thumbnail'] ?? null,
            'featured' => $options['featured'] ?? null,
            'title' => $options['iptc']['title'] ?? $options['directory'],
            'createdAt' => new Carbon($options['iptc']['date'] ?? null),
            'description' => $options['iptc']['description'] ?? null,

            'author' => $options['iptc']['author'] ?? null,
            //'tags' => $options['iptc']['tags'] ?? null,
            // 'exif' => $options['exif'] ?? null,


        ];

    }

    // Refactor getIptcData to accept image path and extract IPTC data inside
    private function getIptcData($imagePath): array
    {
        $return = array('title' => null, 'description' => null, 'author' => null, 'tags' => null, 'date' => null);
        if (!file_exists($imagePath)) {
            return $return;
        }
        $info = [];
        @getimagesize($imagePath, $info);
        if (isset($info['APP13'])) {
            $iptc = iptcparse($info['APP13']);
            //dump( $imagePath.': '.($iptc ?? 'No IPTC data'));
            // Debug: log IPTC fields for troubleshooting
            if (!isset($iptc['2#120'][0])) {
                /*$this->errors[] = 'DEBUG: No IPTC caption (2#120) found for image: ' . $imagePath . ' IPTC: ' . print_r($iptc, true);*/
                //$this->errors[] = 'DEBUG: No IPTC caption (2#120) found for image: ' . $imagePath ;
            }
            $return['title'] = isset($iptc['2#005'][0]) ? html_entity_decode($iptc['2#005'][0], ENT_QUOTES | ENT_XML1, 'UTF-8') : null;
            // Lightroom "caption" is stored in 2#120, which is mapped to description
            if (isset($iptc['2#120'][0])) {
                //dump( '2#120: '.$iptc['2#120'][0]);
                $return['description'] = html_entity_decode($iptc['2#120'][0], ENT_QUOTES | ENT_XML1, 'UTF-8');
            } elseif (isset($iptc['2#122'][0])) {
                dump( '2#122');
                // Fallback to Writer/Editor if caption is missing
                $return['description'] = html_entity_decode($iptc['2#122'][0], ENT_QUOTES | ENT_XML1, 'UTF-8');
            } elseif (isset($iptc['2#005'][0])) {
                //dump( '2#005: ' . $iptc['2#005'][0]);
                // Fallback to Object Name if both are missing
                $return['description'] = html_entity_decode($iptc['2#005'][0], ENT_QUOTES | ENT_XML1, 'UTF-8');
            } else {
                $return['description'] = null;
            }
            //dump( 'Description for '.$imagePath.': '.$return['description']);
            $return['author'] = isset($iptc['2#080'][0]) ? html_entity_decode($iptc['2#080'][0], ENT_QUOTES | ENT_XML1, 'UTF-8') : null;
            $return['tags'] = isset($iptc['2#025']) ? array_map(function($tag) {
                return html_entity_decode($tag, ENT_QUOTES | ENT_XML1, 'UTF-8');
            }, $iptc['2#025']) : null;
            $return['date'] = isset($iptc['2#062'][0]) ? html_entity_decode($iptc['2#062'][0], ENT_QUOTES | ENT_XML1, 'UTF-8') : null;
        } else {
            //$this->errors[] = 'DEBUG: No IPTC APP13 found for image: ' . $imagePath;
        }
        return $return;
    }

    private function generateThumbnail(string $imageFile, string $thumbPath, int $thumbWidth = 150): void
    {
        $imageInfo = getimagesize($imageFile);
        if ($imageInfo === false) {
            $this->errors[] = 'ERROR: Failed to get image size for: ' . $imageFile;
            return;
        }

        list($width, $height) = $imageInfo;
        $thumbHeight = intval($height * $thumbWidth / $width);

        $thumbnail = imagecreatetruecolor($thumbWidth, $thumbHeight);

        switch ($imageInfo['mime']) {
            case 'image/jpeg':
                $source = imagecreatefromjpeg($imageFile);
                break;
            case 'image/png':
                $source = imagecreatefrompng($imageFile);
                break;
            case 'image/gif':
                $source = imagecreatefromgif($imageFile);
                break;
            default:
                $this->errors[] = 'ERROR: Unsupported image type for: ' . $imageFile;
                return;
        }

        imagecopyresampled($thumbnail, $source, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $width, $height);

        switch ($imageInfo['mime']) {
            case 'image/jpeg':
                imagejpeg($thumbnail, $thumbPath);
                break;
            case 'image/png':
                imagepng($thumbnail, $thumbPath);
                break;
            case 'image/gif':
                imagegif($thumbnail, $thumbPath);
                break;
        }

        imagedestroy($source);
        imagedestroy($thumbnail);

    }

    private function storeJsonFile($dataResource, $targetFilePath): void
    {


        if (count($dataResource->data) < 1) {
            $this->errors[] = 'ERROR: No data to store in JSON file: ' . $targetFilePath;
            return;
        }


        $dataResource->createdAt = date('Y-m-d H:i:s');
        $dataResource->message = 'OK 200';
        $dataResource->meta['total'] = count($dataResource->data);

        $json = json_encode($dataResource, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES| JSON_UNESCAPED_UNICODE);
        if ($json === false) {
            $this->errors[] = 'ERROR: Failed to generate JSON from albums array.';
            return;
        }
        if (@file_put_contents($targetFilePath, $json) === false) {
            $this->errors[] = 'ERROR: Failed to save JSON to file: ' . $targetFilePath;
            return;
        }
        $this->success[] = 'SUCCESS: JSON file saved successfully: ' . $targetFilePath;


    }

    private function readExifData(string $coverPath): array
    {
        $exifData = @exif_read_data($coverPath, 'ANY_TAG', true);
        // Additional information from Lightroom
        getimagesize($coverPath, $infos);
        if (isset($infos['APP13'])) {
            print_r(iptcparse($infos['APP13']));
        }
        if ($exifData === false) {
            $this->errors[] = 'ERROR: Failed to read EXIF data from image: ' . $coverPath;
            return ['title' => null, 'description' => null];
        }

        $title = $exifData['ImageDescription'] ?? null;
        $description = $exifData['UserComment'] ?? null;

        return ['title' => $title, 'description' => $description];
    }
}