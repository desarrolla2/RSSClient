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

use Desarrolla2\RSSClient\RSSClientInterface;
use Desarrolla2\RSSClient\Parser\FeedParser;
use Desarrolla2\RSSClient\Handler\HTTP\HTTPHandler;
use Desarrolla2\RSSClient\Handler\HTTP\HTTPHandlerInterface;
use Desarrolla2\RSSClient\Handler\Feed\FeedHandler;
use Desarrolla2\RSSClient\Handler\Sanitizer\SanitizerHandler;
use Desarrolla2\RSSClient\Handler\Sanitizer\SanitizerHandlerInterface;
use Desarrolla2\RSSClient\Node\NodeCollection;

/**
 * 
 * Description of RSSClient
 *
 * @author : Daniel González <daniel.gonzalez@freelancemadrid.es> 
 * @file : Client.php , UTF-8
 * @date : Oct 3, 2012 , 2:07:02 AM
 */
class RSSClient extends FeedHandler implements RSSClientInterface {

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
     * Retrieve nodes from a chanel
     * 
     * @param int $limit
     * @param string $channel
     * @return array $nodes
     * @throws \InvalidArgumentException
     */
    public function fetch($channel = 'default') {
        if (!is_string($channel)) {
            throw new \InvalidArgumentException('channel not valid (' . gettype($channel) . ')');
        }
        if (!isset($this->feeds[$channel])) {
            throw new \InvalidArgumentException('channel not valid (' . $channel . ')');
        }
        $this->nodes = new NodeCollection();
        foreach ($this->feeds[$channel] as $feed) {
            try {
                $feed = $this->fetchHTTP($feed);
                if ($feed) {
                    $nodes = $this->parser->parse($feed, $this->sanitizerHandler);
                    foreach ($nodes as $node) {
                        $this->nodes->append($node);
                    }
                }
            } catch (Exception $e) {
                $this->addError($e->getMessage());
            }
        }
        $this->nodes->short();
        return $this->nodes;
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

}
