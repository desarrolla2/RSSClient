<?php

/**
 * 
 * Description of RSSClientExceptionsTest
 * 
 * This file is part of the RSSClient proyect.
 *
 * @author : Daniel González Cerviño <daniel.gonzalez@freelancemadrid.es> 
 * @file : RSSClientExceptionsTest.php , UTF-8
 * @date : Dec 12, 2012 , 7:00:15 PM
 */

namespace Desarrolla2\RSSClient\Test\RSSClient;

use Desarrolla2\RSSClient\RSSClient;
use Desarrolla2\RSSClient\Sanitizer\Sanitizer;

class ExceptionsTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Desarrolla2\RSSClien\RSSClient;
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
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testAddChannelsException()
    {
        $this->client->addChannels('channels');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testAddFeedExceptionA()
    {
        $this->client->addFeed(array(), array());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testAddFeedExceptionB()
    {
        $this->client->addFeed('string', array());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testAddFeedExceptionC()
    {
        $this->client->addFeed('string');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testAddFeedsA()
    {
        $this->client->addFeeds('string');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testAddFeedsB()
    {
        $this->client->addFeeds(array(), array());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testFetchA()
    {
        $this->client->fetch(array());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testFetchB()
    {
        $this->client->fetch('string');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testFetchC()
    {
        $this->client->setFeed($this->example_feed, 'string');
        $this->client->fetch('string', 0);
    }

}