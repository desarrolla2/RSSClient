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
use Desarrolla2\RSSClient\Parser\ParserInterface;

/**
 *
 * RSSClient Interface
 *
 * @author : Daniel González <daniel.gonzalez@freelancemadrid.es>
 */
interface RSSClientInterface
{
    /**
     * set HTTP Handler
     *
     * @param  \Desarrolla2\RSSClient\Handler\HTTP\HTTPHandlerInterface $handler
     */
    public function setHTTPHandler(HTTPHandlerInterface $handler);

    /**
     * Set Sanitizer
     *
     * @param \Desarrolla2\RSSClient\Handler\Sanitizer\SanitizerHandlerInterface $handler
     */
    public function setSanitizerHandler(SanitizerHandlerInterface $handler);

    /**
     * @param ParserInterface $parser
     */
    public function setParser(ParserInterface $parser);

    /**
     * Retrieve nodes from a chanel
     *
     * @param string $channel
     * @param int    $limit
     * @return NodeCollection
     * @throws \InvalidArgumentException
     */
    public function fetch($channel = 'default', $limit = 100);
}
