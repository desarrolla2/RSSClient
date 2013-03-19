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

use Desarrolla2\RSSClient\Handler\HTTP\HTTPHandlerInterface;

/**
 * 
 * Description of HTTPNativeHandler
 *
 * @author : Daniel González Cerviño <daniel.gonzalez@freelancemadrid.es>  
 * @file : HTTPNativeHandler.php , UTF-8
 * @date : Mar 19, 2013 , 4:42:31 PM
 */
class HTTPNativeHandler implements HTTPHandlerInterface {

    /**
     * Retrieve a resource in plain text from a url
     * 
     * @param string $resource
     * @return string
     */
    public function get($resource) {
        return file_get_contents($resource);
    }

}
