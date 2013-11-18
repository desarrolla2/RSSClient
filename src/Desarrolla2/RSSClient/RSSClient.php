<?php

/**
 * This file is part of the RSSClient project.
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
use Desarrolla2\RSSClient\Parser\ParserInterface;
use Desarrolla2\RSSClient\Handler\HTTP\HTTPHandler;
use Desarrolla2\RSSClient\Handler\HTTP\HTTPHandlerInterface;
use Desarrolla2\RSSClient\Handler\Feed\FeedHandler;
use Desarrolla2\RSSClient\Handler\Sanitizer\SanitizerHandler;
use Desarrolla2\RSSClient\Handler\Sanitizer\SanitizerHandlerInterface;
use Desarrolla2\RSSClient\Node\NodeCollection;
use Desarrolla2\RSSClient\Parser\Processor\ProcessorInterface;

/**
 *
 * RSSClient is a class to handling fetch feeds
 *
 * @author : Daniel González <daniel.gonzalez@freelancemadrid.es>
 */
class RSSClient extends FeedHandler implements RSSClientInterface
{
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
     * @param array  $feeds
     */
    public function __construct(array $feeds = array(), $channel = 'default')
    {
        $this->httpHandler = new HTTPHandler();
        $this->sanitizerHandler = new SanitizerHandler();
        $this->parser = new FeedParser();
        $this->setFeeds($feeds, $channel);
    }

    /**
     * set HTTP Handler
     *
     * @param HTTPHandlerInterface $handler
     */
    public function setHTTPHandler(HTTPHandlerInterface $handler)
    {
        $this->httpHandler = $handler;
    }

    /**
     * Set Sanitizer
     *
     * @param SanitizerHandlerInterface $handler
     */
    public function setSanitizerHandler(SanitizerHandlerInterface $handler)
    {
        $this->sanitizerHandler = $handler;
    }

    /**
     * @param ParserInterface $parser
     */
    public function setParser(ParserInterface $parser)
    {
        $this->parser = $parser;
    }

    /**
     * @param ProcessorInterface $processor
     *
     * @throws \InvalidArgumentException
     */
    public function pushProcessor(ProcessorInterface $processor)
    {
        $this->parser->pushProcessor($processor);
    }

    /**
     * @return \Guzzle\Http\ClientInterface
     */
    public function getHttpHandler()
    {
        return $this->httpHandler;
    }

    /**
     * @return \Desarrolla2\RSSClient\Parser\FeedParser
     */
    public function getParser()
    {
        return $this->parser;
    }

    /**
     * @return \Desarrolla2\RSSClient\Handler\Sanitizer\SanitizerHandlerInterface
     */
    public function getSanitizerHandler()
    {
        return $this->sanitizerHandler;
    }



    /**
     * Retrieve nodes from a chanel
     *
     * @param  string $channel
     * @param  int    $limit
     *
     * @return NodeCollection
     * @throws \InvalidArgumentException
     */
    public function fetch($channel = 'default', $limit = 100)
    {
        if (!is_string($channel)) {
            throw new \InvalidArgumentException('channel not valid (' . gettype($channel) . ')');
        }
        if (!isset($this->feeds[$channel])) {
            throw new \InvalidArgumentException('channel not valid (' . $channel . ')');
        }
        $this->nodes = new NodeCollection();
        foreach ($this->feeds[$channel] as $feed) {
            $this->fetchFeed($feed);
        }
        $this->nodes->short();
        $this->nodes->limit($limit);

        return $this->nodes;
    }

    /**
     * @param string $feed
     */
    protected function fetchFeed($feed)
    {
        try {
            $feed = $this->fetchHTTP($feed);
            if ($feed) {
                $nodes = $this->parser->parse($feed, $this->sanitizerHandler);
                foreach ($nodes as $node) {
                    $this->nodes->append($node);
                }
            }
        } catch (\Exception $e) {
            $this->addError($e->getMessage());
        }
    }

    /**
     * Retrieve feeds content
     *
     * @param  string $feedUrl
     *
     * @return string
     */
    protected function fetchHTTP($feedUrl)
    {
        try {
            return $this->httpHandler->get($feedUrl);
        } catch (\Exception $e) {
            $this->addError($e->getMessage());
        }

        return '';
    }
}
