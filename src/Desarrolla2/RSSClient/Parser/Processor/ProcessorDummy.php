<?php
/**
 * This file is part of the RSSClient package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Desarrolla2\RSSClient\Parser\Processor;

use Desarrolla2\RSSClient\Node\NodeInterface;

/**
 * ProcessorDummy
 */
class ProcessorDummy implements ProcessorInterface
{
    /**
     * @param NodeInterface $node
     * @param \DOMElement   $item
     *
     * @return mixed
     */
    public function execute(NodeInterface $node, \DOMElement $item)
    {
        // ..
    }

} 