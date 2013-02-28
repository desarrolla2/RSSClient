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

namespace Desarrolla2\RSSClient\Sanitizer;

use Desarrolla2\RSSClient\Sanitizer\SanitizerInterface;

/**
 * 
 * Description of Sanitizer
 *
 * @author : Daniel González <daniel.gonzalez@freelancemadrid.es> 
 * @file : Sanitizer.php , UTF-8
 * @date : Oct 3, 2012 , 11:14:19 AM
 */
class Sanitizer implements SanitizerInterface
{

    /**
     * @var HTMLPurifier
     */
    protected $purifier;

    /**
     * 
     * @param type $cacheDirectory
     */
    public function __construct($cacheDirectory = '/tmp')
    {
        // require to configure some CONSTANST
        new \HTMLPurifier_Bootstrap();
        $config = \HTMLPurifier_Config::createDefault();

        // require that it is writable
        $config->set('Cache.SerializerPath', $cacheDirectory);
        $this->purifier = new \HTMLPurifier($config);
    }

    /**
     * Sanitize html text
     * 
     * @param string $text
     * @return string
     */
    public function doClean($text)
    {
        return $this->purifier->purify($text);
    }

}
