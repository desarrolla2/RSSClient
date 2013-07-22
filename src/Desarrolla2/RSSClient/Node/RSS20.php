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

namespace Desarrolla2\RSSClient\Node;

use Desarrolla2\RSSClient\Node\Node;
use Desarrolla2\RSSClient\Exception\ParseException;
use \DOMElement;

/**
 *
 * Description of RSS
 *
 * @author : Daniel González Cerviño <daniel.gonzalez@freelancemadrid.es>
 * @file : RSS.php , UTF-8
 * @date : Mar 15, 2013 , 11:49:45 AM
 */
class RSS20 extends Node
{
    /**
     * Based RSS2.0 specification
     *
     * @link http://feed2.w3.org/docs/rss2.html#requiredChannelElements
     */
    public function validate(DOMElement $item){
        $properties = array(
            'title'         => array('required' => TRUE), 
            'link'          => array('required' => TRUE),
            'description'   => array('required' => TRUE),
            'author'        => array('required' => FALSE), 
            'category'      => array('required' => FALSE), 
            'comments'      => array('required' => FALSE), 
            'enclosure'     => array('required' => FALSE),
            'guid'          => array('required' => FALSE),
            'pubDate'       => array('required' => FALSE), 
            'source'        => array('required' => FALSE), 
        );
        foreach ($properties as $propertyName => $attributes) {
            if($attributes['required'] == FALSE) continue;

            $value = $item->getElementsByTagName($propertyName)->item(0);
            if(!$value){
                throw new ParseException('<item> node invalid');
            }
        }
    }
}