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

namespace Desarrolla2\RSSClient\Test;

use Desarrolla2\RSSClient\RSSClient;
use Desarrolla2\RSSClient\Handler\HTTP\HTTPHandlerDummy;
use Desarrolla2\RSSClient\Handler\Sanitizer\SanitizerHandlerDummy;

/**
 *
 * Description of RSSClientTest
 *
 * @author : Daniel González Cerviño <daniel.gonzalez@freelancemadrid.es>
 * @file : RSSClientTest.php , UTF-8
 * @date : Mar 19, 2013 , 6:23:26 PM
 */
class RSSClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Desarrolla2\RSSClient\Handler\RSSClient;
     */
    protected $client = null;

    /**
     * Setup
     */
    public function setUp()
    {
        $this->client = new RSSClient();
    }

    /**
     * @test
     */
    public function testSetHTTPHandler()
    {
        $this->client->setHTTPHandler(new HTTPHandlerDummy());
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function testSetSanitizerHandler()
    {
        $this->client->setSanitizerHandler(new SanitizerHandlerDummy());
        $this->assertTrue(true);
    }

}
