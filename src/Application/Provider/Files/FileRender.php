<?php declare(strict_types=1);

namespace App\Application\Provider\Files;

/**
 * Class FileRender
 * @package App\Application\Provider\Files
 */
class FileRender
{
    /**
     * File types
     * @var int
     */
    const IMAGE = 1;

    /**
     * @param string $fileName
     * @param int $fileType
     * @return string
     * @throws \Exception
     */
    public function getFile(
        string $fileName,
        int $fileType = self::IMAGE): string
    {
        return $this->getBasePath($fileType) . '?id=' . $fileName;
    }

    /**
     * @param int $fileType
     * @return string
     * @throws \Exception
     */
    private function getBasePath(int $fileType = self::IMAGE): string
    {
        $basePath = $_ENV["FILE_RENDER_PATH"] . "/files";

        switch($fileType) {
            case self::IMAGE:
                $basePath .= "/images/";
                break;
            default:
                throw new \Exception("Unknown file type: {$fileType}.");
        }

        return $basePath;
    }
}