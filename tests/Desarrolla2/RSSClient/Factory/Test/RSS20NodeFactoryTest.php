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

namespace Desarrolla2\RSSClient\Factory\Test;

use Desarrolla2\RSSClient\Factory\RSS20NodeFactory;
use Desarrolla2\RSSClient\Handler\Sanitizer\SanitizerHandlerDummy;
use \DOMDocument;

/**
 * 
 * Description of RSS20NodeFactoryTest
 *
 * @author : Daniel González <daniel.gonzalez@freelancemadrid.es> 
 * @file : RSS20NodeFactoryTest.php , UTF-8
 * @date : Mar 24, 2013 , 6:20:28 PM
 */
class RSS20NodeFactoryTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var \Desarrolla2\RSSClient\Handler\Sanitizer\SanitizerHandlerDummy
     */
    protected $sanitizer;

    /**
     * @var \Desarrolla2\RSSClient\Factory\RSS20NodeFactory
     */
    protected $factory;

    /**
     * @var \Desarrolla2\RSSClient\Node\RSS20
     */
    protected $node;

    /**
     * Setup
     */
    public function setUp() {
        $this->sanitizer = new SanitizerHandlerDummy();
        $this->factory = new RSS20NodeFactory($this->sanitizer);
        $sting = file_get_contents(__DIR__ . '/data/rss20_item.xml');
        $dom = new DOMDocument();
        $dom->loadXML($sting);
        $item = $dom->getElementsByTagName('item')->item(0);
        $this->node = $this->factory->create($item);
    }

    /**
     * @test
     */
    public function testTitle() {
        $this->assertEquals($this->node->getTitle(), 'At Yad Vashem in Israel, Obama Urges Action Against Racism');
    }

    /**
     * @test
     */
    public function testGUID() {
        $this->assertEquals($this->node->getGuid(), 'http://www.nytimes.com/2013/03/23/world/middleeast/president-obama-israel.html');
    }

    /**
     * @test
     */
    public function testCategories() {
        $this->assertEquals(count($this->node->getCategories()), '4');
    }

    /**
     * @test
     */
    public function testLink() {
        $this->assertEquals($this->node->getLink(), 'http://www.nytimes.com/2013/03/23/world/middleeast/president-obama-israel.html?partner=rss&emc=rss');
    }

    /**
     * @test
     */
    public function testDescription() {
        $this->assertEquals($this->node->getDescription(), 'Short description');
    }

    /**
     * @test
     */
    public function testPubDate() {
        $this->assertEquals($this->node->getPubDate()->format('d'), '22');
    }

}