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

namespace Desarrolla2\RSSClient\Node;

use Desarrolla2\RSSClient\Node\Node;

/**
 *
 * RSS20
 *
 * @author : Daniel González Cerviño <daniel.gonzalez@freelancemadrid.es>
 */
class RSS20 extends Node
{
    /**
     * @var array
     */
    protected $media = array();

    /**
     * @return array
     */
    public function getMediaTypes()
    {
        return array(
            'content',
            'keywords',
            'thumbnail',
            'category',
            'comments',
        );
    }

    /**
     * @param  string $type
     * @return null|string
     */
    public function getMedia($type)
    {
        return array_key_exists($type, $this->media) ? $this->media[$type] : null;
    }

    /**
     * @param string $type
     * @param array  $value
     * @return self
     */
    public function setMedia($type, $value)
    {
        $this->media[$type] = $value;

        return $this;
    }
}
