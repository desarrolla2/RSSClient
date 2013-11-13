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
 * Description of FeedHandlerTest
 *
 * @author : Daniel González Cerviño <daniel.gonzalez@freelancemadrid.es>
 */
class FeedHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Desarrolla2\RSSClient\Handler\Feed\FeedHandler;
     */
    protected $handler = null;

    /**
     * @var string
     */
    protected $exampleFeed1 = 'http://example.com/feed/';

    /**
     * @var string
     */
    protected $exampleFeed2 = 'http://example2.com/feed/';

    public function setUp()
    {
        $this->handler = new FeedHandler();
    }

    /**
     *
     * @return array
     */
    public function getDataForFeeds()
    {
        return array(
            array(
                array(
                    $this->exampleFeed1,
                ),
            ),
            array(
                array(
                    $this->exampleFeed1,
                    $this->exampleFeed1,
                ),
            ),
            array(
                array(
                    $this->exampleFeed1,
                    $this->exampleFeed1,
                    $this->exampleFeed1,
                ),
            ),
            array(
                array(
                    $this->exampleFeed1,
                    $this->exampleFeed1,
                    $this->exampleFeed1,
                    $this->exampleFeed1,
                    $this->exampleFeed1,
                    $this->exampleFeed1,
                ),
            ),
        );
    }

    /**
     * @return array
     */
    public function getDataForChannels()
    {
        return array(
            array(
                array(
                    'channel1' => array(
                        $this->exampleFeed1,
                    ),
                ),
            ),
            array(
                array(
                    'channel1' => array(
                        $this->exampleFeed1,
                        $this->exampleFeed1,
                    ),
                ),
                array(
                    'channel1' => array(
                        $this->exampleFeed1,
                    ),
                    'channel2' => array(
                        $this->exampleFeed1,
                        $this->exampleFeed1,
                    ),
                ),
            ),
            array(
                array(
                    'channel1' => array(
                        $this->exampleFeed1,
                    ),
                    'channel2' => array(
                        $this->exampleFeed1,
                        $this->exampleFeed1,
                    ),
                    'channel3' => array(
                        $this->exampleFeed1,
                        $this->exampleFeed1,
                        $this->exampleFeed1,
                        $this->exampleFeed1,
                        $this->exampleFeed1,
                        $this->exampleFeed1,
                        $this->exampleFeed1,
                        $this->exampleFeed1,
                    ),
                ),
            ),
        );
    }

    /**
     * @dataProvider getDataForFeeds
     */
    public function testAddFeed1($data)
    {
        $this->handler->addFeed($this->exampleFeed1);
        foreach ($data as $feed) {
            $this->handler->addFeed($feed);
        }
        $this->assertEquals(count($this->handler->getFeeds()), 1);
    }

    /**
     * @dataProvider getDataForFeeds
     */
    public function testAddFeed2($data)
    {
        $this->handler->addFeed($this->exampleFeed1, 'new_channel');
        foreach ($data as $feed) {
            $this->handler->addFeed($feed);
        }
        $this->assertEquals(count($this->handler->getFeeds()), 1);
    }

    /**
     * @dataProvider getDataForFeeds
     */
    public function testAddFeeds($data)
    {
        $this->handler->addFeed($this->exampleFeed2);
        $this->handler->addFeeds($data);
        $this->handler->addFeeds($data);
        $this->assertEquals(count($this->handler->getFeeds()), 2);
    }

    /**
     * @dataProvider getDataForFeeds
     */
    public function testSetFeeds($data)
    {
        $this->handler->addFeed($this->exampleFeed2);
        $this->handler->setFeeds($data);
        $this->assertEquals(count($this->handler->getFeeds()), 1);
    }

    /**
     * @dataProvider getDataForFeeds
     */
    public function testSetFeed($data)
    {
        $this->handler->addFeed($this->exampleFeed2);
        foreach ($data as $feed) {
            $this->handler->setFeed($feed);
        }
        $this->assertEquals(count($this->handler->getFeeds()), 1);
    }

    /**
     * @dataProvider getDataForFeeds
     */
    public function countFeeds($data)
    {
        $this->handler->addFeed($this->exampleFeed2);
        $this->handler->addFeeds($data);
        $this->assertEquals($this->handler->countFeeds(), 2);
    }

    /**
     * @dataProvider getDataForChannels
     */
    public function testCountChannels($data)
    {
        $this->handler->setChannels($data);
        $this->assertEquals(count($data), $this->handler->countChannels());
    }

    /**
     * @dataProvider getDataForChannels
     */
    public function testGetChannels($data)
    {
        $this->handler->setChannels($data);
        $this->assertEquals(count($data), count($this->handler->getChannels()));
    }

    /**
     * @dataProvider getDataForChannels
     */
    public function testGetChannelsNames($data)
    {
        $this->handler->setChannels($data);
        $this->assertEquals(array_keys($data), $this->handler->getChannelsNames());
    }

    /**
     * @dataProvider getDataForChannels
     */
    public function testAddChannels($data)
    {
        $this->handler->addChannels(
            array(
                'test1' => array(
                    $this->exampleFeed1,
                ),
            )
        );
        $this->handler->addChannels($data);
        $this->assertEquals((count($data) + 1), $this->handler->countChannels());
    }

    /**
     * @dataProvider getDataForChannels
     */
    public function testClearChannels($data)
    {
        $this->handler->setChannels($data);
        $this->handler->setChannels($data);
        $this->assertEquals(count($data), $this->handler->countChannels());
    }
}
