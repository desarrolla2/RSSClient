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

namespace Desarrolla2\RSSClient\HTTPClient;

use Guzzle\Http\Client;
use Desarrolla2\RSSClient\HTTPClient\HTTPClientInterface;

/**
 * 
 * Description of HTTPClient
 *
 * @author : Daniel González <daniel.gonzalez@freelancemadrid.es> 
 * @file : HTTPClient.php , UTF-8
 * @date : Dec 12, 2012 , 9:09:23 PM
 */
class HTTPClient implements HTTPClientInterface
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
     * Retrieve a resource in plain text from a url
     * 
     * @param string $resource
     * @return string
     */
    public function get($resource)
    {
        $request = $this->client->get($feedUrl);
        $response = $request->send();
        return $response->getBody();
    }

}
