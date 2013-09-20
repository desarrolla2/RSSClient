<?php

/**
 * This file is part of the RSSClient project.
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
 */
interface SanitizerHandlerInterface
{
    /**
     *
     * @param  string $text
     * @return string
     */
    public function doClean($text);
}
