<?php

/**
 * This file is part of the RSSClient project.
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
 */
class NodeCollection extends \ArrayObject
{
    /**
     *
     * @param \Desarrolla2\RSSClient\Node\Node $node
     */
    public function append($node)
    {
        // @TODO: validate $node is valid Node
        parent::append($node);
    }

    /**
     *
     * @return \Desarrolla2\RSSClient\Node\Node | boolean
     */
    public function getFirst()
    {
        if (isset($this[0])) {
            return $this[0];
        }

        return false;
    }

    /**
     *
     * @return \Desarrolla2\RSSClient\Node\Node | boolean
     */
    public function getLast()
    {
        if (isset($this[$this->count() - 1])) {
            return $this[$this->count() - 1];
        }

        return false;
    }

    /**
     * Sort by bubble method
     */
    public function short()
    {
        $total = $this->count();
        for ($i = 1; $i < $total; $i++) {
            for ($j = 0; $j < $total - $i; $j++) {
                if ($this[$j]->getPubDate() === NULL
                    || $this[$j+1]->getPubDate() === NULL) { continue; }
                if ($this[$j]->getPubDate()->getTimestamp() > $this[$j + 1]->getPubDate()->getTimestamp()) {
                    continue;
                }
                $aux          = $this[$j + 1];
                $this[$j + 1] = $this[$j];
                $this[$j]     = $aux;
            }
        }
    }

    /**
     * Limit node Collection size
     *
     * @param int $limit
     */
    public function limit($limit)
    {
        $limit = (int)$limit;
        if (!$limit) {
            return;
        }
        $total = $this->count();
        if ($limit > $total) {
            return;
        }
        for ($i = $limit; $i < $total; $i++) {
            if (isset($this[$i])) {
                unset ($this[$i]);
            }
        }
    }
}
