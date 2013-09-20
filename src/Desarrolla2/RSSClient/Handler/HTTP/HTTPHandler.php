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
 */
class HTTPHandler implements HTTPHandlerInterface
{

    const VERSION = '2.1.0';
    const USER_AGENT = 'Desarrolla2/RSSClient';

    /**
     * @var \Guzzle\Http\Client
     */
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @param ClientInterface $client
     */
    public function setClient(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Retrieve a resource in plain text from a url
     *
     * @param string $resource
     * @param array  $headers
     * @return string
     * @throws RuntimeException
     */
    public function get($resource, $headers = null)
    {
        $vendorHeaders = array(
            'User-Agent' => self::USER_AGENT . self::VERSION,
        );
        if (is_array($headers)) {
            $vendorHeaders = array_merge($headers, $vendorHeaders);
        }
        $request = $this->client->get($resource, $vendorHeaders);
        $response = $request->send();
        $status = $response->getStatusCode();
        if ($status != 200) {
            throw new RuntimeException('Error HTTP ' . $status . '  on request');
        }

        return $response->getBody();
    }
}
