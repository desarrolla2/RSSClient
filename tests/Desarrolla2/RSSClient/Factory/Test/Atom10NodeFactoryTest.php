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
    }
    
    
    public function dataProvider() {
        return array(
            array(
                '/data/atom10/ubuntuleon.xml',
                'GPS para seres humanos II. Instalando cartografía digital',
                'tag:blogger.com,1999:blog-2720232213758762610.post-661750892382071101',
                'http://www.ubuntuleon.com/2013/03/gps-para-seres-humanos-ii-instalando.html',
                'En el primer artículo de la serie ...',
                '19',
                6,
            ),
            array(
                '/data/atom10/unawebmaslibre.xml',
                'LibreOffice 4 desde PPA',
                'tag:blogger.com,1999:blog-1362653382943359046.post-748547809104154036',
                'http://unawebmaslibre.blogspot.com/2013/03/libreoffice-4-desde-ppa.html',
                'Al fin llegamos a la versión 4 ...',
                '11',
                4,
            ),
        );
    }

    /**
     * @test
     * @dataProvider dataProvider
     * @param type $file
     * @param type $title
     * @param type $guid
     * @param type $link
     * @param type $description
     * @param type $pubDay
     * @param type $categories
     */
    public function testRSS20NodeFactory($file, $title, $guid, $link, $description, $pubDay, $categories) {
        $string = file_get_contents(__DIR__ . $file);
        $dom = new DOMDocument();
        $dom->loadXML($string);
        $item = $dom->getElementsByTagName('entry')->item(0);
        $this->node = $this->factory->create($item);

        $this->assertEquals($title, $this->node->getTitle());
        $this->assertEquals($guid, $this->node->getGuid());
        $this->assertEquals($link, $this->node->getLink());
        $this->assertEquals($description, $this->node->getDescription());
        $this->assertEquals($pubDay, $this->node->getPubDate()->format('d'));
        $this->assertEquals($categories, count($this->node->getCategories()));
    }

}