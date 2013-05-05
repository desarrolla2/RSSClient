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

namespace Desarrolla2\RSSClient\Factory;

use Desarrolla2\RSSClient\Exception\ParseException;
use Desarrolla2\RSSClient\Factory\AbstractNodeFactory;
use Desarrolla2\RSSClient\Node\Atom10;
use \DOMElement;
use \DateTime;

/**
 *
 * Description of Atom10NodeFactory
 *
 * @author : Daniel González <daniel.gonzalez@freelancemadrid.es>
 * @file : Atom10NodeFactory.php , UTF-8
 * @date : Mar 24, 2013 , 7:12:06 PM
 */
class Atom10NodeFactory extends AbstractNodeFactory
{
    /**
     *
     * @param  DOMElement                         $entry
     * @return \Desarrolla2\RSSClient\Node\Atom10
     */
    public function create(DOMElement $entry)
    {
        $node = $this->getNode();
        $node->validate($entry);

        $this->setProperties($entry, $node);
        $this->setCategories($entry, $node);
        $this->setLink($entry, $node);
        $this->setPubDate($entry, $node);

        return $node;
    }

    protected function setLink(DOMElement $entry, Atom10 $node)
    {
        try {
            $results = $entry->getElementsByTagName('link');
            if ($results->length) {
                foreach ($results as $result) {
                    if ($result->getAttribute('rel') == 'alternate') {
                        $value = $result->getAttribute('href');
                        if ($this->isValidURL($value)) {
                            $node->setLink(
                                    $this->doClean($value)
                            );

                            return;
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            throw new ParseException($e->getMessage());
        }
    }

    protected function setPubDate(DOMElement $entry, Atom10 $node)
    {
        $value = $this->getNodeValueByTagName($entry, 'published');
        if ($value) {
            if (strtotime($value)) {
                $node->setPubDate(new DateTime($value));
            }
        }
    }

    protected function setProperties(DOMElement $entry, Atom10 $node)
    {
        $properties = array(
            'id' => 'setGUID',
            'title' => 'setTitle',
            'content' => 'setDescription'
        );
        foreach ($properties as $propertyName => $method) {
            $value = $this->getNodeValueByTagName($entry, $propertyName);
            if ($value) {
                $node->$method(
                        $this->doClean($value)
                );
            }
        }
    }

    protected function setCategories(DOMElement $entry, Atom10 $node)
    {
        $categories = $this->getNodePropertiesByTagName($entry, 'category', 'term');
        foreach ($categories as $category) {
            $node->addCategory(
                    $this->doClean($category)
            );
        }
    }

    /**
     *
     * @return \Desarrolla2\RSSClient\Node\Atom10
     */
    protected function getNode()
    {
        return new Atom10();
    }

}
