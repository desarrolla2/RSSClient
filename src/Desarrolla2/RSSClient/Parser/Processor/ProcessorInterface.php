<?php
/**
 * This file is part of the RSSClient project.
 *
 * Copyright (c)
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\RSSClient\Parser\Processor;
use Desarrolla2\RSSClient\Node\NodeInterface;

/**
 * Class ProcessorInterfaze
 *
 * @author Daniel González <daniel.gonzalez@freelancemadrid.es>
 */

interface ProcessorInterface
{
    /**
     * @param NodeInterface $node
     * @param \DOMElement   $item
     * @return mixed
     */
    public function execute(NodeInterface $node, \DOMElement $item);
}