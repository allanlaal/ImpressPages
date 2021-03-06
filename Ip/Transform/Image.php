<?php
    /**
     * @package   ImpressPages
     *
     *
     */

namespace Ip\Transform;

abstract class Image extends \Ip\Transform
{

    /**
     * Create image resource from image file and alocate required memory
     * @param $imageFile
     * @return resource
     * @throws \Ip\Internal\Repository\TransformException
     */
    protected function createImageImage($imageFile){

        $this->getMemoryNeeded($imageFile);

        $mime = $this->getMimeType($imageFile);


        switch ($mime) {
            case IMAGETYPE_JPEG:
            case IMAGETYPE_JPEG2000:
                $image = imagecreatefromjpeg($imageFile);
                break;
            case IMAGETYPE_GIF:
                $image = imagecreatefromgif($imageFile);
                imageAlphaBlending($image, false);
                imageSaveAlpha($image, true);
                break;
            case IMAGETYPE_PNG:
                $image = imagecreatefrompng($imageFile);
                imageAlphaBlending($image, false);
                imageSaveAlpha($image, true);
                break;
            default:
                throw new \Ip\Internal\Repository\TransformException("Incompatible type. Type detected: ".$mime, \Ip\Internal\Repository\TransformException::UNKNOWN_MIME_TYPE);
        }

        return $image;
    }

    protected function createEmptyImage($width, $height)
    {
        $trueColor = 1;

        \Ip\Internal\System\Helper\SystemInfo::allocateMemory($width*$height*(2.2+($trueColor*3)));
        return imagecreatetruecolor($width, $height);
    }

    /**
     * Takes memory required to process supplied image file and a bit more for future PHP operations.
     * @param resource $imageFile
     * @return bool true on success
     */
    protected function getMemoryNeeded($imageFile){
        if (!file_exists($imageFile)) {
            return 0;
        }
        $imageInfo = getimagesize($imageFile);
        if(!isset($imageInfo['channels']) || !$imageInfo['channels']) {
            $imageInfo['channels'] = 4;
        }
        if(!isset($imageInfo['bits']) || !$imageInfo['bits']) {
            $imageInfo['bits'] = 8;
        }

        if (!isset($imageInfo[0])) {
            $imageInfo[0] = 1;
        }

        if (!isset($imageInfo[1])) {
            $imageInfo[1] = 1;
        }

        $memoryNeeded = round(($imageInfo[0] * $imageInfo[1] * $imageInfo['bits'] * $imageInfo['channels'] / 8 + Pow(2, 16)) * 1.65);
        $success = \Ip\Internal\System\Helper\SystemInfo::allocateMemory($memoryNeeded);

        return $success;
    }

    /**
     * @param resource $image
     * @param string $fileName
     * @param int $quality from 0 to 100
     * @return bool
     * @throws \Ip\Internal\Repository\TransformException
     */
    protected function saveJpeg($image, $fileName, $quality) {
        if(!imagejpeg($image, $fileName, (int)$quality)){
            throw new \Ip\Internal\Repository\TransformException("Can't write to file: ".$fileName , \Ip\Internal\Repository\TransformException::WRITE_PERMISSION);
        }
        return true;
    }

    /**
     * @param resource $image
     * @param string $fileName
     * @param int $quality - from 0 to 9
     * @return bool
     * @throws \Ip\Internal\Repository\TransformException
     */
    protected function savePng($image, $fileName, $compression) {
        if (!imagepng($image, $fileName, $compression)) {
            throw new \Ip\Internal\Repository\TransformException("Can't write to file: ".$fileName , \Ip\Internal\Repository\TransformException::WRITE_PERMISSION);
        }
        return true;
    }






    /**
     * Get mime type of an image file
     * @param string $imageFile
     * @return int mixed
     * @throws \Ip\Internal\Repository\TransformException
     */
    protected function getMimeType($imageFile) {
        $imageInfo = getimagesize($imageFile);
        if (isset($imageInfo[2])) {
            return $imageInfo[2];
        } else {
            throw new \Ip\Internal\Repository\TransformException("Incompatible type.", \Ip\Internal\Repository\TransformException::UNKNOWN_MIME_TYPE);
        }

    }


    /**
     * @param resource $imageNew
     * @param string $newFile
     * @param int $quality from 0 to 100
     * @throws \Ip\Internal\Repository\TransformException
     */
    protected function saveImage ($imageNew, $newFile, $quality){

        $pathInfo = pathinfo($newFile);

        switch (strtolower(isset($pathInfo['extension']) ? $pathInfo['extension'] : '')) {
            case 'png':
                    //fill transparent places with white.
                    /*$width = imagesx($imageNew);
                    $height = imagesy($imageNew);
                    $imageBg = imagecreatetruecolor($width, $height);
                    imagealphablending($imageBg, false);
                    imagesavealpha($imageBg,true);
                    imagealphablending($imageNew, true);
                    imagesavealpha($imageNew,true);
                    $color = imagecolorallocatealpha($imageBg, 255, 255, 0, 0);
                    imagefilledrectangle ( $imageBg, 0, 0, $width, $height, $color );
                    imagecopymerge($imageBg, $imageNew, 0, 0, 0, 0, $width, $height, 50);
                    */
                    self::savePng($imageNew, $newFile, 9); //9 - maximum compression. PNG is always lossless
                break;
            case 'jpg':
            case 'jpeg':
            default:
                    self::saveJpeg($imageNew, $newFile, $quality);
                break;
        }
    }

    protected function fixSourceRatio ($x1, $y1, $x2, $y2, $widthDest, $heightDest) {
        $widthSource =  $x2 - $x1;
        $heightSource = $y2 - $y1;
        if ($heightSource > 0 && $widthSource > 0) {
            //fix ratio if needed
            if ($heightSource == 0) {
                $sourceRatio = 1; //to avoid division by zero
            } else {
                $sourceRatio = $widthSource / $heightSource;
            }

            if ($heightDest == 0) {
                $destRatio = 1; //to avoid division by zero
            } else {
                $destRatio = $widthDest / $heightDest;
            }
            if ($sourceRatio > $destRatio) {
                //lower source width
                $requiredWidth = $heightSource * $destRatio;
                $diff = $widthSource - $requiredWidth;
                $x1 = $x1 + round($diff / 2);
                $x2 = $x2 - round($diff / 2);
            } elseif ($sourceRatio < $destRatio) {
                //lower source height
                $requiredHeight = $widthSource / $destRatio;
                $diff = $heightSource - $requiredHeight;
                $y1 = $y1 + round($diff / 2);
                $y2 = $y2 - round($diff / 2);
            }
        }
        return array($x1, $y1, $x2, $y2);
    }

}
