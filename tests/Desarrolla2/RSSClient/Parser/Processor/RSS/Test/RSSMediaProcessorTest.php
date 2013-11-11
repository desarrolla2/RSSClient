<?php
/**
 * This file is part of the RSSClient project.
 *
 * Copyright (c)
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\RSSClient\Parser\Processor\RSS\Test;

require_once __DIR__ . '/../../../Test/FeedParserTest.php';

use Desarrolla2\RSSClient\Parser\Test\FeedParserTest;
use Desarrolla2\RSSClient\Parser\Processor\RSS\RSSMediaProcessor;

/**
 * Class RSSMediaProcessorTest
 *
 * @author Daniel González <daniel.gonzalez@freelancemadrid.es>
 */

class RSSMediaProcessorTest extends FeedParserTest
{
    /**
     * @var RSSMediaProcessor
     */
    protected $processor;

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();
        $this->processor = new RSSMediaProcessor($this->sanitizer);
        $this->parser->pushProcessor($this->processor);
    }
}