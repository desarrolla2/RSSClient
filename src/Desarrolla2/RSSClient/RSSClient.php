<?php

/**
 * This file is part of the RSSClient package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desarrolla2\RSSClient;

use Desarrolla2\RSSClient\Parser\FeedParser;
use Desarrolla2\RSSClient\Parser\ParserInterface;
use Desarrolla2\RSSClient\Handler\HTTP\HTTPHandler;
use Desarrolla2\RSSClient\Handler\HTTP\HTTPHandlerInterface;
use Desarrolla2\RSSClient\Handler\Feed\FeedHandler;
use Desarrolla2\RSSClient\Handler\Sanitizer\SanitizerHandlerInterface;
use Desarrolla2\RSSClient\Node\NodeCollection;
use Desarrolla2\RSSClient\Parser\Processor\ProcessorInterface;

/**
 * RSSClient is a class to handling fetch feeds
 * 
 * 
 *
 * @deprecated RSSClient will not be updated, you should consider migrating to FastFeed 
 * @see https://github.com/FastFeed/FastFeed
 */
class RSSClient extends FeedHandler implements RSSClientInterface
{
    /**
     * @var HTTPHandlerInterface
     */
    protected $httpHandler;

    /**
     * @var ParserInterface
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
        $this->parser = new FeedParser();
        $this->setFeeds($feeds, $channel);
    }

    /**
     * Set the handler for http request
     *
     * @param HTTPHandlerInterface $handler
     */
    public function setHTTPHandler(HTTPHandlerInterface $handler)
    {
        $this->httpHandler = $handler;
    }

    /**
     * Get the handler for http request
     *
     * @return HTTPHandlerInterface
     */
    public function getHttpHandler()
    {
        return $this->httpHandler;
    }

    /**
     * Set the handler for parse nodes
     *
     * @param ParserInterface $parser
     */
    public function setParser(ParserInterface $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Set the handler for parse nodes
     *
     * @return ParserInterface
     */
    public function getParser()
    {
        return $this->parser;
    }

    /**
     * Set Sanitizer handler for clean nodes
     *
     * @param SanitizerHandlerInterface $handler
     */
    public function setSanitizer(SanitizerHandlerInterface $handler)
    {
        $this->parser->setSanitizer($handler);
    }

    /**
     * Get Sanitizer handler for clean nodes
     *
     * @return SanitizerHandlerInterface
     */
    public function getSanitizer()
    {
        return $this->parser->getSanitizer();
    }

    /**
     * Adds a processor on to the stack.
     *
     * @param ProcessorInterface $processor
     */
    public function pushProcessor(ProcessorInterface $processor)
    {
        $this->parser->pushProcessor($processor);
    }

    /**
     * @return ProcessorInterface
     */
    public function popProcessor()
    {
        return $this->parser->popProcessor();
    }

    /**
     * Retrieve nodes from a channel
     *
     * @param  string $channel
     * @param  int    $limit
     *
     * @return NodeCollection
     * @throws \InvalidArgumentException
     */
    public function fetch($channel = 'default', $limit = 100)
    {
        $nodes = new NodeCollection();
        $channel = $this->getChannel($channel);
        foreach ($this->feeds[$channel] as $feed) {
            $this->fetchFeed($feed, $nodes);
        }
        $nodes->short();
        $nodes->limit($limit);

        return $nodes;
    }

    /**
     * @param $channel
     *
     * @return mixed
     * @throws \InvalidArgumentException
     */
    protected function getChannel($channel)
    {
        if (!is_string($channel)) {
            throw new \InvalidArgumentException('channel not valid (' . gettype($channel) . ')');
        }
        if (!isset($this->feeds[$channel])) {
            throw new \InvalidArgumentException('channel not valid (' . $channel . ')');
        }

        return $channel;
    }

    /**
     * @param string         $feed
     * @param NodeCollection $nodes
     */
    protected function fetchFeed($feed, $nodes)
    {
        try {
            $feed = $this->fetchHTTP($feed);
            if ($feed) {
                $feedNodes = $this->parser->parse($feed);
                foreach ($feedNodes as $node) {
                    $nodes->append($node);
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
