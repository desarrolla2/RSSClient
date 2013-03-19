<?php

/**
 * This file is part of the RSSClient proyect.
 * 
 * Copyright (c)
 * Daniel González Cerviño <daniel.gonzalez@externos.seap.minhap.es>  
 * 
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\RSSClient\Handler\Test;

use \Desarrolla2\RSSClient\Handler\FeedHandler;

/**
 * 
 * Description of FeedHandlerTestExceptions
 *
 * @author : Daniel González Cerviño <daniel.gonzalez@externos.seap.minhap.es>  
 * @file : FeedHandlerTestExceptions.php , UTF-8
 * @date : Mar 19, 2013 , 4:28:13 PM
 */
class FeedHandlerTestExceptions extends \PHPUnit_Framework_TestCase {

    /**
     * @var \Desarrolla2\RSSClient\Handler\FeedHandler;
     */
    protected $handler = null;

    /**
     * @var string
     */
    protected $example_feed1 = 'http://desarrolla2.com/feed/';

    /**
     * @var string
     */
    protected $example_feed2 = 'http://blog.desarrolla2.com/feed/';

    /**
     * 
     */
    public function setUp() {
        $this->handler = new FeedHandler();
    }

    /**
     * @test
     * @expectedException \Desarrolla2\RSSClient\Exception\InvalidArgumentException    
     */
    public function testAddChannels() {
        $this->handler->addChannels('string');
    }

    /**
     * @test
     * @expectedException \Desarrolla2\RSSClient\Exception\InvalidArgumentException    
     */
    public function testAddFeed1() {
        $this->handler->addFeed(array());
    }

    /**
     * @test
     * @expectedException \Desarrolla2\RSSClient\Exception\InvalidArgumentException    
     */
    public function testAddFeed2() {
        $this->handler->addFeed($this->example_feed1, array());
    }

    /**
     * @test
     * @expectedException \Desarrolla2\RSSClient\Exception\InvalidArgumentException    
     */
    public function testAddFeed3() {
        $this->handler->addFeed('not valid url');
    }

    /**
     * @test
     * @expectedException \Desarrolla2\RSSClient\Exception\InvalidArgumentException    
     */
    public function testAddFeeds1() {
        $this->handler->addFeeds('string');
    }

    /**
     * @test
     * @expectedException \Desarrolla2\RSSClient\Exception\InvalidArgumentException    
     */
    public function testAddFeeds2() {
        $this->handler->addFeeds(array(), array());
    }

    /**
     * @test
     * @expectedException \Desarrolla2\RSSClient\Exception\InvalidArgumentException    
     */
    public function testSetFeeds() {
        $this->handler->setFeeds('string');
    }

}
