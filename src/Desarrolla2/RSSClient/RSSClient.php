<?php

/**
 * This file is part of the RSSClient proyect.
 * 
 * Copyright (c)
 * Daniel González <daniel.gonzalez@freelancemadrid.es> 
 * 
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\RSSClient;

use Desarrolla2\RSSClient\RSSNode;
use Desarrolla2\RSSClient\RSSClientInterface;
use Desarrolla2\RSSClient\Sanitizer\SanitizerInterface;

/**
 * 
 * Description of Client
 *
 * @author : Daniel González <daniel.gonzalez@freelancemadrid.es> 
 * @file : Client.php , UTF-8
 * @date : Oct 3, 2012 , 2:07:02 AM
 */
class RSSClient implements RSSClientInterface
{

    /**
     *
     * @var \Desarrolla2\RSSClient\Sanitizer\SanitizerInterface;
     */
    protected $sanitizer;

    /**
     * @var array 
     */
    protected $feeds = array();

    /**
     * @var array 
     */
    protected $nodes = array();

    /**
     * @var array 
     */
    protected $errors = array();

    /**
     * Construnctor
     * 
     * @param string $channel
     * @param array $feeds
     */
    public function __construct(SanitizerInterface $sanitizer, $feeds = array(), $channel = 'default')
    {
        $this->sanitizer = $sanitizer;

        if (is_array($feeds)) {
            $this->setFeeds($feeds, $channel);
        }
        return;
    }

