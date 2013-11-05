<?php
/**
 * This file is part of the RSSClient project.
 *
 * Copyright (c)
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\RSSClient\Parser\Processor\RSS;

use Desarrolla2\RSSClient\Parser\Processor\ProcessorInterface;
use Desarrolla2\RSSClient\Node\NodeInterface;

/**
 * Class RSSMediaProcessor
 *
 * @author Daniel González <daniel.gonzalez@freelancemadrid.es>
 */

class RSSMediaProcessor implements ProcessorInterface
{
    public function execute(NodeInterface $node, \DOMElement $item)
    {
        $node->noveas = 100;
    }
}