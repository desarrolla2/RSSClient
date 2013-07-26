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

namespace Desarrolla2\RSSClient\Handler\Test;

use Desarrolla2\RSSClient\RSSClient;

/**
 *
 * FeedHandlerTest
 *
 * @author : Daniel González <daniel.gonzalez@freelancemadrid.es>
 */
class FeedHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Desarrolla2\RSSClient\RSSClient;
     */
    protected $client = null;

    /**
     * @var string
     */
    protected $example_feed = 'http://desarrolla2.com/feed/';

    /**
     * @var string
     */
    protected $example_feed2 = 'http://blog.desarrolla2.com/feed/';

    public function setUp()
    {
        $this->client = new RSSClient();
    }

    /**
     * @return array
     */
    public function getDataForFeeds()
    {
        return array(
            array(
                array(
                    $this->example_feed,
                ),
            ),
            array(
                array(
                    $this->example_feed,
                    $this->example_feed,
                ),
            ),
            array(
                array(
                    $this->example_feed,
                    $this->example_feed,
                    $this->example_feed,
                ),
            ),
            array(
                array(
                    $this->example_feed,
                    $this->example_feed,
                    $this->example_feed,
                    $this->example_feed,
                    $this->example_feed,
                    $this->example_feed,
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
                        $this->example_feed,
                    ),
                ),
            ),
            array(
                array(
                    'channel1' => array(
                        $this->example_feed,
                        $this->example_feed,
                    ),
                ),
                array(
                    'channel1' => array(
                        $this->example_feed,
                    ),
                    'channel2' => array(
                        $this->example_feed,
                        $this->example_feed,
                    ),
                ),
            ),
            array(
                array(
                    'channel1' => array(
                        $this->example_feed,
                    ),
                    'channel2' => array(
                        $this->example_feed,
                        $this->example_feed,
                    ),
                    'channel3' => array(
                        $this->example_feed,
                        $this->example_feed,
                        $this->example_feed,
                        $this->example_feed,
                        $this->example_feed,
                        $this->example_feed,
                        $this->example_feed,
                        $this->example_feed,
                    ),
                ),
            ),
        );
    }

    /**
     * @dataProvider getDataForFeeds
     */
    public function testAddFeed($data)
    {
        $this->client->addFeed($this->example_feed);
        foreach ($data as $feed) {
            $this->client->addFeed($feed);
        }
        $this->assertEquals(count($this->client->getFeeds()), 1);
    }

    /**
     * @dataProvider getDataForFeeds
     */
    public function testAddFeeds($data)
    {
        $this->client->addFeed($this->example_feed2);
        $this->client->addFeeds($data);
        $this->client->addFeeds($data);
        $this->assertEquals(count($this->client->getFeeds()), 2);
    }

    /**
     * @dataProvider getDataForFeeds
     */
    public function testSetFeed($data)
    {
        $this->client->addFeed($this->example_feed2);
        foreach ($data as $feed) {
            $this->client->setFeed($feed);
        }
        $this->assertEquals(count($this->client->getFeeds()), 1);
    }

    /**
     * @dataProvider getDataForFeeds
     */
    public function countFeeds($data)
    {
        $this->client->addFeed($this->example_feed2);
        $this->client->addFeeds($data);
        $this->assertEquals($this->client->countFeeds(), 2);
    }

    /**
     * @dataProvider getDataForChannels
     */
    public function testCountChannels($data)
    {
        $this->client->setChannels($data);
        $this->assertEquals(count($data), $this->client->countChannels());
    }

    /**
     * @dataProvider getDataForChannels
     */
    public function testGetChannels($data)
    {
        $this->client->setChannels($data);
        $this->assertEquals(count($data), count($this->client->getChannels()));
    }

    /**
     * @dataProvider getDataForChannels
     */
    public function testGetChannelsNames($data)
    {
        $this->client->setChannels($data);
        $this->assertEquals(array_keys($data), $this->client->getChannelsNames());
    }

    /**
     * @dataProvider getDataForChannels
     */
    public function testAddChannels($data)
    {
        $this->client->addChannels(
            array(
                'test1' => array(
                    $this->example_feed,
                ),
            )
        );
        $this->client->addChannels($data);
        $this->assertEquals((count($data) + 1), $this->client->countChannels());
    }

    /**
     * @dataProvider getDataForChannels
     */
    public function testClearChannels($data)
    {
        $this->client->setChannels($data);
        $this->client->setChannels($data);
        $this->assertEquals(count($data), $this->client->countChannels());
    }
}
