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

namespace Desarrolla2\RSSClient\Factory;

use Desarrolla2\RSSClient\Exception\ParseException;
use Desarrolla2\RSSClient\Factory\AbstractNodeFactory;
use Desarrolla2\RSSClient\Node\RSS20;
use \DOMElement;
use \DateTime;

/**
 * RSS20NodeFactory
 *
 * @author : Daniel González Cerviño <daniel.gonzalez@freelancemadrid.es>
 */
class RSS20NodeFactory extends AbstractNodeFactory
{

    /**
     * @param DOMElement                        $item
     * @param \Desarrolla2\RSSClient\Node\RSS20 $node
     * @param RSS20                             $node
     */
    protected function setPubDate(DOMElement $item, RSS20 $node)
    {
        $value = $this->getNodeValueByTagName($item, 'pubDate');
        if ($value) {
            if (strtotime($value)) {
                $node->setPubDate(new DateTime($value));
            }
        }
    }

    /**
     * @param DOMElement $item
     * @param RSS20      $node
     */
    protected function setProperties(DOMElement $item, RSS20 $node)
    {
        $properties = array(
            'title',
            'description',
            'author',
            'comments',
            'enclosure',
            'guid',
            'source'
        );
        foreach ($properties as $propertyName) {
            $value = $this->getNodeValueByTagName($item, $propertyName);
            if ($value) {
                $method = 'set' . $propertyName;
                $node->$method(
                    $this->doClean($value)
                );
            }
        }
    }

    /**
     * @param DOMElement $item
     * @param RSS20      $node
     */
    protected function setCategories(DOMElement $item, RSS20 $node)
    {
        $categories = $this->getNodeValuesByTagName($item, 'category');
        foreach ($categories as $category) {
            $node->addCategory(
                $this->doClean($category)
            );
        }
    }

    /**
     * @param DOMElement $item
     * @param RSS20      $node
     */
    protected function setLink(DOMElement $item, RSS20 $node)
    {
        $value = $this->getNodeValueByTagName($item, 'link');
        if ($this->isValidURL($value)) {
            $node->setLink(
                $this->doClean($value)
            );
        }
    }

    /**
     * @param DOMElement $item
     * @param RSS20      $node
     */
    protected function setMedia(DOMElement $item, RSS20 $node)
    {
        foreach ($node->getMediaTypes() as $type) {
            $value = $this->getMediaNodeValueByTagName($item, $type);
            if (count($value) > 0) {
                $node->setMedia($type, $value);
            }
        }
    }

    /**
     * @param  DOMElement $domNode
     * @param  string      $tagName
     * @throws \Desarrolla2\RSSClient\Exception\ParseException
     * @return array
     */
    protected function getMediaNodeValueByTagName(DOMElement $domNode, $tagName)
    {
        try {
            $result = array();
            $list = $domNode->getElementsByTagName($tagName);
            for ($i = 0; $i < $list->length; $i++) {
                $result[$i] = array();
                $item = $list->item($i);
                foreach ($item->attributes as $key => $attr) {
                    $result[$i][$key] = $this->doClean($attr->value);
                }

                if (!$item->nodeValue) {
                    continue;
                }

                $result[$i]['node_value'] = $this->doClean($item->nodeValue);
            }

            return $result;
        } catch (\Exception $e) {
            throw new ParseException($e->getMessage());
        }

        return false;
    }

    /**
     *
     * @return \Desarrolla2\RSSClient\Node\RSS20
     */
    protected function getNode()
    {
        return new RSS20();
    }
}
