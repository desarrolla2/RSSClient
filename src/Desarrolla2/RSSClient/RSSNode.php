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

namespace Desarrolla2\RSSClient;

use DateTime;

/**
 * 
 * Description of RSSNode
 *
 * @author : Daniel González <daniel.gonzalez@freelancemadrid.es> 
 * @file : Node.php , UTF-8
 * @date : Oct 3, 2012 , 2:06:56 AM
 */
class RSSNode
{

    /**
     * @var string
     */
    protected $title = null;

    /**
     * @var string
     */
    protected $desc = null;

    /**
     * @var string
     */
    protected $content = null;

    /**
     * @var string
     */
    protected $link = null;

    /**
     * @var \DateTime
     */
    protected $pubDate = null;

    /**
     *
     * @param array $options 
     */
    public function __construct($options = array())
    {
        $this->fromArray($options);
    }

    /**
     * toString 
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->getDesc();
    }

    /**
     *
     * @param array $options 
     */
    public function fromArray($options = array())
    {
        if (is_array($options)) {
            if (isset($options['title'])) {
                $this->setTitle($options['title']);
            }
            if (isset($options['desc'])) {
                $this->setDesc($options['desc']);
            }
            if (isset($options['content'])) {
                $this->setContent($options['content']);
            }
            if (isset($options['link'])) {
                $this->setLink($options['link']);
            }
            if (isset($options['date'])) {
                $this->setPubDate($options['date']);
            }
        }
    }

    /**
     *
     * @param string $title 
     */
    public function setTitle($title)
    {
        $this->title = $this->doClean($title);
    }

    /**
     *
     * @return string $title 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     *
     * @param string $desc 
     */
    public function setDesc($desc)
    {
        $this->desc = $this->doClean($desc);
    }

    /**
     *
     * @return string $desc  
     */
    public function getDesc()
    {
        return $this->desc;
    }

    /**
     *
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $this->doClean($content);
    }

    /**
     *
     * @return string $content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     *
     * @param string $link 
     */
    public function setLink($link)
    {
        $this->link = $this->doClean($link);
    }

    /**
     *
     * @return string $link  
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     *
     * @param  string $date 
     */
    public function setPubDate($date)
    {
        if (strtotime($date)) {
            $this->pubDate = new DateTime($date);
        } else {
            $this->pubDate = false;
        }
    }

    /**
     * Retrieve Pub date
     * 
     * @return DateTime $date 
     */
    public function getPubDate()
    {
        return $this->pubDate;
    }

    /**
     * Retrieve timestamp
     * 
     * @return int
     */
    public function getTimestamp()
    {
        if ($this->pubDate) {
            return $this->pubDate->getTimestamp();
        }
        return false;
    }

    /**
     * Clean text for XSS atacks
     * 
     * @param string $string
     * @return string $string 
     */
    protected function doClean($string)
    {
        return (string) $string;
    }

}
