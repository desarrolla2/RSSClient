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

    const RSS20_SCHEMA_FILE = '/schemas/rss20.xsd';

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

    public function __construct() {
        $this->xml = new DOMDocument();
        $this->xml->strictErrorChecking = false;
    }

    public function parse($feed, SanitizerHandlerInterface $sanitizer) {
        $this->nodes = new NodeCollection();
        try {
            $this->xml->loadXML($feed);
        } catch (\Exception $e) {
            throw new ParseException($e->getMessage());
        }

        switch ($this->getSchema()) {
            case 'RSS20':
                $factory = new RSS20NodeFactory($sanitizer);
                $items = $this->xml->getElementsByTagName('item');
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
                break;
            default:
                break;
        }

        return $this->nodes;
    }

    protected function getSchema() {
        if ($this->xml->schemaValidate(__DIR__ . self::RSS20_SCHEMA_FILE)) {
            return 'RSS20';
        }
        return false;
    }

}
