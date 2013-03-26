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

namespace Desarrolla2\RSSClient\Parser\Test;

use Desarrolla2\RSSClient\Parser\FeedParser;
use Desarrolla2\RSSClient\Handler\Sanitizer\SanitizerHandlerDummy;

/**
 * 
 * Description of UbuntuLeonTest
 *
 * @author : Daniel González <daniel.gonzalez@freelancemadrid.es> 
 * @file : UbuntuLeonTest.php , UTF-8
 * @date : Mar 24, 2013 , 8:08:54 PM
 */
class UbuntuLeonTest extends \PHPUnit_Framework_TestCase {

    /**
     *
     * @var \Desarrolla2\RSSClient\Parser\FeedParser
     */
    protected $parser;

    /**
     *
     * @var \Desarrolla2\RSSClient\Node\NodeCollection 
     */
    protected $nodes;

    /**
     *
     * @var \Desarrolla2\RSSClient\Node\RSS20
     */
    protected $first;

    /**
     * Setup
     */
    public function setUp() {
        $this->parser = new FeedParser();
        $this->sanitizer = new SanitizerHandlerDummy();
        $feed = file_get_contents(__DIR__ . '/data/ubuntuleon.xml');
        $this->nodes = $this->parser->parse($feed, $this->sanitizer);
        
    }

    /**
     * @test
     */
    public function totalItemTest() {
        $this->assertEquals($this->nodes->count(), 25);
    }

    /**
     * @test
     */
    public function firstItemLinkTest() {
        $this->first = $this->nodes->getFirst();
        $this->assertEquals($this->first->getLink(), 'http://www.ubuntuleon.com/2013/03/gps-para-seres-humanos-ii-instalando.html');
    }

}
