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

namespace Desarrolla2\RSSClient\Test;

use Desarrolla2\RSSClient\RSSClient;
use Desarrolla2\RSSClient\Sanitizer\Sanitizer;

/**
 * 
 * Description of RSSClientTest
 *
 * @author : Daniel González <daniel.gonzalez@freelancemadrid.es> 
 * @file : RSSClientTest.php , UTF-8
 * @date : Oct 3, 2012 , 10:50:37 AM
 */
class RSSClientFetchTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Desarrolla2\Bundle\RSSClientBundle\Service\RSSClient;
     */
    protected $client = null;

    /**
     * @var string
     */
    protected $example_feed = 'http://desarrolla2.com/feed/';

    /**
     * 
     */
    public function setUp()
    {
        $this->client = new RSSClient(new Sanitizer());
        $this->client->addFeed($this->example_feed);
        $this->client->fetch();
    }

    /**
     * @test
     */
    public function testCount()
    {
        $this->assertEquals( $this->client->countNodes(), 20);
    }

}
