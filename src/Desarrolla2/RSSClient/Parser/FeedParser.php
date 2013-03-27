<?php

/**
 * This file is part of the RSSClient proyect.
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
use Desarrolla2\RSSClient\Exception\ParseException;

/**
 * 
 * Description of Parser
 *
 * @author : Daniel González Cerviño <daniel.gonzalez@freelancemadrid.es>  
 * @file : Parser.php , UTF-8
 * @date : Mar 22, 2013 , 12:36:14 PM
 */
class FeedParser implements ParserInterface {

    const RSS20_SCHEMA_FILE = 'rss20.xsd';
    const ATOM10_SCHEMA_FILE = 'atom10.xsd';

    /**
     *
     * @var \DOMDocument 
     */
    protected $xml;

    /**
     *
     * @var type 
     */
    protected $nodes = array();

    /**
     * @var string
     */
    protected $schemaPath;

    public function __construct() {
        $this->xml = new DOMDocument();
        $this->xml->strictErrorChecking = false;
        $this->schemaPath = __DIR__ . '/schemas/';
    }

    public function parse($feed, SanitizerHandlerInterface $sanitizer) {
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

    protected function parseTagsWithFactory($tagName, $factory) {
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

    protected function getSchema() {
//        if ($this->trySchema(self::RSS20_SCHEMA_FILE)) {
//            return 'RSS20';
//        }
//        if ($this->trySchema(self::ATOM10_SCHEMA_FILE)) {
//            return 'ATOM10';
//        }
        if ($this->isRSS20()) {
            return 'RSS20';
        }
        if ($this->isAtom10()) {
            return 'ATOM10';
        }
        return false;
    }

    protected function isRSS20() {
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

    protected function isAtom10() {
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
     * 
     * @param type $schema
     * @return boolean
     * @throws \Desarrolla2\RSSClient\Exception\ParseException
     */
    protected function trySchema($schema) {
        try {
            if ($this->xml->schemaValidate($this->schemaPath . $schema)) {
                return true;
            }
        } catch (\Exception $e) {
            throw new ParseException($e->getMessage());
        }
        return false;
    }

}
