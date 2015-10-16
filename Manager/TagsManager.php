<?php
namespace Igdr\Bundle\CacheBundle\Manager;

use Doctrine\Common\Cache\CacheProvider;

/**
 * Provide tags functionality
 */
class TagsManager
{
    /**
     * @var string
     */
    const STORE_KEY = '_tags';

    /**
     * @var CacheProvider
     */
    private $cacheProvider;

    /**
     * @param CacheProvider $cacheProvider
     */
    public function __construct(CacheProvider $cacheProvider)
    {
        $this->cacheProvider = $cacheProvider;
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
        $tags = (array) $key;
        if ($stored = $this->getKeys($tag)) {
            $tags = array_merge($tags, $stored);
        }
        $this->cacheProvider->save($this->getCacheId($tag), $tags);
    }

    /**
     * @param array        $tags
     * @param string|array $key
     */
    public function addKeys(array $tags, $key)
    {
        foreach ($tags as $tag) {
            $this->addKey($tag, $key);
        }
    }

    /**
     * @param string $tag
     *
     * @return array
     */
    public function getKeys($tag)
    {
        return $this->cacheProvider->fetch($this->getCacheId($tag));
    }

    /**
     * @param string $tag
     */
    public function deleteKeys($tag)
    {
        $this->cacheProvider->delete($this->getCacheId($tag));
    }

    /**
     * @param array $tags
     */
    public function cleanCacheByTags(array $tags)
    {
        foreach ($tags as $tag) {
            $keys = (array) $this->getKeys($tag);
            foreach ($keys as $key) {
                $this->cacheProvider->delete($key);
            }
            $this->deleteKeys($tag);
        }
    }
}