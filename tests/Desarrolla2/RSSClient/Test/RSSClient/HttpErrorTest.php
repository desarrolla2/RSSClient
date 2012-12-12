<?php

/**
 * 
 * Description of HttpErrorTest
 * 
 * This file is part of the RSSClient proyect.
 *
 * @author : Daniel González Cerviño <daniel.gonzalez@externos.seap.minhap.es> 
 * @file : HttpErrorTest.php , UTF-8
 * @date : Dec 12, 2012 , 7:12:07 PM
 */

namespace Desarrolla2\RSSClient\Test\RSSClient;

use Desarrolla2\RSSClient\RSSClient;
use Desarrolla2\RSSClient\Sanitizer\Sanitizer;

class HttpErrorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Desarrolla2\Bundle\RSSClientBundle\Service\RSSClient;
     */
    protected $client = null;

    /**
     * 
     */
    public function setUp()
    {
        $this->client = new RSSClient(new Sanitizer());
    }

}