<?php

/*
 * This file is part of the desarrolla2 package.
 * 
 * Short description   
 *
 * @author Daniel González <daniel.gonzalez@freelancemadrid.es>
 * @date Aug 9, 2012, 1:01:07 AM
 * @file RSSClientInterface.php , UTF-8
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desarrolla2\Bundle\RSSClientBundle\Model;

interface RSSClientInterface
{

    /**
     * @return array feeds
     */
    public function getFeeds();

    /**
     *
     * @param string $feed 
     */
    public function setFeed($feed);

    /**
     *
     * @param array $feeds 
     */
    public function setFeeds($feeds);

    /**
     *
     * @param string $feed 
     */
    public function addFeed($feed);

    /**
     *
     * @param array $feeds 
     */
    public function addFeeds($feeds);

    /**
     *
     * @return int count $feeds
     */
    public function countFeeds();

    /**
     *
     * @return int $nodes
     */
    public function fetch();
}
