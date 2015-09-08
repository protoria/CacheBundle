<?php
namespace Igdr\Bundle\CacheBundle\Manager;

use Doctrine\Common\Cache\CacheProvider;

/**
 * Provide tags functionality
 */
class CacheManager
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
     * @var TagsManager
     */
    private $tagsManager;

    /**
     * @param CacheProvider $cache
     */
    public function __construct(CacheProvider $cache, TagsManager $tagsManager)
    {
        $this->cacheProvider = $cache;
        $this->tagsManager = $tagsManager;
    }

    /**
     * @param string $id
     *
     * @return mixed
     */
    public function fetch($id)
    {
        return $this->cacheProvider->fetch($id);
    }

    /**
     * @param string $id
     * @param mixed  $data
     * @param array  $tags
     * @param int    $lifeTime
     *
     * @return bool
     */
    public function save($id, $data, array $tags = array(), $lifeTime = 0)
    {
        $success = $this->cacheProvider->save($id, $data, $lifeTime);
        if ($success === true && !empty($tags)) {
            $this->tagsManager->addKey($tags, $id);
        }

        return $success;
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    public function delete($id)
    {
        return $this->cacheProvider->delete($id);
    }

    /**
     * @param string $tag
     */
    public function cleanCacheByTag($tag)
    {
        $this->tagsManager->cleanCacheByTags([$tag]);
    }

    /**
     * @param array $tags
     */
    public function cleanCacheByTags(array $tags)
    {
        $this->tagsManager->cleanCacheByTags($tags);
    }
}