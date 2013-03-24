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

namespace Desarrolla2\RSSClient\Node\Test;

use Desarrolla2\RSSClient\Node\RSS20;
use Desarrolla2\RSSClient\Node\NodeCollection;

/**
 * 
 * Description of NodeCollectionTest
 *
 * @author : Daniel González <daniel.gonzalez@freelancemadrid.es> 
 * @file : NodeCollectionTest.php , UTF-8
 * @date : Mar 24, 2013 , 11:16:06 PM
 */
class NodeCollectionTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var \Desarrolla2\RSSClient\Node\NodeCollection
     */
    protected $collection;

    /**
     * Setup
     */
    public function setUp() {
        $this->collection = new NodeCollection();
    }

    /**
     * @test
     */
    public function testShort() {

        $dates = array(
            '2012-01-01', '2012-01-02', '2012-01-03',
        );

        foreach ($dates as $date) {
            $node = new RSS20();
            $node->setPubDate(new \DateTime($date));
            $this->collection->append($node);
        }

        $this->collection->short();
        $first = $this->collection->getFirst();
        $this->assertEquals($first->getPubDate()->format('d'), '3');
    }

}