    /**
     * add channels for client
     * 
     * @param type $channels
     */
    public function addChannels($channels)
    {
        if (!is_array($channels)) {
            throw new \Exception('channels not valid (' . gettype($channels) . ')');
        }
        foreach ($channels as $channel => $feeds) {
            $this->addFeeds($feeds, $channel);
        }
        return;
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
     * Retrieve Channel Names
     * 
     * @return array $channels
     */
    public function getChannelsNames()
    {
        $channels = array();
        foreach ($this->feeds as $channel => $feed) {
            array_push($channels, $channel);
        }
        return $channels;
    }

    /**
     * Retrieve feeds from a channel
     * 
     * @param string $channel
     * @return array feeds
     */
    public function getFeeds($channel = 'default')
    {
        $this->createChannel($channel);
        return $this->feeds[$channel];
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
        return;
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
        return;
    }

    /**
     * Set feeds in a channel
     * 
     * @param array $feeds
     * @param string $channel 
     */
    public function setFeeds($feeds, $channel = 'default')
    {
        if (!is_array($feeds)) {
            throw new \Exception('feeds not valid (' . gettype($feeds) . ')');
        }
        if (count($feeds)) {
            $this->clearFeeds($channel);
            $this->addFeeds($feeds, $channel);
        }
        return;
    }

    /**
     * Add feed to channel
     * 
     * @param string $feed 
     * @param string $channel
     */
    public function addFeed($feed, $channel = 'default')
    {
        if (!is_string($feed)) {
            throw new \Exception('feed not valid (' . gettype($feed) . ')');
        }
        if (!is_string($channel)) {
            throw new \Exception('channel not valid (' . gettype($channel) . ')');
        }

        if ($this->isValidURL($feed)) {
            $this->createChannel($channel);
            if (!in_array($feed, $this->feeds[$channel])) {
                array_push($this->feeds[$channel], $feed);
            } else {
                $this->addError('tryint to add feed (' . $feed . ') that exist in channel (' . $channel . ')');
            }
        } else {
            throw new \Exception('URL not valid ' . $feed);
        }
        return;
    }

    /**
     * Add feeds to channel
     *       
     * @param array $feeds 
     * @param string $channel
     */
    public function addFeeds($feeds, $channel = 'default')
    {
        if (!is_array($feeds)) {
            throw new \Exception('feeds not valid (' . gettype($feeds) . ')');
        }
        if (!is_string($channel)) {
            throw new \Exception('channel not valid (' . gettype($channel) . ')');
        }
        foreach ($feeds as $feed) {
            $this->addFeed($feed, $channel);
        }
        return;
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
     * @param string $channel
     * @return int count $feeds
     */
    public function countFeeds($channel = 'default')
    {
        $this->createChannel($channel);
        return count($this->feeds[$channel]);
    }

    /**
     * Retrieve the number of nodes from a chanel
     * 
     * @param string $channel
     * @return int count $nodes
     */
    public function countNodes($channel = 'default')
    {
        if (!isset($this->nodes[$channel])) {
            $this->nodes[$channel] = array();
        }
        if (!is_array($this->nodes[$channel])) {
            $this->nodes[$channel] = array();
        }
        return count($this->nodes[$channel]);
    }

    /**
     * Retrieve nodes from a chanel
     * 
     * @param int $limit
     * @param string $channel
     * @return int $nodes
     */
    public function fetch($channel = 'default', $limit = 20)
    {
        if (!is_string($channel)) {
            throw new \Exception('channel not valid (' . gettype($channel) . ')');
        }
        if (in_array($channel, $this->feeds)) {
            throw new \Exception('channel not valid (' . $channel . ')');
        }
        if (!is_integer($limit)) {
            throw new \Exception('limit not valid (' . gettype($limit) . ')');
        }
        foreach ($this->feeds[$channel] as $feed) {
            $feed = @file_get_contents($feed);
            if ($feed) {
                $DOMDocument = new \DOMDocument();
                $DOMDocument->strictErrorChecking = false;
                if ($DOMDocument->loadXML($feed)) {
                    $nodes = $DOMDocument->getElementsByTagName('item');
                    foreach ($nodes as $node) {
                        $this->addFromNode($node);
                    }
                }
            }
        }
        $this->sort($channel);

        return $this->getNodes($channel, $limit);
    }

    /**
     * Retrieve errors stack
     * 
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Retrieve if any errors ocurred
     * @return boolean
     */
    public function hasErrors()
    {
        return count($this->errors) ? true : false;
    }

    /**
     * Add Error to stack
     * 
     * @param string $message
     */
    protected function addError($message)
    {
        $message = (string) $message;
        array_push($this->errors, $message);
        return;
    }

    /**
     * @param type $node
     */
    protected function addFromNode($node)
    {
        try {
            $node = array(
                'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
                'desc'  => $node->getElementsByTagName('description')->item(0)->nodeValue,
                'link'  => $node->getElementsByTagName('link')->item(0)->nodeValue,
                'date'  => $node->getElementsByTagName('pubDate')->item(0)->nodeValue
            );
        }
        catch (Exception $e) {
            $this->addError($e->getMessage());
        }

        foreach ($node as $key => $value) {
            $node[$key] = $this->doClean($value);
        }

        $this->addNode(
                new RSSNode($node), $channel
        );
    }

    /**
     * Add node
     * 
     * @param RSSNode $node
     * @param string $channel
     */
    protected function addNode(RSSNode $node, $channel = 'default')
    {
        if (!isset($this->nodes[$channel])) {
            $this->nodes[$channel] = array();
        }
        if (!is_array($this->nodes[$channel])) {
            $this->nodes[$channel] = array();
        }
        array_push($this->nodes[$channel], $node);
        return;
    }

    /**
     * Clear Channels
     * 
     * @return type
     */
    protected function clearChannels()
    {
        $this->feeds = array();
        return;
    }

    /**
     * Clear feeds
     * 
     * @param string $channel
     */
    protected function clearFeeds($channel = 'default')
    {
        $this->feeds[$channel] = array();
        return;
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
            return;
        }
        if (!is_array($this->feeds[$channel])) {
            $this->feeds[$channel] = array();
            return;
        }
        return;
    }

    /**
     * 
     * @param string $text
     * @return string
     */
    protected function doClean($text)
    {
        return $this->sanitizer->doClean($text);
    }

    /**
     * Retrieves a $limit number of nodes
     * 
     * @param int $limit
     * @param string $channel
     * @return array $nodes
     */
    protected function getNodes($channel = 'default', $limit = 20)
    {
        if (!is_string($channel)) {
            throw new \Exception('channel not valid (' . gettype($channel) . ')');
        }
        if (in_array($channel, $this->feeds)) {
            throw new \Exception('channel not valid (' . $channel . ')');
        }
        if (!is_integer($limit)) {
            throw new \Exception('limit not valid (' . gettype($limit) . ')');
        }
        if (is_array($this->nodes[$channel])) {
            if (count($this->nodes[$channel])) {
                $response = array();
                for ($i = 0; $i < $limit; $i++) {
                    if (isset($this->nodes[$channel][$i])) {
                        array_push($response, $this->nodes[$channel][$i]);
                    }
                }
                return $response;
            }
        }
        $this->addError('Not nodes found in ' . $channel);

        return false;
    }

    /**
     * 
     * @param type $url
     * @return boolean
     */
    protected function isValidURL($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL) ? true : false;
    }

    /**
     * Sort by buuble method
     * 
     * @param string $channel
     */
    protected function sort($channel = 'default')
    {
        $countNodes = $this->countNodes($channel);
        for ($i = 1; $i < $countNodes; $i++) {
            for ($j = 0; $j < $countNodes - $i; $j++) {
                if ($this->nodes[$channel][$j]->getTimestamp() < $this->nodes[$channel][$j + 1]->getTimestamp()) {
                    $k = $this->nodes[$channel][$j + 1];
                    $this->nodes[$channel][$j + 1] = $this->nodes[$channel][$j];
                    $this->nodes[$channel][$j] = $k;
                }
            }
        }
        return;
    }

}
