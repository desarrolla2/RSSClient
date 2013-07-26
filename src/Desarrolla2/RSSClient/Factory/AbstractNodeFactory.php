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

use Desarrolla2\RSSClient\Handler\Sanitizer\SanitizerHandlerInterface;
use Desarrolla2\RSSClient\Exception\ParseException;
use \DOMElement;

/**
 *
 * Description of NodeFactory
 *
 * @author : Daniel González Cerviño <daniel.gonzalez@freelancemadrid.es>
 */
abstract class AbstractNodeFactory
{
    /**
     * @var \Desarrolla2\RSSClient\Handler\Sanitizer\SanitizerHandlerInterface
     */
    protected $sanitizer;

    /**
     * @param SanitizerHandlerInterface $sanitizer
     */
    public function __construct(SanitizerHandlerInterface $sanitizer)
    {
        $this->sanitizer = $sanitizer;
    }

    /**
     *
     * @param  string $text
     * @return string
     */
    protected function doClean($text)
    {
        return $this->sanitizer->doClean($text);
    }

    /**
     *
     * @param  \DOMElement $DOMnode
     * @param  string      $tagName
     * @throws \Desarrolla2\RSSClient\Exception\ParseException
     * @return string
     */
    protected function getNodeValueByTagName(\DOMElement $DOMnode, $tagName)
    {
        try {
            $list = $DOMnode->getElementsByTagName($tagName);
            for ($i = 0; $i < $list->length; $i++) {
                $result = $list->item($i);
                if (!$result->nodeValue) {
                    continue;
                }

                return $result->nodeValue;
            }
        } catch (\Exception $e) {
            throw new ParseException($e->getMessage());
        }

        return false;
    }

    /**
     *
     * @param  \DOMElement $DOMnode
     * @param  type        $tagName
     * @param  type        $propertyName
     * @return type
     * @throws ParseException
     */
    protected function getNodePropertiesByTagName(\DOMElement $DOMnode, $tagName, $propertyName)
    {
        $values = array();
        try {
            $results = $DOMnode->getElementsByTagName($tagName);
            if ($results->length) {
                foreach ($results as $result) {
                    if ($result->getAttribute($propertyName)) {
                        $values[] = $result->getAttribute($propertyName);
                    }
                }
            }
        } catch (\Exception $e) {
            throw new ParseException($e->getMessage());
        }

        return $values;
    }

    /**
     *
     * @param  \DOMElement $DOMnode
     * @param  string      $tagName
     * @throws \Desarrolla2\RSSClient\Exception\ParseException
     * @return array
     */
    protected function getNodeValuesByTagName(\DOMElement $DOMnode, $tagName)
    {
        $values = array();
        try {
            $results = $DOMnode->getElementsByTagName($tagName);
            if ($results->length) {
                foreach ($results as $result) {
                    if ($result->nodeValue) {
                        $values[] = $result->nodeValue;
                    }
                }
            }
        } catch (\Exception $e) {
            throw new ParseException($e->getMessage());
        }

        return $values;
    }

    /**
     *
     * @param string $url
     * @return bool
     */
    protected function isValidURL($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL) ? true : false;
    }
}
