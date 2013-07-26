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

use \Desarrolla2\RSSClient\Handler\HTTP\HTTPHandlerInterface;

/**
 *
 * Description of HTTPHandlerDummy
 *
 * @author : Daniel González Cerviño <daniel.gonzalez@freelancemadrid.es>
 */
class HTTPHandlerDummy implements HTTPHandlerInterface
{
    public function get($resource)
    {
        return file_get_contents($resource);
    }
}
