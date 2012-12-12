<?php

/**
 * This file is part of the RSSClient proyect.
 * 
 * Copyright (c)
 * Daniel González Cerviño <daniel.gonzalez@ideup.com> 
 * 
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\RSSClient\Test;

require_once __DIR__ .'/RSSClientTest.php';

use Desarrolla2\RSSClient\RSSCacheClient;
use Desarrolla2\RSSClient\Sanitizer\Sanitizer;
use Desarrolla2\Cache\Cache;
use Desarrolla2\Cache\Adapter\NotCache;
use Desarrolla2\RSSClient\Test\RSSClientTest;


/**
 * 
 * Description of RSSCacheClientTest
 *
 * @author : Daniel González Cerviño <daniel.gonzalez@ideup.com> 
 * @file : RSSCacheClientTest.php , UTF-8
 * @date : Oct 4, 2012 , 12:22:23 PM
 */
class RSSCacheClientTest extends RSSClientTest
{

    /**
     *  Setup
     */
    public function setUp()
    {
        $this->client = new RSSCacheClient(new Cache(new NotCache));
    }

}
