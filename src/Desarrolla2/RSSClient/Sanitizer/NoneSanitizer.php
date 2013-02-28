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

namespace Desarrolla2\RSSClient\Sanitizer;

use Desarrolla2\RSSClient\Sanitizer\SanitizerInterface;

/**
 * 
 * Description of NoneSanitizer
 *
 * @author : Daniel González Cerviño <daniel.gonzalez@freelancemadrides>  
 * @file : NoneSanitizer.php , UTF-8
 * @date : Feb 28, 2013 , 12:27:15 PM
 */
class NoneSanitizer implements SanitizerInterface {

    /**
     * Not Sanitize
     * 
     * @param string $text
     * @return string
     */
    public function doClean($text) {
        return (string) $text;
    }

}
