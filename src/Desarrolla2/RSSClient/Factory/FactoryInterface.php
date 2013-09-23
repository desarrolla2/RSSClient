<?php
/**
 * This file is part of the RSSClient project.
 *
 * Copyright (c)
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\RSSClient\Factory;

use Desarrolla2\RSSClient\Node\Node;
use \DOMElement;

/**
 * Class FactoryInterface
 *
 * @author Daniel González <daniel.gonzalez@freelancemadrid.es>
 */

interface FactoryInterface
{
    /**
     *
     * @param  DOMElement $item
     * @throws \Desarrolla2\RSSClient\Exception\ParseException
     * @return \Desarrolla2\RSSClient\Node\Node
     */
    public function create(DOMElement $item);
}
