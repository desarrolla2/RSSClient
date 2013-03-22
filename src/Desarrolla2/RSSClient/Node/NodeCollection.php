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

/**
 * 
 * Description of NodeCollection
 *
 * @author : Daniel González Cerviño <daniel.gonzalez@freelancemadrid.es>  
 * @file : NodeCollection.php , UTF-8
 * @date : Mar 22, 2013 , 1:43:19 PM
 */
class NodeCollection {

    /**
     * @var arrray
     */
    protected $nodes = array();

    public function count() {
        return count($this->nodes);
    }

    public function append(Node $node) {
        $this->nodes[] = $node;
    }

    public function short() {
        
    }

}
