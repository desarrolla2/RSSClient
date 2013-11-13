<?php
/**
 * This file is part of the RSSClient project.
 *
 * Copyright (c)
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\RSSClient\Parser\Processor\Test;

use Desarrolla2\RSSClient\Handler\Sanitizer\SanitizerHandlerDummy;
use Desarrolla2\RSSClient\Parser\Processor\ProcessorDummy;
use Desarrolla2\RSSClient\Parser\ParserInterface;
use Desarrolla2\RSSClient\Parser\FeedParser;

/**
 * Class RSSMediaProcessorTest
 *
 * @author Daniel González <daniel.gonzalez@freelancemadrid.es>
 */

class ProcessorDummyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RSSMediaProcessor
     */
    protected $processor;

    /**
     * @var ParserInterface
     */
    protected $parser;

    public function setUp()
    {
        $this->processor = new ProcessorDummy(
            new SanitizerHandlerDummy()
        );

        $this->parser = new FeedParser();
    }

    public function testPushProcessor()
    {
        $this->parser->pushProcessor($this->processor);
        $this->assertInstanceOf(
            'Desarrolla2\RSSClient\Parser\Processor\ProcessorDummy',
            $this->parser->popProcessor()
        );
    }
}