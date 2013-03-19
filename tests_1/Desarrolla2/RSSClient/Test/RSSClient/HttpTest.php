<?php

/**
 * 
 * Description of HttpErrorTest
 * 
 * This file is part of the RSSClient proyect.
 *
 * @author : Daniel González Cerviño <daniel.gonzalez@freelancemadrid.es> 
 * @file : HttpErrorTest.php , UTF-8
 * @date : Dec 12, 2012 , 7:12:07 PM
 */

namespace Desarrolla2\RSSClient\Test\RSSClient;

use Desarrolla2\RSSClient\RSSClient;

class HttpTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \Desarrolla2\RSSClient\RSSClient
     */
    protected $client;
    
        /**
     * @var string
     */
    protected $example_feed = 'http://desarrolla2.com/feed/';

    /**
     * 
     */
    public function setUp()
    {
        $this->client = new RSSClient();
        $this->client->addFeed($this->example_feed);
    }

    public function testFetch()
    {
        $stub = $this->getMock('\Desarrolla2\RSSClient\HTTPClient\HTTPClient');
        $stub->expects($this->any())
                ->method('get')
                ->will($this->returnValue('<?xml version="1.0" encoding="UTF-8" ?>
<rss version="2.0">
<channel>
        <title>RSS Title</title>
        <description>This is an example of an RSS feed</description>
        <link>http://www.someexamplerssdomain.com/main.html</link>
        <lastBuildDate>Mon, 06 Sep 2010 00:01:00 +0000 </lastBuildDate>
        <pubDate>Mon, 06 Sep 2009 16:45:00 +0000 </pubDate>
        <ttl>1800</ttl>
        <item>
                <title>Example entry</title>
                <description>Here is some text containing an interesting description.</description>
                <link>http://www.wikipedia.org/</link>
                <guid>unique string per item</guid>
                <pubDate>Mon, 06 Sep 2009 16:45:00 +0000 </pubDate>
        </item> 
        <item>
                <title>Example entry</title>
                <description>Here is some text containing an interesting description.</description>
                <link>http://www.wikipedia.org/</link>
                <guid>unique string per item</guid>
                <pubDate>Mon, 06 Sep 2009 16:45:00 +0000 </pubDate>
        </item> 
</channel>
</rss>'));
        $this->client->setHTTPClient($stub);
        $nodes = $this->client->fetch();
        $this->assertEquals(count($nodes), 2);
    }

}