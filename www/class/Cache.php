<?php

/**
 * Class Cache
 * small class to handle caching data on the filesystem
 */
class Cache
{
    private $directory = null;
    const CACHE_PREFIX = 'CACHE_';

    /**
     * creates new cache object
     * @param string $directory directory to store cache files
     */
    public function __construct($directory)
    {
        $this->directory = $directory;
    }

    /**
     * caches a value on the filesystem
     * @param string $key key to add / overwrite
     * @param string $value value to add to cache
     * @param int $ttl time to live in cache in seconds
     */
    public function add($key, $value, $ttl)
    {
        $file = $this->directory . '/' . static::CACHE_PREFIX . $key;
        $cache = array(
            'expire' => time() + $ttl,
            'data' => $value
        );
        file_put_contents($file, json_encode($cache), LOCK_EX);
    }

    /**
     * retrieves cached item from filesystem if it exists and is not stale
     * @param string $key key to get from cache
     * @return string|null cached value for key
     */
    public function retrieve($key)
    {
        $rvalue = null;
        $file = $this->directory . '/' . static::CACHE_PREFIX . $key;
        if (file_exists($file)) {
            $cache = json_decode(file_get_contents($file), true);
            if ($cache['expire'] >= time()) {
                //cache hit, return cached data
                $rvalue = $cache['data'];
            } else {
                @unlink($file);
            }
        }
        return $rvalue;
    }
} 