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

use Desarrolla2\RSSClient\Handler\Sanitizer\SanitizerHandlerInterface;
use Desarrolla2\RSSClient\Exception\InvalidArgumentException;

/**
 *
 * SanitizerHandler
 *
 * @author : Daniel González <daniel.gonzalez@freelancemadrid.es>
 */
class SanitizerHandler implements SanitizerHandlerInterface
{
    /**
     * @var HTMLPurifier
     */
    protected $purifier;


    /**
     * @param string $cacheDirectory
     * @throws \Desarrolla2\RSSClient\Exception\InvalidArgumentException
     */
    public function __construct($cacheDirectory = null)
    {
        if (!$cacheDirectory) {
            $cacheDirectory = realpath(sys_get_temp_dir());
        }

        if (!is_writable($cacheDirectory)) {
            throw new InvalidArgumentException($cacheDirectory . ' is not writable');
        }
        // require to configure some CONSTANST
        new \HTMLPurifier_Bootstrap();
        $config = \HTMLPurifier_Config::createDefault();
        $config->set('Cache.SerializerPath', $cacheDirectory);
        $this->purifier = new \HTMLPurifier($config);
    }

    /**
     * Sanitize html text
     *
     * @param  string $text
     * @return string
     */
    public function doClean($text)
    {
        return trim($this->purifier->purify($text));
    }
}
