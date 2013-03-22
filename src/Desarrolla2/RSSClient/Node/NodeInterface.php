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

/**
 * 
 * Description of NodeInterface
 *
 * @author : Daniel González Cerviño <daniel.gonzalez@freelancemadrid.es>  
 * @file : NodeInterface.php , UTF-8
 * @date : Mar 15, 2013 , 2:33:39 PM
 */
interface NodeInterface {

    public function getTitle();

    public function setTitle($title);

    public function getLink();

    public function setLink($link);

    public function getDescription();

    public function setDescription($description);

    public function getAuthor();

    public function setAuthor($author);

    public function getCategories();

    public function setCategories(array $categories);

    public function getComments();

    public function setComments($comments);

    public function getEnclosure();

    public function setEnclosure($enclosure);

    public function getGuid();

    public function setGuid($guid);

    public function getPubDate();

    public function setPubDate(\DateTime $pubDate);

    public function getSource();

    public function setSource($source);
}
