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

/**
 * 
 * Description of HTTPClientInterface
 *
 * @author : Daniel González <daniel.gonzalez@freelancemadrid.es> 
 * @file : HTTPClientInterface.php , UTF-8
 * @date : Dec 12, 2012 , 9:06:59 PM
 */
interface HTTPClientInterface
{

    /**
     * Retrieve a resource in plain text from a url
     * 
     * @param string $resource
     * @return string
     */
    public function get($resource);
}
