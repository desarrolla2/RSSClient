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

namespace Desarrolla2\RSSClient\Factory;

use Desarrolla2\RSSClient\Exception\ParseException;
use Desarrolla2\RSSClient\Factory\AbstractNodeFactory;
use Desarrolla2\RSSClient\Node\RSS20;
use \DOMElement;
use \DateTime;

/**
 * 
 * Description of RSS20NodeFactory
 *
 * @author : Daniel González Cerviño <daniel.gonzalez@freelancemadrid.es>  
 * @file : RSS.php , UTF-8
 * @date : Mar 15, 2013 , 11:50:30 AM
 */
class RSS20NodeFactory extends AbstractNodeFactory {

    /**
     * 
     * @param DOMElement $item
     * @return \Desarrolla2\RSSClient\Node\RSS20
     */
    public function create(DOMElement $item) {
        $node = new RSS20;
        $properties = array(
            'title', 'link', 'description', 'author',
            'comments', 'enclosure', 'guid',
            'source'
        );
        foreach ($properties as $propertyName) {
            $value = $this->getNodeValue($item, $propertyName);
            if ($value) {
                $method = 'set' . $propertyName;
                $node->$method(
                        $this->doClean($value)
                );
            }
        }

        $categories = $this->getNodeValues($item, 'category');
        foreach ($categories as $category) {
            $node->addCategory(
                    $this->doClean($category)
            );
        }
        $value = $this->getNodeValue($item, 'pubDate');
        if ($value) {
            if (strtotime($value)) {
                $node->setPubDate(new DateTime($value));
            }
        }
        if (!$node->getGuid()) {
            throw new ParseException('Guid not found');
        }
        return $node;
    }

}
