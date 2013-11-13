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

use Desarrolla2\RSSClient\Factory\Atom10NodeFactory;
use Desarrolla2\RSSClient\Handler\Sanitizer\SanitizerHandlerDummy;

/**
 *
 * Atom10NodeFactoryTest
 *
 * @author : Daniel González <daniel.gonzalez@freelancemadrid.es>
 */
class Atom10NodeFactoryTest extends AbstractNodeFactoryTest
{

    /**
     * @var string
     */
    protected $itemName = 'entry';

    public function setUp()
    {
        parent::setUp();
        $this->sanitizer = new SanitizerHandlerDummy();
        $this->factory = new Atom10NodeFactory($this->sanitizer);
    }

    /**
     * @return array
     */
    public function dataProvider()
    {
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
            array(
                '/data/atom10/elblogdediego.xml',
                'Ubuntu tendrá su propio servidor gráfico y Unity volverá a Qt [Actualizada]',
                'tag:blogger.com,1999:blog-432243268593805349.post-1743194106039184020',
                'http://diegohacking.blogspot.com/2013/03/ubuntu-tendra-su-propio-servidor.html',
                '<div dir="ltr" style="text-align: left;" trbidi="on"><span style="font-size: large;">Con más ' .
                'retraso del ...',
                '8',
                3,
            ),
        );
    }

    /**
     * @dataProvider dataProvider
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
