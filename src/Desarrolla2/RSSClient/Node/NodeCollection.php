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
class NodeCollection extends \ArrayObject {

    public function getFirst() {
        return $this[0];
    }

    public function getLast() {
        return $this[$this->count() - 1];
    }

    public function short() {
        
    }

    /**
     * Sort by buuble method
     * 
     * @param string $channel
     */
    protected function AUXsort($channel = 'default') {
        $countNodes = $this->countNodes($channel);
        for ($i = 1; $i < $countNodes; $i++) {
            for ($j = 0; $j < $countNodes - $i; $j++) {
                if ($this->nodes[$channel][$j]->getTimestamp() < $this->nodes[$channel][$j + 1]->getTimestamp()) {
                    $k = $this->nodes[$channel][$j + 1];
                    $this->nodes[$channel][$j + 1] = $this->nodes[$channel][$j];
                    $this->nodes[$channel][$j] = $k;
                }
            }
        }
    }

}
