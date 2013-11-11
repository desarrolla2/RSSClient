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

/**
 *
 * Description of NodeInterface
 *
 * @author : Daniel González Cerviño <daniel.gonzalez@freelancemadrid.es>
 */

interface NodeInterface
{
    /**
     * @return mixed
     */
    public function getTitle();

    /**
     * @param $title
     *
     * @return mixed
     */
    public function setTitle($title);

    /**
     * @return mixed
     */
    public function getLink();

    /**
     * @param $link
     *
     * @return mixed
     */
    public function setLink($link);

    /**
     * @return mixed
     */
    public function getDescription();

    /**
     * @param $description
     *
     * @return mixed
     */
    public function setDescription($description);

    /**
     * @return mixed
     */
    public function getAuthor();

    /**
     * @param $author
     *
     * @return mixed
     */
    public function setAuthor($author);

    /**
     * @return mixed
     */
    public function getCategories();

    /**
     * @param array $categories
     *
     * @return mixed
     */
    public function setCategories(array $categories);

    /**
     * @return mixed
     */
    public function getComments();

    /**
     * @param $comments
     *
     * @return mixed
     */
    public function setComments($comments);

    /**
     * @return mixed
     */
    public function getEnclosure();

    /**
     * @param $enclosure
     *
     * @return mixed
     */
    public function setEnclosure($enclosure);

    /**
     * @return mixed
     */
    public function getGuid();

    /**
     * @param $guid
     *
     * @return mixed
     */
    public function setGuid($guid);

    /**
     * @return mixed
     */
    public function getPubDate();

    /**
     * @param \DateTime $pubDate
     *
     * @return mixed
     */
    public function setPubDate(\DateTime $pubDate);

    /**
     * @return mixed
     */
    public function getSource();

    /**
     * @param $source
     *
     * @return mixed
     */
    public function setSource($source);

    /**
     * @param $key
     * @param $value
     */
    public function setExtended($key, $value);

    /**
     * @param $key
     *
     * @return array
     */
    public function getExtended($key);
}
