<?php
/**
 * Helper classes for PrestaShop CMS.
 *
 * @author    Maksim T. <zapalm@yandex.com>
 * @copyright 2018 Maksim T.
 * @license   https://opensource.org/licenses/MIT MIT
 * @link      https://github.com/zapalm/prestashop-helpers GitHub
 * @link      https://prestashop.modulez.ru/en/tools-scripts/53-helper-classes-for-prestashop.html Homepage
 */

namespace zapalm\prestashopHelpers\helpers;

use ZipArchive;

/**
 * File helper.
 *
 * @version 0.8.0
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
            $maxSize = $uploadMaxFileSize;
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
     * @return int|bool The size in Bytes or false on an error.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function getDirectorySize($dir)
    {
        $dir = realpath($dir);
        if (false === $dir) {
            return false;
        }

        $result = 0;
        foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS)) as $iterator) {
            $bytes = $iterator->getSize();

            // It can return a negative value for a large file size: https://bugs.php.net/bug.php?id=54758
            if ($bytes < 0) {
                return false;
            }

            $result += $bytes;
        }

        return $result;
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
     * @param string      $zipFile     The archive to be extracted.
     * @param string      $destination The directory where to extract the archive.
     * @param string|null $error       The reference to a variable to store an error message.
     *
     * @return bool
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function extractZip($zipFile, $destination, &$error = null)
    {
        if (false === file_exists($destination)) {
            if (false === mkdir($destination)) {
                $error = static::translate('It is not possible to create the directory for unpacking the archive.');

                return false;
            }
        }

        if (false === class_exists('ZipArchive', false)) {
            $error = static::translate('ZipArchive class is missing (probably too old PHP version).');

            return false;
        }

        $zip        = new ZipArchive();
        $openResult = $zip->open($zipFile);
        if (true !== $openResult) {
            $error = static::translate('There was an error when opening a ZIP file, error code:') . ' ' . $openResult;

            return false;
        }

        if (false === $zip->extractTo($destination)) {
            $error = static::translate('It was not possible to unpack the ZIP archive.');

            return false;
        }

        if (false === $zip->close()) {
            $error = static::translate('Failed to close the ZIP file.');

            return false;
        }

        return true;
    }

    /**
     * Translates a sentence.
     *
     * @param string $sentence The sentence.
     *
     * @return string The translated sentence or the same sentence if it was not translated before.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    private static function translate($sentence)
    {
        return TranslateHelper::translate(
            $sentence,
            static::class,
            null,
            __DIR__ . '/../translations',
            true
        );
    }
}