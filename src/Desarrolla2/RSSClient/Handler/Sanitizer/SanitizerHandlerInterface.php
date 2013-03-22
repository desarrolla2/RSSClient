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

namespace Desarrolla2\RSSClient\Handler\Sanitizer;

/**
 * 
 * Description of SanitizerInterface
 *
 * @author : Daniel González <daniel.gonzalez@freelancemadrid.es> 
 * @file : SanitizerInterface.php , UTF-8
 * @date : Oct 3, 2012 , 11:25:08 AM
 */
interface SanitizerHandlerInterface 
{
    /**
     * 
     * @param type $text
     * @return type
     */
    public function doClean($text);
}
