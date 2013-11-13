<?php

/**
 * This file is part of the RSSClient project.
 *
 * Copyright (c)
 * Daniel González <daniel.gonzalez@freelancemadrid.es>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\RSSClient\Factory\Test;

use Desarrolla2\RSSClient\Factory\AbstractNodeFactory;
use Desarrolla2\RSSClient\Factory\RSS20NodeFactory;
use Desarrolla2\RSSClient\Handler\Sanitizer\SanitizerHandlerDummy;
use \DOMDocument;

/**
 *
 * Description of RSS20NodeFactoryTest
 *
 * @author : Daniel González <daniel.gonzalez@freelancemadrid.es>
 * @file   : RSS20NodeFactoryTest.php , UTF-8
 * @date   : Mar 24, 2013 , 6:20:28 PM
 */
class RSS20NodeFactoryTest extends AbstractNodeFactoryTest
{

    /**
     * @var string
     */
    protected $itemName = 'item';

    public function setUp()
    {
        parent::setUp();
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
                '/data/rss20/banen.bol.com.xml',
                'Senior Online Marketeer',
                null,
                'https://banen.bol.com/vacature/senior-online-marketeer/' .
                '?utm_source=rss&utm_medium=rss&utm_campaign=senior-online-marketeer',
                'Ben jij de ideale gids in de wereld van Google Adwords?',
                '5',
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
            array(
                '/data/rss20/libuntu.xml',
                'Google lanza la versión 27.0.1453.73 beta del navegador chrome añadiendo varias mejoras en Linux',
                'http://libuntu.wordpress.com/?p=1457',
                'http://libuntu.wordpress.com/2013/05/01/google-lanza-la-version-27-0-1453-73-beta-del-navegador-' .
                'chrome-anadiendo-varias-mejoras-en-linux/',
                'Short description',
                '01',
                14,
            ),
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
                '/data/rss20/slashdot.com.xml',
                'Pentagon Readies Contingency Plans Due To BlackBerry\'s Uncertain Future',
                'http://slashdot.feedsportal.com/c/35028/f/647410/s/33a2d439/l/0Lyro0Bslashdot0Borg0Cstory0C130C110C130C1422510Cpentagon0Ereadies0Econtingency0Eplans0Edue0Eto0Eblackberrys0Euncertain0Efuture0Dutm0Isource0Frss10B0Amainlinkanon0Gutm0Imedium0Ffeed/story01.htm',
                'http://rss.slashdot.org/~r/Slashdot/slashdot/~3/on2_eJ4KHrI/story01.htm',
                'Short description',
                '13',
                0,
            ),
            array(
                '/data/rss20/ubuntuespana.xml',
                'Ubuntu Phone: Premio a la Mejor Innovación del MWC 2013',
                '133 at http://xn--ubuntu-espaa-khb.org',
                'http://xn--ubuntu-espaa-khb.org/content/ubuntu-phone-premio-la-mejor-innovaci%C3%B3n-del-mwc-2013',
                '<p>La <a href="http://www.ubuntu.com/devices/phone">versión para móviles de Ubuntu</a> ' .
                'se ha hecho con ...',
                '28',
                0,
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
        );
    }

    /**
     * @dataProvider dataProvider
     *
     * @param string $file
     * @param string $title
     * @param string $guid
     * @param string $link
     * @param string $description
     * @param string $pubDay
     * @param int    $totalCategories
     */
    public function testNodeFactory($file, $title, $guid, $link, $description, $pubDay, $totalCategories)
    {
        parent::testNodeFactory($file, $title, $guid, $link, $description, $pubDay, $totalCategories);
    }
}
