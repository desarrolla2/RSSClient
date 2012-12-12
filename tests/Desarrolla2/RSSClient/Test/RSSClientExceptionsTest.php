<?php

/**
 * 
 * Description of RSSClientExceptionsTest
 * 
 * This file is part of the RSSClient proyect.
 *
 * @author : Daniel González Cerviño <daniel.gonzalez@externos.seap.minhap.es> 
 * @file : RSSClientExceptionsTest.php , UTF-8
 * @date : Dec 12, 2012 , 7:00:15 PM
 */

namespace Desarrolla2\RSSClient\Test;

use Desarrolla2\RSSClient\RSSClient;
use Desarrolla2\RSSClient\Sanitizer\Sanitizer;

class RSSClientExceptionsTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Desarrolla2\Bundle\RSSClientBundle\Service\RSSClient;
     */
    protected $client = null;

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

}