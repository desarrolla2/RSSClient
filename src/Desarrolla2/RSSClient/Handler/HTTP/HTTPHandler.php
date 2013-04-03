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

namespace Desarrolla2\RSSClient\Handler\HTTP;

use \Guzzle\Http\Client;
use \Guzzle\Http\ClientInterface;
use \Desarrolla2\RSSClient\Handler\HTTP\HTTPHandlerInterface;
use Desarrolla2\RSSClient\Exception\RuntimeException;

/**
 *
 * Description of HTTPHandler
 *
 * @author : Daniel González Cerviño <daniel.gonzalez@freelancemadrid.es>
 * @file : HTTPHandler.php , UTF-8
 * @date : Mar 15, 2013 , 2:33:53 PM
 */
class HTTPHandler implements HTTPHandlerInterface
{
    /**
     * @var \Guzzle\Http\Client
     */
    protected $client;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     *
     * @param \Guzzle\Service\ClientInterface $client
     */
    public function setClient(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Retrieve a resource in plain text from a url
     *
     * @param  string $resource
     * @return string
     */
    public function get($resource)
    {
        $request = $this->client->get($resource);
        $response = $request->send();
        if ($response->getStatusCode() == 200) {
            return $response->getBody();
        }
        throw new RuntimeException('Error on HTTP request');
    }

}
