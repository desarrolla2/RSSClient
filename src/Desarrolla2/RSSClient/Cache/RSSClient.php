<?php

/**
 * This file is part of the RSSClient project.
 *
 * Copyright (c)
 * Daniel González Cerviño <daniel.gonzalez@freelancemadrid.es>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\RSSClient\Cache;

use Desarrolla2\RSSClient\RSSClient as BaseClient;
use Desarrolla2\Cache\CacheInterface;
use Desarrolla2\Cache\Cache;
use Desarrolla2\Cache\Adapter\NotCache;

/**
 *
 * Description of RSSClient
 *
 * @author : Daniel González Cerviño <daniel.gonzalez@freelancemadrid.es>
 */
class RSSClient extends BaseClient
{
    /**
     * @var \Desarrolla2\Cache\Cache Cache Handler
     */
    protected $cache = null;

    /**
     * @var string This key is used as a pronoun to cache objects generated
     */
    private static $cacheKey = 'rss_cache_client';

    /**
     * @var array temporal array
     */
    protected $cacheHash = array();

    /**
     * Constructor
     *
     * @param array  $feeds
     * @param string $channel
     */
    public function __construct($feeds = array(), $channel = 'default')
    {
        $this->cache = new Cache(new NotCache());
        parent::__construct($feeds, $channel);
    }

    /**
     *
     * @param string $channel
     * @param int    $limit
     * @return bool|\Desarrolla2\RSSClient\Node\NodeCollection
     */
    public function fetch($channel = 'default', $limit = 100)
    {
        $nodes = $this->getFromCache($channel);
        if (!$nodes) {
            $nodes = parent::fetch($channel, $limit);
            $this->setToCache($nodes, $channel);
        }

        return $nodes;
    }

    /**
     * Set cache
     *
     * @param \Desarrolla2\Cache\CacheInterface $cache
     */
    public function setCache(CacheInterface $cache = null)
    {
        $this->cache = $cache;
    }

    /**
     * Generate a unique hash for Cache
     *
     * @param  string $channel
     * @return string
     */
    protected function getCacheKey($channel = 'default')
    {
        if (!isset($this->cacheHash[$channel])) {
            $this->cacheHash[$channel] = self::$cacheKey . '_' . md5(implode('|', $this->getFeeds($channel)));
        }

        return $this->cacheHash[$channel];
    }

    /**
     *
     * @return type
     * @throws \Exception
     */
    protected function getCache()
    {
        if (!$this->cache) {
            throw new \Exception('Cache not set');
        }

        return $this->cache;
    }

    /**
     * Retrieves from cache
     *
     * @param  string $channel
     * @return mixed|false
     */
    protected function getFromCache($channel = 'default')
    {
        $hash = $this->getCacheKey($channel);
        if ($this->getCache()->has($hash)) {
            return $this->getCache()->get($hash);
        }

        return false;
    }

    /**
     *
     * @param array  $nodes
     * @param string $channel
     */
    protected function setToCache($nodes, $channel = 'default')
    {
        $hash = $this->getCacheKey($channel);
        $this->getCache()->set($hash, $nodes);
    }
}
