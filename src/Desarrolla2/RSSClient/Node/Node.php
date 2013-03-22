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

namespace Desarrolla2\RSSClient\Node;

use Desarrolla2\RSSClient\Node\NodeInterface;

/**
 * 
 * Description of Node
 *
 * @author : Daniel González Cerviño <daniel.gonzalez@freelancemadrid.es>  
 * @file : Node.php , UTF-8
 * @date : Mar 22, 2013 , 1:35:56 PM
 */
abstract class Node implements NodeInterface {

    /**
     * @var string
     */
    protected $title = null;

    /**
     * @var string
     */
    protected $link = null;

    /**
     * @var string
     */
    protected $description = null;

    /**
     * @var string
     */
    protected $author = null;

    /**
     * @var array
     */
    protected $categories = array();

    /**
     * @var string
     */
    protected $comments = null;

    /**
     * @var string
     */
    protected $enclosure = null;

    /**
     * @var string
     */
    protected $guid = null;

    /**
     * @var \DateTime
     */
    protected $pubDate = null;

    /**
     * @var string
     */
    protected $source = null;

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getLink() {
        return $this->link;
    }

    public function setLink($link) {
        $this->link = $link;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function setAuthor($author) {
        $this->author = $author;
    }

    public function getCategories() {
        return $this->categories;
    }

    public function setCategories(array $categories) {
        $this->categories = $categories;
    }

    public function addCategory($category) {
        $this->categories[] = $category;
    }

    public function getComments() {
        return $this->comments;
    }

    public function setComments($comments) {
        $this->comments = $comments;
    }

    public function getEnclosure() {
        return $this->enclosure;
    }

    public function setEnclosure($enclosure) {
        $this->enclosure = $enclosure;
    }

    public function getGuid() {
        return $this->guid;
    }

    public function setGuid($guid) {
        $this->guid = $guid;
    }

    public function getPubDate() {
        return $this->pubDate;
    }

    public function setPubDate(\DateTime $pubDate) {
        $this->pubDate = $pubDate;
    }

    public function getSource() {
        return $this->source;
    }

    public function setSource($source) {
        $this->source = $source;
    }

}