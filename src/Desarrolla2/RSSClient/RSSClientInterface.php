<?php

/**
 * This file is part of the RSSClient package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desarrolla2\RSSClient;

use Desarrolla2\RSSClient\Handler\HTTP\HTTPHandlerInterface;
use Desarrolla2\RSSClient\Handler\Sanitizer\SanitizerHandlerInterface;
use Desarrolla2\RSSClient\Parser\ParserInterface;

/**
 *
 * RSSClient Interface
 *
 */
interface RSSClientInterface
{
    /**
     * set HTTP Handler
     *
     * @param HTTPHandlerInterface $handler
     */
    public function setHTTPHandler(HTTPHandlerInterface $handler);

    /**
     * Set Sanitizer
     *
     * @param SanitizerHandlerInterface $handler
     */
    public function setSanitizer(SanitizerHandlerInterface $handler);

    /**
     * @param ParserInterface $parser
     */
    public function setParser(ParserInterface $parser);

    /**
     * Retrieve nodes from a channel
     *
     * @param  string $channel
     * @param  int    $limit
     *
     * @return NodeCollection
     * @throws \InvalidArgumentException
     */
    public function fetch($channel = 'default', $limit = 100);
}
