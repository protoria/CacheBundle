<?php
namespace Igdr\Bundle\CacheBundle\Manager;

use Doctrine\Common\Cache\CacheProvider;

/**
 * Provide tags functionality
 */
class CacheManager
{
    /**
     * @var CacheProvider
     */
    private $cacheProvider;

    /**
     * @var TagsManager
     */
    private $tagsManager;

    /**
     * @var int
     */
    private $defaultLifeTime = 0;

    /**
     * @param \Doctrine\Common\Cache\CacheProvider         $cache
     * @param \Igdr\Bundle\CacheBundle\Manager\TagsManager $tagsManager
     * @param int                                          $defaultLifeTime
     */
    public function __construct(CacheProvider $cache, TagsManager $tagsManager, $defaultLifeTime)
    {
        $this->cacheProvider = $cache;
        $this->tagsManager = $tagsManager;
        $this->defaultLifeTime = $defaultLifeTime;
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
     * @param string   $id
     * @param mixed    $data
     * @param array    $tags
     * @param int|null $lifeTime
     *
     * @return bool
     */
    public function save($id, $data, array $tags = array(), $lifeTime = null)
    {
        $lifeTime === null && $lifeTime = $this->defaultLifeTime;

        $success = $this->cacheProvider->save($id, $data, $lifeTime);
        if ($success === true && !empty($tags)) {
            $this->tagsManager->addKeys($tags, $id);
        }

        return $success;
    }

    /**
     * @return bool
     */
    public function clean()
    {
        return $this->cacheProvider->deleteAll();
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