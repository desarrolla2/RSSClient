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

use Desarrolla2\RSSClient\Factory\Atom10NodeFactory;
use Desarrolla2\RSSClient\Handler\Sanitizer\SanitizerHandlerDummy;
use \DOMDocument;

/**
 * 
 * Description of Atom10NodeFactoryTest
 *
 * @author : Daniel González <daniel.gonzalez@freelancemadrid.es> 
 * @file : Atom10NodeFactoryTest.php , UTF-8
 * @date : Mar 24, 2013 , 7:14:45 PM
 */
class Atom10NodeFactoryTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var \Desarrolla2\RSSClient\Handler\Sanitizer\SanitizerHandlerDummy
     */
    protected $sanitizer;

    /**
     * @var \Desarrolla2\RSSClient\Factory\Atom10NodeFactory 
     */
    protected $factory;

    /**
     * @var \Desarrolla2\RSSClient\Node\Atom10
     */
    protected $node;

    /**
     * Setup
     */
    public function setUp() {
        $this->sanitizer = new SanitizerHandlerDummy();
        $this->factory = new Atom10NodeFactory($this->sanitizer);
        $sting = file_get_contents(__DIR__ . '/data/atom10_item.xml');
        $doc = DOMDocument::loadXML($sting);
        $item = $doc->getElementsByTagName('entry')->item(0);
        $this->node = $this->factory->create($item);
    }
        /**
     * @test
     */
    public function testLink() {
        $this->assertEquals('http://www.ubuntuleon.com/2013/03/gps-para-seres-humanos-ii-instalando.html', $this->node->getLink());
    }
    

    /**
     * @test
     */
    public function testCategories() {
        $this->assertEquals('6', count($this->node->getCategories()));
    }

    /**
     * @test
     */
    public function testDescription() {
        $this->assertEquals('En el primer artículo de la serie ...', $this->node->getDescription());
    }

    /**
     * @test
     */
    public function testTitle() {
        $this->assertEquals('GPS para seres humanos II. Instalando cartografía digital', $this->node->getTitle());
    }

    /**
     * @test
     */
    public function testPubDate() {
        $this->assertEquals('19', $this->node->getPubDate()->format('d'));
    }

}