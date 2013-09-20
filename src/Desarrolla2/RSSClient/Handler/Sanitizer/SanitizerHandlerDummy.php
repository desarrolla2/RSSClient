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

namespace Desarrolla2\RSSClient\Handler\Sanitizer;

use Desarrolla2\RSSClient\Handler\Sanitizer\SanitizerHandlerInterface;

/**
 *
 * SanitizerHandlerDummy
 *
 * @author : Daniel González Cerviño <daniel.gonzalez@freelancemadrides>
 */
class SanitizerHandlerDummy implements SanitizerHandlerInterface
{
    /**
     * Not Sanitize
     *
     * @param  string $text
     * @return string
     */
    public function doClean($text)
    {
        return (string)$text;
    }
}
