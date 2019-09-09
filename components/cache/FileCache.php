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

namespace zapalm\prestashopHelpers\components\cache;

/**
 * File cache system.
 *
 * @version 0.10.0
 *
 * @author Maksim T. <zapalm@yandex.com>
 */
class FileCache extends BaseCache
{
    /** @var static Instance. */
    protected static $instance;

    /**
     * Protected constructor.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    protected function __construct()
    {
        parent::__construct();

        if (false === file_exists(_PS_CACHEFS_DIRECTORY_)) {
            @mkdir(_PS_CACHEFS_DIRECTORY_, 0777, true);
        }

        $filePath = $this->getFilePath(static::KEYS_NAME);
        if (file_exists($filePath)) {
            $this->keys = unserialize(file_get_contents($filePath));
        }
    }

    /**
     * Returns an instance of FileCache system.
     *
     * @return static The instance.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Returns a file path to a cache by a given key.
     *
     * @param string $key The key.
     *
     * @return string File path.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    protected function getFilePath($key)
    {
        return _PS_CACHEFS_DIRECTORY_ . md5($key) . '.ser';
    }

    /**
     * @inheritDoc
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    protected function _set($key, $value, $ttl = 0)
    {
        return (false !== file_put_contents($this->getFilePath($key), serialize($value)));
    }

    /**
     * @inheritDoc
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    protected function _get($key)
    {
        if (false === $this->_exists($key) || $this->_expired($key)) {
            return false;
        }

        $filePath = $this->getFilePath($key);
        $data     = file_get_contents($filePath);

        return unserialize($data);
    }

    /**
     * @inheritDoc
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    protected function _exists($key)
    {
        if (false === isset($this->keys[$key])) {
            return false;
        }

        $filePath = $this->getFilePath($key);
        if (false === file_exists($filePath)) {
            return false;
        }

        return true;
    }

    /**
     * Checks if a given cache key is expired.
     *
     * @param string $key The key.
     *
     * @return bool Whether the key is expired.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    protected function _expired($key) {
        return ($this->keys[$key] > 0 && $this->keys[$key] < time());
    }

    /**
     * @inheritDoc
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    protected function _delete($key)
    {
        if ($this->_exists($key)) {
            return unlink($this->getFilePath($key));
        }

        return true;
    }

    /**
     * @inheritDoc
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    protected function _writeKeys()
    {
        file_put_contents($this->getFilePath(static::KEYS_NAME), serialize($this->keys));
    }

    /**
     * @inheritDoc
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function flush()
    {
        \Tools::deleteDirectory(_PS_CACHEFS_DIRECTORY_, false);

        return true;
    }
}