<?php

/**
 * This file is part of the RSSClient proyect.
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
 * @file : FeedParserTest.php , UTF-8
 * @date : Mar 22, 2013 , 12:47:12 PM
 */
class FeedParserExceptionTest extends \PHPUnit_Framework_TestCase {

    /**
     *
     * @var \Desarrolla2\RSSClient\Parser\FeedParser
     */
    protected $parser;

    /**
     * Setup
     */
    public function setUp() {
        $this->parser = new FeedParser();
        $this->sanitizer = new SanitizerHandlerDummy();
    }

    /**
     * @test
     * @expectedException \Desarrolla2\RSSClient\Exception\RuntimeException
     */
    public function parseStringTest() {
        $this->parser->parse('my string', $this->sanitizer);
    }

}
