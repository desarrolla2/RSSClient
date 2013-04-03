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
class RSS20NodeFactoryTest extends \PHPUnit_Framework_TestCase
{
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
    public function setUp()
    {
        $this->sanitizer = new SanitizerHandlerDummy();
        $this->factory = new RSS20NodeFactory($this->sanitizer);
    }

    /**
     *
     * @return array
     */
    public function dataProvider()
    {
        return array(
            array(
                '/data/rss20/nyt.xml',
                'At Yad Vashem in Israel, Obama Urges Action Against Racism',
                'http://www.nytimes.com/2013/03/23/world/middleeast/president-obama-israel.html',
                'http://www.nytimes.com/2013/03/23/world/middleeast/president-obama-israel.html?partner=rss&emc=rss',
                'Short description',
                '22',
                4,
            ),
            array(
                '/data/rss20/ubuntuleon.xml',
                'GPS para seres humanos II. Instalando cartografía digital',
                'tag:blogger.com,1999:blog-2720232213758762610.post-661750892382071101',
                'http://www.ubuntuleon.com/2013/03/gps-para-seres-humanos-ii-instalando.html',
                'En el primer artículo de la serie ...',
                '19',
                6,
            ),
            array(
                '/data/rss20/ubuntuespana.xml',
                'Ubuntu Phone: Premio a la Mejor Innovación del MWC 2013',
                '133 at http://xn--ubuntu-espaa-khb.org',
                'http://xn--ubuntu-espaa-khb.org/content/ubuntu-phone-premio-la-mejor-innovaci%C3%B3n-del-mwc-2013',
                ' <p>La <a href="http://www.ubuntu.com/devices/phone">versión para móviles de Ubuntu</a> se ha hecho con ...',
                '28',
                0,
            ),
            array(
                '/data/rss20/jhosmanlirazo.xml',
                'Como instalar #LibreOffice4 en #Ubuntu',
                'http://jhosman.com/es/documentacion-ubuntu/oficina6/289-como-instalar-libreoffice-4-en-ubuntu.html',
                'http://jhosman.com/es/documentacion-ubuntu/oficina6/289-como-instalar-libreoffice-4-en-ubuntu.html',
                '<div class="wp-caption aligncenter" style="margin-right: auto;',
                '7',
                0,
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
    public function testRSS20NodeFactory($file, $title, $guid, $link, $description, $pubDay, $categories)
    {
        $sting = file_get_contents(__DIR__ . $file);
        $dom = new DOMDocument();
        $dom->loadXML($sting);
        $item = $dom->getElementsByTagName('item')->item(0);
        $this->node = $this->factory->create($item);

        $this->assertEquals($title, $this->node->getTitle());
        $this->assertEquals($guid, $this->node->getGuid());
        $this->assertEquals($link, $this->node->getLink());
        $this->assertEquals($description, $this->node->getDescription());
        $this->assertEquals($pubDay, $this->node->getPubDate()->format('d'));
        $this->assertEquals($categories, count($this->node->getCategories()));
    }

}
