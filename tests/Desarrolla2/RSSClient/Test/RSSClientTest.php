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

namespace Desarrolla2\RSSClient\Test;

use Desarrolla2\RSSClient\Node\NodeCollection;
use Desarrolla2\RSSClient\Node\RSS20 as Node;
use Desarrolla2\RSSClient\RSSClient;
use Desarrolla2\RSSClient\Handler\HTTP\HTTPHandlerNative;
use Desarrolla2\RSSClient\Handler\Sanitizer\SanitizerHandlerDummy;

/**
 *
 * Description of RSSClientTest
 *
 * @author : Daniel González Cerviño <daniel.gonzalez@freelancemadrid.es>
 */
class RSSClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Desarrolla2\RSSClient\RSSClient
     */
    protected $client = null;

    public function setUp()
    {
        $this->client = new RSSClient();
    }

    public function testSetAndGetHTTPHandler()
    {
        $this->client->setHTTPHandler(new HTTPHandlerNative());
        $this->assertInstanceOf(
            'Desarrolla2\RSSClient\Handler\HTTP\HTTPHandlerNative',
            $this->client->getHttpHandler()
        );
    }

    public function testSetAndGetSanitizer()
    {
        $this->client->setSanitizer(new SanitizerHandlerDummy());
        $this->assertInstanceOf(
            'Desarrolla2\RSSClient\Handler\Sanitizer\SanitizerHandlerDummy',
            $this->client->getSanitizer()
        );
    }

    public function testGetHttp()
    {
        $httpHandler = $this->getHTTPHandlerMock();
        $httpHandler->expects($this->once())
            ->method('get')
            ->will($this->returnValue(''));

        $this->client->setFeed('http://desarrolla2.com/rss');
        $this->client->setHTTPHandler($httpHandler);
        $this->client->fetch();
    }

    /**
     * @return array
     */
    public function dataProviderForTestLimit()
    {
        return array(
            array(5),
            array(15),
        );
    }

    /**
     * @dataProvider dataProviderForTestLimit
     */
    public function testLimit($limit)
    {
        $httpHandler = $this->getHTTPHandlerMock();
        $httpHandler->expects($this->once())
            ->method('get')
            ->will($this->returnValue(true));

        $feedParser = $this->getFeedParserMock();
        $feedParser->expects($this->once())
            ->method('parse')
            ->will($this->returnValue($this->createNodeCollection()));

        $this->client->setFeed('http://desarrolla2.com/rss');
        $this->client->setHTTPHandler($httpHandler);
        $this->client->setParser($feedParser);

        $result = $this->client->fetch('default', $limit);


        $this->assertEquals($limit, $result->count());
    }

    /**
     * @return NodeCollection
     */
    private function createNodeCollection()
    {
        $collection = new NodeCollection();
        for ($i = 1; $i <= 20; $i++) {
            $node = new Node();
            $node->setPubDate(new \DateTime());
            $collection->append($node);
        }

        return $collection;
    }

    private function getHTTPHandlerMock()
    {
        return $this->getMock('\Desarrolla2\RSSClient\Handler\HTTP\HTTPHandlerNative');
    }

    /**
     * @return \Desarrolla2\RSSClient\Handler\HTTP\HTTPHandlerNative
     */
    private function getFeedParserMock()
    {
        return $this->getMock('\Desarrolla2\RSSClient\Parser\ParserInterface');
    }
}
