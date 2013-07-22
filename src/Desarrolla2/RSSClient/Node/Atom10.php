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

namespace Desarrolla2\RSSClient\Node;

use Desarrolla2\RSSClient\Node\Node;
use Desarrolla2\RSSClient\Exception\ParseException;
use \DOMElement;

/**
 *
 * Description of Atom10
 *
 * @author : Daniel González <daniel.gonzalez@freelancemadrid.es>
 * @file : Atom10.php , UTF-8
 * @date : Mar 24, 2013 , 7:12:40 PM
 */
class Atom10 extends Node
{
    /**
     * Based Atom 1.0 specification
     *
     * @link http://www.atomenabled.org/developers/syndication/atom-format-spec.php#element.entry
     */
    public function validate(DOMElement $entry){
        //@TODO: define all properties
        $properties = array(
            'id'          	=> array('required' => TRUE),
            'title'         => array('required' => TRUE), 
            'content'   	=> array('required' => TRUE),
            'updated'		=> array('required' => TRUE),
            'link'			=> array('required' => FALSE),
        );
        foreach ($properties as $propertyName => $attributes) {
            if($attributes['required'] == FALSE) continue;

            $value = $entry->getElementsByTagName($propertyName)->item(0);
            if(!$value){
                throw new ParseException('<entry> node invalid');
            }
        }
    }
}
