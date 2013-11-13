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

namespace Desarrolla2\RSSClient\Handler\HTTP\Test;

use \Desarrolla2\RSSClient\Handler\HTTP\HTTPHandler;
use \Guzzle\Http\Message\Response;
use \Guzzle\Http\Message\Request;

/**
 *
 * Description of HTTPHandlerTest
 *
 * @author : Daniel González Cerviño <daniel.gonzalez@freelancemadrid.es>
 */
class HTTPHandlerTest extends \PHPUnit_Framework_TestCase
{
    const HTTP_BODY_EXAMPLE = '<html><body><h1>my body</h1></body></html>';

    /**
     *
     * @var \Desarrolla2\RSSClient\Handler\HTTP\HTTPHandler
     */
    protected $client = null;

    /**
     * Setup
     */
    public function setUp()
    {
        $this->client = new HTTPHandler();
    }

    /**
     * @test
     */
    public function testGetHttp200()
    {
        $response = new Response(200, null, self::HTTP_BODY_EXAMPLE);

        $httpRequestMock = $this->getMock(
            '\Guzzle\Http\Message\Request',
            array(),
            array(),
            '',
            false
        );
        $httpRequestMock->expects($this->any())
            ->method('send')
            ->will($this->returnValue($response));

        $httpClientMock = $this->getMock('\Guzzle\Http\Client');
        $httpClientMock->expects($this->any())
            ->method('get')
            ->will($this->returnValue($httpRequestMock));

        $this->client->setClient($httpClientMock);

        $this->assertEquals($this->client->get('http://example.org'), self::HTTP_BODY_EXAMPLE);
    }

    /**
     * @test
     * @expectedException \Desarrolla2\RSSClient\Exception\RuntimeException
     */
    public function testGetHttp500()
    {
        $response = new Response(500, null, self::HTTP_BODY_EXAMPLE);

        $httpRequestMock = $this->getMock(
            '\Guzzle\Http\Message\Request',
            array(),
            array(),
            '',
            false
        );
        $httpRequestMock->expects($this->any())
            ->method('send')
            ->will($this->returnValue($response));

        $httpClientMock = $this->getMock('\Guzzle\Http\Client');
        $httpClientMock->expects($this->any())
            ->method('get')
            ->will($this->returnValue($httpRequestMock));

        $this->client->setClient($httpClientMock);
        $this->client->get('http://example.org');
    }
}
