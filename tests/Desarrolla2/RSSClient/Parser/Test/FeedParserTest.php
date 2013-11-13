<?php

/**
 * This file is part of the RSSClient project.
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
 * @author : Daniel González Cerviño <daniel.gonzalez@freelancemadrid.es.es>
 */
class FeedParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FeedParser
     */
    protected $parser;

    /**
     * @var SanitizerHandlerDummy
     */
    protected $sanitizer;

    /**
     * setup
     */
    public function setUp()
    {
        $this->parser = new FeedParser();
        $this->sanitizer = new SanitizerHandlerDummy();
    }

    /**
     *
     * @return array
     */
    public function dataProvider()
    {
        return array(
            /* RSS20 */
            array(
                '/data/rss20/banen.bol.com.xml',
                23
            ),
            array(
                '/data/rss20/jhosmanlirazo.xml',
                15,
            ),
            array(
                '/data/rss20/libuntu.xml',
                10,
            ),
            array(
                '/data/rss20/nyt.xml',
                25,
            ),
            array(
                '/data/rss20/slashdot.com.xml',
                25,
            ),
            array(
                '/data/rss20/ubuntuespana.xml',
                7,
            ),
            array(
                '/data/rss20/ubuntuleon.xml',
                25,
            ),
            /* ATOM10 */
            array(
                '/data/atom10/elblogdediego.xml',
                25,
            ),
            array(
                '/data/atom10/ubuntuleon.xml',
                25,
            ),
            array(
                '/data/atom10/unawebmaslibre.xml',
                25,
            ),
        );
    }

    /**
     * Count that total items is expected
     *
     * @dataProvider dataProvider
     *
     * @param string $file
     * @param int    $totalItems
     */
    public function testCountTotalItems($file, $totalItems)
    {
        $string = file_get_contents(__DIR__ . $file);
        $nodes = $this->parser->parse($string, $this->sanitizer);

        $this->assertEquals($totalItems, $nodes->count());
    }
}
