<?php

/**
 * This file is part of the RSSClient proyect.
 * 
 * Copyright (c)
 * Daniel González Cerviño <daniel.gonzalez@ideup.com> 
 * 
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\RSSClient;

use Desarrolla2\RSSClient\RSSClient;
use Desarrolla2\RSSClient\Sanitizer\SanitizerInterface;
use Desarrolla2\Cache\CacheInterface;

/**
 * 
 * Description of RSSCacheClient
 *
 * @author : Daniel González Cerviño <daniel.gonzalez@ideup.com> 
 * @file : RSSCacheClient.php , UTF-8
 * @date : Oct 4, 2012 , 11:49:17 AM
 */
class RSSCacheClient extends RSSClient
{

    /**
     * @var type 
     */
    static private $CACHE_KEY = 'RSSCacheClient';

    /**
     * @var type 
     */
    protected $cache = null;

    /**
     * @var type 
     */
    protected $cacheHash = array();

    /**
     * Constructor
     * 
     * @param \Desarrolla2\Cache\CacheInterface $cache
     * @param \Desarrolla2\RSSClient\Sanitizer\SanitizerInterface $sanitizer
     * @param array $feeds
     * @param string $channel
     */
    public function __construct(CacheInterface $cache, $feeds = array(), $channel = 'default')
    {
        $this->cache = $cache;
        parent::__construct($feeds, $channel);
    }

    /**
     * 
     * @param type $channel
     * @param type $limit
     */
    public function fetch($channel = 'default', $limit = 20)
    {
        $nodes = $this->getFromCache($channel);
        if (!$nodes) {
            $nodes = parent::fetch($channel, $limit);
            $this->setToCache($nodes, $channel);
        }
        return $nodes;
    }

    /**
     * Generate a unique hash for Cache
     * 
     * @param string $channel
     * @return string 
     */
    protected function getCacheKey($channel = 'default')
    {
        if (!isset($this->cacheHash[$channel])) {
            $this->cacheHash[$channel] = self::$CACHE_KEY . '_' . md5(implode('|', $this->getFeeds($channel)));
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
     * @param string $channel
     * @return boolean 
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
     * @param type $channel
     * @param type $nodes
     */
    protected function setToCache($nodes, $channel = 'default')
    {
        $hash = $this->getCacheKey($channel);
        $this->getCache()->set($hash, $nodes);
    }

}
