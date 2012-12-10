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
namespace Desarrolla2\RSSClient\Test;

use Desarrolla2\RSSClient\RSSNode;

/**
 * 
 * Description of RSSNodeTest
 *
 * @author : Daniel González <daniel.gonzalez@freelancemadrid.es> 
 * @file : RSSNodeTest.php , UTF-8
 * @date : Oct 3, 2012 , 10:51:16 AM
 */
class RSSNodeTest extends \PHPUnit_Framework_TestCase
{
   
    /**
     * @var Desarrolla2\Bundle\RSSClientBundle\Model\RSSNode
     */
    protected $node = null;

    public function setUp()
    {
        $this->node = new RSSNode();
    }

    /**
     * data Provider 
     */
    public function getDataForTrue()
    {
        return array(
            array(
                array(
                    'title' => 'title',
                    'desc' => 'desc',
                    'link' => 'link',
                    'date' => '2012-01-01',
                    'content' => 'content'
                ),
            ),
        );
    }

    /**
     * data Provider 
     */
    public function getDataForFalse()
    {
        return array(
            array(
                array(
                    'title' => 'title',
                    'desc' => 'desc',
                    'link' => 'link',
                    'date' => 'dabDateTimeFormat',
                    'content' => 'content'
                ),
            ),
        );
    }

    /**
     * @test
     * @dataProvider getDataForTrue
     * @param type $options 
     */
    public function testTitle($options)
    {
        $this->node->fromArray($options);
        $this->assertEquals($options['title'], $this->node->getTitle());
    }

    /**
     * @test
     * @dataProvider getDataForTrue
     * @param type $options 
     */
    public function testDesc($options)
    {
        $this->node->fromArray($options);
        $this->assertEquals($options['desc'], $this->node->getDesc());
    }
    
    /**
     * @test
     * @dataProvider getDataForTrue
     * @param type $options 
     */
    public function testToString($options)
    {
        $this->node->fromArray($options);
        $this->assertEquals($options['desc'], (string) $this->node);
    }

    /**
     * @test
     * @dataProvider getDataForTrue
     * @param type $options 
     */
    public function testLink($options)
    {
        $this->node->fromArray($options);
        $this->assertEquals($options['link'], $this->node->getLink());
    }

    /**
     * @test
     * @dataProvider getDataForTrue
     * @param type $options 
     */
    public function testContent($options)
    {
        $this->node->fromArray($options);
        $this->assertEquals($options['content'], $this->node->getContent());
    }

    /**
     * @test
     * @dataProvider getDataForTrue
     * @param type $options 
     */
    public function testPubDate($options)
    {
        $this->node->fromArray($options);
        $date = new \DateTime($options['date']);
        $this->assertEquals($date, $this->node->getPubDate());
    }

    /**
     * @test
     * @dataProvider getDataForTrue
     * @param type $options 
     */
    public function testTimestamp($options)
    {
        $this->node->fromArray($options);
        $date = new \DateTime($options['date']);
        $this->assertEquals($date->getTimestamp(), $this->node->getTimestamp());
    }

    /**
     * @test
     * @dataProvider getDataForFalse
     * @param type $options 
     */
    public function testPubDateFalse($options)
    {
        $this->node->fromArray($options);
        $this->assertEquals(false, $this->node->getPubDate());
    }

    /**
     * @test
     * @dataProvider getDataForFalse
     * @param type $options 
     */
    public function testTimestampFalse($options)
    {
        $this->node->fromArray($options);
        $this->assertEquals(0, $this->node->getTimestamp());
    }

}
