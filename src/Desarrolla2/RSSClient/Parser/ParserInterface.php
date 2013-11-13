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

namespace Desarrolla2\RSSClient\Parser;

use Desarrolla2\RSSClient\Handler\Sanitizer\SanitizerHandlerInterface;

/**
 *
 * Description of ParserInterface
 *
 * @author : Daniel González Cerviño <daniel.gonzalez@freelancemadrid.es>
 */
interface ParserInterface
{
    /**
     * @param                           $feed
     */
    public function parse($feed);
}
