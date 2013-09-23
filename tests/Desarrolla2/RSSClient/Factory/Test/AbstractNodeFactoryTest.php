<?php
/**
 * This file is part of the RSSClient project.
 *
 * Copyright (c)
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\RSSClient\Factory\Test;

use Desarrolla2\RSSClient\Factory\AbstractNodeFactory;
use Desarrolla2\RSSClient\Node\Node;
use DOMDocument;

/**
 * Class AbstractNodeFactoryTest
 *
 * @author Daniel González <daniel.gonzalez@freelancemadrid.es>
 */

abstract class AbstractNodeFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Desarrolla2\RSSClient\Handler\Sanitizer\SanitizerHandlerDummy
     */
    protected $sanitizer;

    /**
     * @var AbstractNodeFactory
     */
    protected $factory;

    /**
     * @var Node
     */
    protected $node;

    /**
     * @var \DOMDocument
     */
    protected $dom;

    /**
     * @var string
     */
    protected $itemName;

    public function setUp()
    {
        $this->dom = new DOMDocument();
    }

    /**
     * @param string $file
     * @param string $title
     * @param string $guid
     * @param string $link
     * @param string $description
     * @param string $pubDay
     * @param int    $totalCategories
     */
    protected function testNodeFactory($file, $title, $guid, $link, $description, $pubDay, $totalCategories)
    {
        $string = file_get_contents(__DIR__ . $file);
        $this->dom->loadXML($string);

        $item = $this->dom->getElementsByTagName($this->itemName)->item(0);
        $this->node = $this->factory->create($item);

        $this->assertEquals($title, $this->node->getTitle(), 'the title was not expected');
        $this->assertEquals($guid, $this->node->getGuid(), 'the guid was not expected');
        $this->assertEquals($link, $this->node->getLink(), 'the link was not expected');
        $this->assertEquals($description, $this->node->getDescription(), 'description was not expected');
        $this->assertEquals($pubDay, $this->node->getPubDate()->format('d'), 'the pudDate was not expected');
        $this->assertEquals($totalCategories, count($this->node->getCategories()), 'total categories was not expected');
    }
}
