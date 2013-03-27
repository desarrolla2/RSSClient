<?php

/**
 * This file is part of the RSSClient proyect.
 * 
 * Copyright (c)
 * Daniel González Cerviño <daniel.gonzalez@externos.seap.minhap.es>  
 * 
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\RSSClient\Parser\Test;

use Desarrolla2\RSSClient\Parser\FeedParser;
use Desarrolla2\RSSClient\Handler\Sanitizer\SanitizerHandlerDummy;

/**
 * 
 * Description of FeedParserTest
 *
 * @author : Daniel González Cerviño <daniel.gonzalez@externos.seap.minhap.es>  
 * @file : FeedParserTest.php , UTF-8
 * @date : Mar 27, 2013 , 1:00:07 PM
 */
class FeedParserTest extends \PHPUnit_Framework_TestCase {

    /**
     *
     * @var \Desarrolla2\RSSClient\Parser\FeedParser
     */
    protected $parser;

    /**
     * Setup
     */
    public function setUp() {
        $this->parser = new FeedParser();
        $this->sanitizer = new SanitizerHandlerDummy();
    }

    /**
     * 
     * @return array
     */
    public function dataProvider() {
        return array(
            array(
                '/data/ubuntuleon.atom',
                25,
            ),
            array(
                '/data/nyt.rss',
                25,
            ),
            array(
                '/data/ubuntuleon.rss',
                25,
            ),
        );
    }

    /**
     * @test
     * @dataProvider dataProvider
     * @param type $file
     * @param type $items
     */
    public function feedParserTest($file, $items) {
        $string = file_get_contents(__DIR__ . $file);
        $nodes = $this->parser->parse($string, $this->sanitizer);
        $this->assertEquals($items, $nodes->count());
    }

}
