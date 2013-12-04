<?php

/**
 * This file is part of the RSSClient project.
 *
 * Copyright (c)
 * Daniel González <daniel.gonzalez@freelancemadrid.es>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\RSSClient\Node\Test;

use Desarrolla2\RSSClient\Node\RSS20 as Node;
use Desarrolla2\RSSClient\Node\NodeCollection;

/**
 *
 * Description of NodeCollectionTest
 *
 * @author : Daniel González <daniel.gonzalez@freelancemadrid.es>
 */
class NodeCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Desarrolla2\RSSClient\Node\NodeCollection
     */
    protected $collection;

    /**
     * Setup
     */
    public function setUp()
    {
        $this->collection = new NodeCollection();
    }

    /**
     * @test
     */
    public function testShort()
    {
        $dates = array(
            '2012-01-01',
            '2012-01-02',
            '2012-01-03',
        );

        foreach ($dates as $date) {
            $node = new Node();
            $node->setPubDate(new \DateTime($date));
            $this->collection->append($node);
        }

        $this->collection->short();
        $first = $this->collection->getFirst();
        $this->assertEquals($first->getPubDate()->format('d'), '3');
    }

    /**
     * @test if any or all node do not have PubDate
     */
    public function testShortLackOfPubdate()
    {
        $dates = array(
            '2012-01-01',
            '2012-01-02',
            '2012-01-03',
        );

        foreach ($dates as $date) {
            $node = new Node();
            if ($date !== '2012-01-02') {
                // intentinally make a node without pubdate
                $node->setPubDate(new \DateTime($date));
            }
            $this->collection->append($node);
        }

        $this->collection->short();
        $first = $this->collection->getFirst();
        // bubble sort won't happen
        $this->assertEquals($first->getPubDate()->format('d'), '1');
    }

    /**
     * @dataProvider dataProviderForTestLimit
     */
    public function testLimit($limit)
    {
        for ($i = 1; $i <= 20; $i++) {
            $node = new Node();
            $node->setPubDate(new \DateTime());
            $this->collection->append($node);
        }
        $this->collection->limit($limit);
        $this->assertEquals($limit, $this->collection->count());
    }

    /**
     * @return array
     */
    public function dataProviderForTestLimit()
    {
        return array(
            array(5),
            array(15),
        );
    }
}
