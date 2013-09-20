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

namespace Desarrolla2\RSSClient\Parser;

use \DOMDocument;
use Desarrolla2\RSSClient\Parser\ParserInterface;
use Desarrolla2\RSSClient\Handler\Sanitizer\SanitizerHandlerInterface;
use Desarrolla2\RSSClient\Node\NodeCollection;
use Desarrolla2\RSSClient\Factory\RSS20NodeFactory;
use Desarrolla2\RSSClient\Factory\Atom10NodeFactory;
use Desarrolla2\RSSClient\Factory\FactoryInterface;
use Desarrolla2\RSSClient\Exception\ParseException;

/**
 *
 * Description of Parser
 *
 * @author : Daniel González Cerviño <daniel.gonzalez@freelancemadrid.es>
 */
class FeedParser implements ParserInterface
{
    const RSS20_SCHEMA_FILE = 'rss20.xsd';
    const ATOM10_SCHEMA_FILE = 'atom10.xsd';

    /**
     *
     * @var \DOMDocument Feed XML Document
     */
    protected $xml;

    /**
     *
     * @var array nodes in feed
     */
    protected $nodes = array();

    /**
     * @var string path to schemas documents
     */
    protected $schemaPath;


    public function __construct()
    {
        $this->xml = new DOMDocument();
        $this->xml->strictErrorChecking = false;
        $this->schemaPath = __DIR__ . '/schemas/';
    }

    /**
     *
     * @param  string                                                             $feed
     * @param  \Desarrolla2\RSSClient\Handler\Sanitizer\SanitizerHandlerInterface $sanitizer
     * @return array
     * @throws ParseException
     */
    public function parse($feed, SanitizerHandlerInterface $sanitizer)
    {
        $this->nodes = new NodeCollection();
        try {
            $this->xml->loadXML(trim($feed));
        } catch (\Exception $e) {
            throw new ParseException($e->getMessage());
        }

        switch ($this->getSchema()) {
            case 'RSS20':
                $factory = new RSS20NodeFactory($sanitizer);
                $this->parseTagsWithFactory('item', $factory);
                break;
            case 'ATOM10':
                $factory = new Atom10NodeFactory($sanitizer);
                $this->parseTagsWithFactory('entry', $factory);
                break;
            default:
                throw new ParseException('Schema not supported');
                break;
        }

        return $this->nodes;
    }

    /**
     * @return bool|string
     */
    protected function getSchema()
    {
        if ($this->isRSS20()) {
            return 'RSS20';
        }
        if ($this->isAtom10()) {
            return 'ATOM10';
        }

        return false;
    }

    /**
     * @return bool
     * @throws \Desarrolla2\RSSClient\Exception\ParseException
     */
    protected function isRSS20()
    {
        try {
            $nodes = $this->xml->getElementsByTagName('rss');
            if ($nodes->length == 1) {
                $feed = $nodes->item(0);
                if ($feed->getAttribute('version') == '2.0') {
                    return true;
                }
            }
        } catch (Exception $e) {
            throw new ParseException($e->getMessage());
        }

        return false;
    }

    /**
     * @return bool
     * @throws \Desarrolla2\RSSClient\Exception\ParseException
     */
    protected function isAtom10()
    {
        try {
            $nodes = $this->xml->getElementsByTagName('feed');
            if ($nodes->length == 1) {
                $feed = $nodes->item(0);
                if ($feed->getAttribute('xmlns') == 'http://www.w3.org/2005/Atom') {
                    return true;
                }
            }
        } catch (Exception $e) {
            throw new ParseException($e->getMessage());
        }

        return false;
    }

    /**
     * @param string           $tagName
     * @param FactoryInterface $factory
     * @throws \Desarrolla2\RSSClient\Exception\ParseException
     */
    protected function parseTagsWithFactory($tagName, $factory)
    {
        $items = $this->xml->getElementsByTagName($tagName);
        if ($items->length) {
            foreach ($items as $item) {
                try {
                    $node = $factory->create($item);
                    if ($node) {
                        $this->nodes->append($node);
                    }
                } catch (\Exception $e) {
                    throw new ParseException($e->getMessage());
                }
            }
        }
    }
}
