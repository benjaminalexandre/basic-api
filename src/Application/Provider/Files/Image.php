<?php declare(strict_types=1);

namespace App\Application\Provider\Files;

/**
 * Class Image
 * @package App\Application\Provider\Files
 */
class Image
{
    /**
     * @param string $path
     * @param array $param
     * @throws \Exception
     * @return string
     */
    public function getImage(string $path, array $param): string
    {
        $size = getimagesize($path);
        $oldWidth = $size[0];
        $oldHeight = $size[1];
        if (array_key_exists("width", $param)) {
            $width = (int)$param["width"] > 3200 ? 3200 : (int)$param["width"];
        } else {
            $width = $oldWidth;
        }
        if (array_key_exists("height", $param)) {
            $height = (int)$param["height"] > 2400 ? 2400 : (int)$param["height"];
        } else {
            $height = $oldHeight;
        }

        $left = 0;
        $top = 0;
        $xCenter = 0;
        $yCenter = 0;
        $newWidth = $width;
        $newHeight = $height;
        // The image needs to be resized
        if ($width !== $oldWidth || $height !== $oldHeight) {
            // The width ratio is smaller than the height ratio
            if (($width / $oldWidth) < ($height / $oldHeight)) {
                // The image needs to be cropped
                if (array_key_exists("crop", $param) && $param["crop"] !== "false") {
                    $coefficient = $oldHeight / $height;
                    $newWidth = (int)round($oldWidth / $coefficient, 0);
                    $newHeight = (int)round($oldHeight / $coefficient, 0);
                    // A layer is needed
                    if (array_key_exists("layer", $param) && $param["layer"] !== "false") {
                        $top = (int)round(($height - $newHeight) / 2, 0);
                    } else {
                        $height = $newHeight;
                    }
                    $xCenter = (int)round(($coefficient * ($newWidth - $width)) / 2, 0);
                } else {
                    $newHeight = (int)round($oldHeight / ($oldWidth / $width), 0);
                    // A layer is needed
                    if (array_key_exists("layer", $param) && $param["layer"] !== "false") {
                        $top = (int)round(($height - $newHeight) / 2, 0);
                    } else {
                        $height = $newHeight;
                    }
                }
                // The height ratio is smaller than the width ratio
            } else {
                // The image needs to be cropped
                if (array_key_exists("crop", $param) && $param["crop"] !== "false") {
                    $coefficient = $oldWidth / $width;
                    $newWidth = (int)round($oldWidth / $coefficient, 0);
                    $newHeight = (int)round($oldHeight / $coefficient, 0);
                    // A layer is needed
                    if (array_key_exists("layer", $param) && $param["layer"] !== "false") {
                        $left = (int)round(($width - $newWidth) / 2, 0);
                    } else {
                        $width = $newWidth;
                    }
                } else {
                    $newWidth = (int)round($oldWidth / ($oldHeight / $height), 0);
                    // A layer is needed
                    if (array_key_exists("layer", $param) && $param["layer"] !== "false") {
                        $left = (int)round(($width - $newWidth) / 2, 0);
                    } else {
                        $width = $newWidth;
                    }
                }
            }
        }

        $imageNew = imagecreatetruecolor($width, $height);
        $tempPath = substr($path, 0, strrpos($path, "/") + 1) . uniqid() . ".";
        switch ($size["mime"]) {
            case "image/jpeg":
                imagefilledrectangle($imageNew, 0, 0, $width, $height, imagecolorallocate($imageNew, 255, 255, 255));
                imagecopyresampled(
                    $imageNew,
                    imagecreatefromjpeg($path),
                    $left,
                    $top,
                    $xCenter,
                    $yCenter,
                    $newWidth,
                    $newHeight,
                    $oldWidth,
                    $oldHeight
                );

                header('Content-type: image/jpeg');
                imagejpeg($imageNew, null, 70);

                break;
            case "image/png":
                imagealphablending($imageNew, false);
                $transparent = imagecolorallocatealpha($imageNew, 0, 0, 0, 127);
                imagecolortransparent($imageNew, $transparent);
                imagefill($imageNew, 0, 0, $transparent);
                imagesavealpha($imageNew, true);
                imagecopyresampled(
                    $imageNew,
                    imagecreatefrompng($path),
                    $left,
                    $top,
                    $xCenter,
                    $yCenter,
                    $newWidth,
                    $newHeight,
                    $oldWidth,
                    $oldHeight
                );

                header('Content-type: image/png');
                imagepng($imageNew, null, 9);

                break;
            case "image/gif":
                imagealphablending($imageNew, true);
                $transparent = imagecolorallocatealpha($imageNew, 0, 0, 0, 127);
                imagecolortransparent($imageNew, $transparent);
                imagefill($imageNew, 0, 0, $transparent);
                imagesavealpha($imageNew, true);
                imagecopyresampled(
                    $imageNew,
                    imagecreatefromgif($path),
                    $left,
                    $top,
                    $xCenter,
                    $yCenter,
                    $newWidth,
                    $newHeight,
                    $oldWidth,
                    $oldHeight
                );

                header('Content-type: image/gif');
                imagepng($imageNew, $tempPath, 9);

                break;
            default:
                throw new \Exception("Unknown format : {$size["mime"]}");
                break;
        }

        $file = fopen($tempPath, "r");
        fclose($file);
        unlink($tempPath);
        imagedestroy($imageNew);

        return $path;
    }
}