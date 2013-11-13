<?php

/**
 * This file is part of the RSSClient project.
 *
 * Copyright (c)
 * Daniel González Cerviño <daniel.gonzalez@freelancemadrid.es>
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
 * @author : Daniel González Cerviño <daniel.gonzalez@freelancemadrid.es>
 */
class FeedParserExceptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FeedParser
     */
    protected $parser;

    /**
     * @var SanitizerHandlerDummy
     */
    protected $sanitizer;

    public function setUp()
    {
        $this->parser    = new FeedParser();
        $this->sanitizer = new SanitizerHandlerDummy();
    }

    /**
     * @expectedException \Desarrolla2\RSSClient\Exception\RuntimeException
     */
    public function testParseStringTest()
    {
        $this->parser->parse('my string', $this->sanitizer);
    }
}
