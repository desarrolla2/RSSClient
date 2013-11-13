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

namespace Desarrolla2\RSSClient\Handler\Feed\Test;

use \Desarrolla2\RSSClient\Handler\Feed\FeedHandler;

/**
 *
 * Description of FeedHandlerTestExceptions
 *
 * @author : Daniel González Cerviño <daniel.gonzalez@freelancemadrid.es>
 */
class FeedHandlerTestExceptionsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Desarrolla2\RSSClient\Handler\Feed\FeedHandler
     */
    protected $handler = null;

    /**
     * @var string
     */
    protected $exampleFeed1 = 'http://desarrolla2.com/feed/';

    /**
     * @var string
     */
    protected $exampleFeed2 = 'http://blog.desarrolla2.com/feed/';

    public function setUp()
    {
        $this->handler = new FeedHandler();
    }

    /**
     * @expectedException \Desarrolla2\RSSClient\Exception\InvalidArgumentException
     */
    public function testAddChannels()
    {
        $this->handler->addChannels('string');
    }

    /**
     * @expectedException \Desarrolla2\RSSClient\Exception\InvalidArgumentException
     */
    public function testAddFeed1()
    {
        $this->handler->addFeed(array());
    }

    /**
     * @expectedException \Desarrolla2\RSSClient\Exception\InvalidArgumentException
     */
    public function testAddFeed2()
    {
        $this->handler->addFeed($this->exampleFeed1, array());
    }

    /**
     * @expectedException \Desarrolla2\RSSClient\Exception\InvalidArgumentException
     */
    public function testAddFeed3()
    {
        $this->handler->addFeed('not valid url');
    }

    /**
     * @expectedException \Desarrolla2\RSSClient\Exception\InvalidArgumentException
     */
    public function testAddFeeds1()
    {
        $this->handler->addFeeds('string');
    }

    /**
     * @expectedException \Desarrolla2\RSSClient\Exception\InvalidArgumentException
     */
    public function testAddFeeds2()
    {
        $this->handler->addFeeds(array(), array());
    }

    /**
     * @expectedException \Desarrolla2\RSSClient\Exception\InvalidArgumentException
     */
    public function testSetFeeds()
    {
        $this->handler->setFeeds('string');
    }
}
