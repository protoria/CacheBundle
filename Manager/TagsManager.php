<?php
namespace Igdr\Bundle\CacheBundle\Manager;

use Doctrine\Common\Cache\Cache;

/**
 * Provide tags functionality to memcache
 */
class TagManager
{
    /**
     * @var string
     */
    const STORE_KEY = '_tags';

    /**
     * @var Cache
     */
    private $cache;

    /**
     * @param Cache $cache
     */
    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @param string $tag
     *
     * @return string
     */
    private function getCacheId($tag)
    {
        return sprintf(self::STORE_KEY.'_'.$tag);
    }

    /**
     * @param string       $tag
     * @param string|array $key
     */
    public function addKey($tag, $key)
    {
        $tags = (array)$key;
        if ($stored = $this->getKeys($tag)) {
            $tags = array_merge($tags, $stored);
        }
        $this->cache->save($this->getCacheId($tag), $tags);
    }

    /**
     * @param string $tag
     *
     * @return array
     */
    public function getKeys($tag)
    {
        return $this->cache->fetch($this->getCacheId($tag));
    }

    /**
     * @param string $tag
     */
    public function deleteKeys($tag)
    {
        $this->cache->delete($this->getCacheId($tag));
    }

    /**
     * @param string $tag
     */
    public function cleanCacheByTag($tag)
    {
        $keys = (array)$this->getKeys($tag);
        foreach ($keys as $key) {
            $this->cache->delete($key);
        }
        $this->deleteKeys($tag);
    }
}