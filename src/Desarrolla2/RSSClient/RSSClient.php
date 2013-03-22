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
use Desarrolla2\RSSClient\Parser\FeedParser;
use Desarrolla2\RSSClient\Handler\HTTP\HTTPHandler;
use Desarrolla2\RSSClient\Handler\HTTP\HTTPHandlerInterface;
use Desarrolla2\RSSClient\Handler\Feed\FeedHandler;
use Desarrolla2\RSSClient\Handler\Sanitizer\SanitizerHandler;
use Desarrolla2\RSSClient\Handler\Sanitizer\SanitizerHandlerInterface;

/**
 * 
 * Description of RSSClient
 *
 * @author : Daniel González <daniel.gonzalez@freelancemadrid.es> 
 * @file : Client.php , UTF-8
 * @date : Oct 3, 2012 , 2:07:02 AM
 */
class RSSClient extends FeedHandler implements RSSClientInterface {

    const MAX_NODES_DEFAULT = 200;

    /**
     *
     * @var \Desarrolla2\RSSClient\Handler\Sanitizer\SanitizerHandlerInterface;
     */
    protected $sanitizerHandler;

    /**
     *
     * @var \Guzzle\Http\ClientInterface 
     */
    protected $httpHandler;

    /**
     *
     * @var \Desarrolla2\RSSClient\Parser\FeedParser
     */
    protected $parser;

    /**
     * Constructor
     * 
     * @param \Desarrolla2\RSSClient\Sanitizer\SanitizerInterface $sanitizer
     * @param string $channel
     * @param array $feeds
     */
    public function __construct(array $feeds = array(), $channel = 'default') {
        $this->httpHandler = new HTTPHandler();
        $this->sanitizerHandler = new SanitizerHandler();
        $this->parser = new FeedParser();
        $this->setFeeds($feeds, $channel);
    }

    /**
     * set HTTPClient
     * 
     * @param \Desarrolla2\RSSClient\Handler\HTTP\HTTPHandlerInterface $handler
     * @return type
     */
    public function setHTTPHandler(HTTPHandlerInterface $handler) {
        $this->httpHandler = $handler;
    }

    /**
     * Set Sanitizer
     * 
     * @param \Desarrolla2\RSSClient\Handler\Sanitizer\SanitizerHandlerInterface $handler
     */
    public function setSanitizerHandler(SanitizerHandlerInterface $handler) {
        $this->sanitizerHandler = $handler;
    }

    /**
     * Retrieve the number of nodes from a chanel
     * 
     * @param string $channel
     * @return int count $nodes
     */
    public function countNodes($channel = 'default') {
        if (!isset($this->nodes[$channel])) {
            $this->nodes[$channel] = array();
        }
        return count($this->nodes[$channel]);
    }

    /**
     * Retrieve nodes from a chanel
     * 
     * @param int $limit
     * @param string $channel
     * @return array $nodes
     * @throws \InvalidArgumentException
     */
    public function fetch($channel = 'default', $limit = self::MAX_NODES_DEFAULT) {
        if (!is_string($channel)) {
            throw new \InvalidArgumentException('channel not valid (' . gettype($channel) . ')');
        }
        if (!isset($this->feeds[$channel])) {
            throw new \InvalidArgumentException('channel not valid (' . $channel . ')');
        }
        $limit = (int) $limit;
        if (!$limit) {
            throw new \InvalidArgumentException('limit not valid (' . $limit . ')');
        }
        foreach ($this->feeds[$channel] as $feed) {
            try {
                $feed = $this->fetchHTTP($feed);
                if ($feed) {
                    $nodes = $this->parser->parse($feed, $this->sanitizerHandler);
                }
            } catch (Exception $e) {
                $this->addError($e->getMessage());
            }
        }
        $this->sort($channel);

        return $this->getNodes($channel, $limit);
    }

    /**
     * Retrieves a $limit number of nodes
     * 
     * @param int $limit
     * @param string $channel
     * @return array $nodes
     */
    protected function getNodes($channel = 'default', $limit = self::MAX_NODES_DEFAULT) {
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
     * @param string $feedUrl
     * @return string
     */
    protected function fetchHTTP($feedUrl) {
        try {
            return $this->httpHandler->get($feedUrl);
        } catch (Exception $e) {
            $this->addError($e->getMessage());
        }
        return '';
    }

    /**
     * Sort by buuble method
     * 
     * @param string $channel
     */
    protected function sort($channel = 'default') {
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
    }

}
