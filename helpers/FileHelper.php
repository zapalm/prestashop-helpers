<?php
/**
 * Helper classes for PrestaShop CMS.
 *
 * @author    Maksim T. <zapalm@yandex.com>
 * @copyright 2018 Maksim T.
 * @license   https://opensource.org/licenses/MIT MIT
 * @link      https://github.com/zapalm/prestashopHelpers GitHub
 * @link      https://prestashop.modulez.ru/en/tools-scripts/53-helper-classes-for-prestashop.html Homepage
 */

namespace zapalm\prestashopHelpers\helpers;

/**
 * File helper.
 *
 * @version 0.7.0
 *
 * @author Maksim T. <zapalm@yandex.com>
 */
class FileHelper
{
    /**
     * Removes a directory recursively.
     *
     * @param string $dir The directory to be deleted recursively.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function removeDirectory($dir) {
        if (false === is_dir($dir)) {
            return;
        }

        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object === '.' || $object === '..') {
                continue;
            }

            $path = $dir . '/' . $object;
            if (is_dir($path)) {
                static::removeDirectory($path);
            } else {
                unlink($path);
            }
        }

        rmdir($dir);
    }

    /**
     * Returns a maximum file size that can be uploaded.
     *
     * @return int|bool The size in bytes or false on error.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function getFileSizeUploadLimit()
    {
        $maxSize           = (int)static::parseSize(ini_get('post_max_size'));
        $uploadMaxFileSize = (int)static::parseSize(ini_get('upload_max_filesize'));

        if ($uploadMaxFileSize > 0 && (0 === $maxSize || $maxSize > $uploadMaxFileSize)) {
            $maxSize = (int)$uploadMaxFileSize;
        }

        return (0 === $maxSize ? false : $maxSize);
    }

    /**
     * Returns a parsed size from a given value (like 10M, 1024k and so on).
     *
     * @param string|int $value The value to parse.
     *
     * @return int|bool The size in bytes or false on error.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function parseSize($value)
    {
        if (is_numeric($value) && $value >= 0) {
            return (int)$value;
        }

        if (1 === preg_match('/^([0-9]+)([bkmgtpezy])$/i', $value, $match)) {
            $bytes = round($match[1] * (float)pow(1024, stripos('bkmgtpezy', $match[2])));
            if ($bytes > 0) {
                return (int)$bytes;
            }
        }

        return false;
    }

    /**
     * Returns directory size.
     *
     * @param string $dir The directory to calculate it's size.
     *
     * @return int The size in Bytes.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function getDirectorySize($dir){
        $bytes = 0;

        $dir = realpath($dir);
        if (false !== $dir) {
            foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS)) as $iterator) {
                $bytes += $iterator->getSize();
            }
        }

        return $bytes;
    }

    /**
     * Returns files found under the directory specified by pattern.
     *
     * @param string $pattern The directory specified by pattern.
     *
     * @return string[] Files found directory specified by pattern.
     *
     * @see glob() for pattern examples.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function findFiles($pattern)
    {
        $directory = realpath(dirname($pattern));
        if (false === $directory) {
            return [];
        }

        $pattern = $directory. DIRECTORY_SEPARATOR . basename($pattern);
        $files   = glob($pattern);

        $dirs = glob(dirname($pattern) . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR | GLOB_NOSORT);
        if (is_array($dirs) && count($dirs)) {
            foreach ($dirs as $dir) {
                $files = array_merge($files, static::findFiles($dir . DIRECTORY_SEPARATOR . basename($pattern)));
            }
        }

        return $files;
    }

    /**
     * Format a size in bytes to a short format: kilobytes, megabytes and so on.
     *
     * @param int $size The size in bytes.
     *
     * @return string The formatted string, for example, 120.50k.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function formatSize($size) {
        return \Tools::formatBytes($size);
    }

    /**
     * Extract a Zip archive.
     *
     * @param string $zipFile     The archive to be extracted.
     * @param string $destination The directory where to extract the archive.
     *
     * @return bool
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function extractZip($zipFile, $destination) {
        return \Tools::ZipExtract($zipFile, $destination);
    }
}