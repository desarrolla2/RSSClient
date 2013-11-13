<?php
/**
 * This file is part of the RSSClient project.
 *
 * Copyright (c)
 *
 * This source file is subject to the license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\RSSClient\Parser\Processor;

use Desarrolla2\RSSClient\Exception\ParseException;
use Desarrolla2\RSSClient\Handler\Sanitizer\SanitizerHandlerInterface;

/**
 * Class AbstractProcessor
 *
 * author daniel.gonzalez@freelancemadrid.es
 */
abstract class AbstractProcessor implements ProcessorInterface
{
    /**
     * @var SanitizerHandlerInterface
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
     * @param  \DOMElement $domNode
     * @param  string      $tagName
     *
     * @throws ParseException
     * @return array
     */
    protected function getNodeValueByTagName(\DOMElement $domNode, $tagName)
    {
        try {
            $results = $domNode->getElementsByTagName($tagName);
            if ($results->length) {
                foreach ($results as $result) {
                    if ($result->nodeValue) {
                        return $result->nodeValue;
                    }
                }
            }
        } catch (\Exception $e) {
            throw new ParseException($e->getMessage());
        }
    }

    /**
     *
     * @param  string $text
     *
     * @return string
     */
    protected function doClean($text)
    {
        return trim($this->sanitizer->doClean($text));
    }

} 