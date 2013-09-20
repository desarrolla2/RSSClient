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

namespace Desarrolla2\RSSClient\Handler\Feed;

use Desarrolla2\RSSClient\Handler\Error\ErrorHandler;
use Desarrolla2\RSSClient\Exception\InvalidArgumentException;

/**
 *
 * FeedHandler
 *
 * @author : Daniel González Cerviño <daniel.gonzalez@freelancemadrid.es>

 */
class FeedHandler extends ErrorHandler
{
    /**
     * @var array
     */
    protected $channels;

    /**
     * add channels for client
     *
     * @param  array $channels
     * @throws InvalidArgumentException
     */
    public function addChannels($channels)
    {
        if (!is_array($channels)) {
            throw new InvalidArgumentException('channels not valid (' . gettype($channels) . ')');
        }
        foreach ($channels as $channel => $feeds) {
            $this->addFeeds($feeds, $channel);
        }
    }

    /**
     * Retrieve feeds from a channel
     *
     * @param  string $channel
     * @return array  feeds
     */
    public function getFeeds($channel = 'default')
    {
        $this->createChannel($channel);

        return $this->feeds[$channel];
    }

    /**
     * Add feed to channel
     *
     * @param  string $feed
     * @param  string $channel
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public function addFeed($feed, $channel = 'default')
    {
        if (!is_string($feed)) {
            throw new InvalidArgumentException('feed not valid (' . gettype($feed) . ')');
        }
        if (!is_string($channel)) {
            throw new InvalidArgumentException('channel not valid (' . gettype($channel) . ')');
        }
        if ($this->isValidURL($feed)) {
            $this->createChannel($channel);
            if (!in_array($feed, $this->feeds[$channel])) {
                array_push($this->feeds[$channel], $feed);
            } else {
                $this->addError('tryint to add feed (' . $feed . ') that exist in channel (' . $channel . ')');
            }
        } else {
            throw new InvalidArgumentException('URL not valid ' . $feed);
        }
    }

    /**
     * Add feeds to channel
     *
     * @param  array  $feeds
     * @param  string $channel
     * @throws InvalidArgumentException
     */
    public function addFeeds($feeds, $channel = 'default')
    {
        if (!is_array($feeds)) {
            throw new InvalidArgumentException('feeds not valid (' . gettype($feeds) . ')');
        }
        if (!is_string($channel)) {
            throw new InvalidArgumentException('channel not valid (' . gettype($channel) . ')');
        }
        foreach ($feeds as $feed) {
            $this->addFeed($feed, $channel);
        }
    }

    /**
     *
     * Retrieve the number of channels
     *
     * @return int count $feeds
     */
    public function countChannels()
    {
        return count($this->feeds);
    }

    /**
     *
     * Retrieve the number of feeds from a channels
     *
     * @param  string $channel
     * @return int    count $feeds
     */
    public function countFeeds($channel = 'default')
    {
        $this->createChannel($channel);

        return count($this->feeds[$channel]);
    }

    /**
     * Retrieve Channel
     *
     * @return array $channels
     */
    public function getChannels()
    {
        return $this->feeds;
    }

    /**
     * Retrieve Channels Names
     *
     * @return array $channels
     */
    public function getChannelsNames()
    {
        return array_keys($this->feeds);
    }

    /**
     * set the channels for client
     *
     * @param type $channels
     */
    public function setChannels($channels)
    {
        $this->clearChannels();
        $this->addChannels($channels);
    }

    /**
     * Set feed in a hacnnel
     *
     * @param string $feed
     * @param string $channel
     */
    public function setFeed($feed, $channel = 'default')
    {
        $this->clearFeeds($channel);
        $this->addFeed($feed, $channel);
    }

    /**
     * Set feeds in a channel
     *
     * @param array  $feeds
     * @param string $channel
     * @throws \Desarrolla2\RSSClient\Exception\InvalidArgumentException
     */
    public function setFeeds($feeds, $channel = 'default')
    {
        if (!is_array($feeds)) {
            throw new InvalidArgumentException('feeds not valid (' . gettype($feeds) . ')');
        }
        if (count($feeds)) {
            $this->clearFeeds($channel);
            $this->addFeeds($feeds, $channel);
        }
    }

    /**
     * Clear Channels
     */
    protected function clearChannels()
    {
        $this->feeds = array();
    }

    /**
     * Clear feeds
     *
     * @param string $channel
     */
    protected function clearFeeds($channel = 'default')
    {
        $this->feeds[$channel] = array();
    }

    /**
     * Create Channel if not exist;
     *
     * @param string $channel
     */
    protected function createChannel($channel = 'default')
    {
        if (!isset($this->feeds[$channel])) {
            $this->feeds[$channel] = array();
        }
        if (!is_array($this->feeds[$channel])) {
            $this->feeds[$channel] = array();
        }
    }

    /**
     *
     * @param  string $url
     * @return boolean
     */
    protected function isValidURL($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL) ? true : false;
    }
}
