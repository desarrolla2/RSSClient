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
use Desarrolla2\RSSClient\Node\NodeCollection;
use Desarrolla2\RSSClient\Handler\Sanitizer\SanitizerHandler;
use Desarrolla2\RSSClient\Handler\Sanitizer\SanitizerHandlerInterface;
use Desarrolla2\RSSClient\Factory\RSS20NodeFactory;
use Desarrolla2\RSSClient\Factory\Atom10NodeFactory;
use Desarrolla2\RSSClient\Exception\ParseException;
use Desarrolla2\RSSClient\Parser\Processor\ProcessorInterface;

/**
 *
 * FeedParser
 *
 * @author : Daniel González Cerviño <daniel.gonzalez@freelancemadrid.es>
 */
class FeedParser implements ParserInterface
{
    /**
     * @var array;
     */
    protected $processors = array();

    /**
     * @var SanitizerHandlerInterface
     */
    protected $sanitizer;

    public function __construct()
    {
        $this->sanitizer = new SanitizerHandler();
    }

    /**
     * Set handler for clean request
     *
     * @param SanitizerHandlerInterface $sanitizer
     */
    public function setSanitizer(SanitizerHandlerInterface $sanitizer)
    {
        $this->sanitizer = $sanitizer;
    }

    /**
     * Get Sanitizer
     *
     * @return mixed
     */
    public function getSanitizer()
    {
        return $this->sanitizer;
    }

    /**
     * Adds a processor on to the stack.
     *
     * @param ProcessorInterface $processor
     */
    public function pushProcessor(ProcessorInterface $processor)
    {
        $this->processors[] = $processor;
    }

    /**
     * Removes the processor on top of the stack and returns it.
     *
     * @return mixed
     * @throws \LogicException
     */
    public function popProcessor()
    {
        if (!$this->processors) {
            throw new \LogicException('You tried to pop from an empty processor stack.');
        }

        return array_shift($this->processors);
    }

    /**
     *  Parse Feed and create a node collection
     *
     * @param  string $feed
     *
     * @return array
     * @throws ParseException
     */
    public function parse($feed)
    {
        $domDocument = $this->createDomDocument($feed);

        switch ($this->getSchema($domDocument)) {
            case 'RSS20':
                $nodes = $this->parseWithFactory(
                    new RSS20NodeFactory($this->sanitizer),
                    $domDocument,
                    'item'
                );
                break;
            case 'ATOM10':
                $nodes = $this->parseWithFactory(
                    new Atom10NodeFactory($this->sanitizer),
                    $domDocument,
                    'entry'
                );
                break;
            default:
                throw new ParseException('Schema not supported');
                break;
        }

        return $nodes;

    }

    /**
     * @param $feed
     *
     * @return DOMDocument
     * @throws ParseException
     */
    protected function createDomDocument($feed)
    {
        $previousUseLibXmlErrors = libxml_use_internal_errors(true);
        try {
            $domDocument = new DOMDocument();
            $domDocument->strictErrorChecking = false;
            $domDocument->loadXML(trim($feed));
        } catch (\Exception $e) {
            libxml_use_internal_errors($previousUseLibXmlErrors);
            throw new ParseException($e->getMessage());
        }
        libxml_use_internal_errors($previousUseLibXmlErrors);

        return $domDocument;
    }

    /**
     * @param $domDocument
     *
     * @return bool|string
     */
    protected function getSchema($domDocument)
    {
        if ($this->isRSS20($domDocument)) {
            return 'RSS20';
        }
        if ($this->isAtom10($domDocument)) {
            return 'ATOM10';
        }

        return false;
    }

    /**
     * @return bool
     * @throws ParseException
     */
    protected function isRSS20($domDocument)
    {
        try {
            $nodes = $domDocument->getElementsByTagName('rss');
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
     * @throws ParseException
     */
    protected function isAtom10($domDocument)
    {
        try {
            $nodes = $domDocument->getElementsByTagName('feed');
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

    protected function parseWithFactory($factory, $domDocument, $tagName)
    {
        $nodes = new NodeCollection();
        $items = $domDocument->getElementsByTagName($tagName);
        if ($items->length) {
            foreach ($items as $item) {
                try {
                    $node = $factory->create($item);
                    $this->executeProcessors($node, $item);
                    if ($node) {
                        $nodes->append($node);
                    }
                } catch (\Exception $e) {
                    throw new ParseException($e->getMessage());
                }
            }
        }

        return $nodes;
    }

    /**
     * @param $node
     * @param $item
     */
    protected function executeProcessors($node, $item)
    {
        foreach ($this->processors as $processor) {
            $processor->execute($node, $item);
        }
    }
}
