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

namespace Desarrolla2\RSSClient;


use Desarrolla2\RSSClient\Handler\HTTP\HTTPHandlerInterface;
use Desarrolla2\RSSClient\Handler\Sanitizer\SanitizerHandlerInterface;
/**
 * 
 * Description of RSSClientInterface
 *
 * @author : Daniel González <daniel.gonzalez@freelancemadrid.es> 
 * @file : ClientInterface.php , UTF-8
 * @date : Oct 3, 2012 , 2:07:10 AM
 */
interface RSSClientInterface {

    public function setHTTPHandler(HTTPHandlerInterface $handler);

    public function setSanitizerHandler(SanitizerHandlerInterface $handler);

    public function fetch($channel = 'default');
}
