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
 * Description of NYTTest
 *
 * @author : Daniel González Cerviño <daniel.gonzalez@externos.seap.minhap.es>  
 * @file : NYTTest.php , UTF-8
 * @date : Mar 22, 2013 , 3:48:36 PM
 */
class NYTTest extends \PHPUnit_Framework_TestCase {

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
        $feed = file_get_contents(__DIR__ . '/data/nyt.xml');
        $this->nodes = $this->parser->parse($feed, $this->sanitizer);
        $this->first = $this->nodes->getFirst();
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
    public function firstItemTest() {
        $this->assertEquals($this->first->getTitle(), 'At Yad Vashem in Israel, Obama Urges Action Against Racism');
        $this->assertEquals($this->first->getGuid(), 'http://www.nytimes.com/2013/03/23/world/middleeast/president-obama-israel.html');        
        $this->assertEquals($this->first->getDescription(), 'Short description');
        $this->assertEquals($this->first->getLink(), 'http://www.nytimes.com/2013/03/23/world/middleeast/president-obama-israel.html?partner=rss&amp;emc=rss');
        $this->assertEquals($this->first->getPubDate()->format('d'), '22');
        $this->assertEquals(count($this->first->getCategories()), '4');
        
    }

}
