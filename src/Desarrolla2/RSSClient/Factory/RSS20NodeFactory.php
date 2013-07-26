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
 * RSS20NodeFactory
 *
 * @author : Daniel González Cerviño <daniel.gonzalez@freelancemadrid.es>
 */
class RSS20NodeFactory extends AbstractNodeFactory
{
    /**
     *
     * @param  DOMElement $item
     * @throws \Desarrolla2\RSSClient\Exception\ParseException
     * @return \Desarrolla2\RSSClient\Node\RSS20
     */
    public function create(DOMElement $item)
    {
        $node = $this->getNode();

        $this->setProperties($item, $node);
        $this->setLink($item, $node);
        $this->setCategories($item, $node);
        $this->setPubDate($item, $node);

        if (!$node->getGuid()) {
            throw new ParseException('Guid not found');
        }

        return $node;
    }

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
     *
     * @return \Desarrolla2\RSSClient\Node\RSS20
     */
    protected function getNode()
    {
        return new RSS20();
    }
}
