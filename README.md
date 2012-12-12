# RSSClient

[![Build Status](https://secure.travis-ci.org/desarrolla2/RSSClient.png)](http://travis-ci.org/desarrolla2/RSSClient)

A independent RSS client library.


## Installation

### With Composer

It is best installed it through [packagist](http://packagist.org/packages/desarrolla2/rss-client) 
by including
`desarrolla2/rss-client` in your project composer.json require:

``` json
    "require": {
        // ...
        "desarrolla2/rss-client":  "dev-master"
    }
```

### Without Composer

You can also download it from [Github] (https://github.com/desarrolla2/RSSClient), 
but no autoloader is provided so you'll need to register it with your own PSR-0 
compatible autoloader.

## Usage

### Without Cache

This example does not use any cache, so it probably will be too slow to be used on 
a website, you should implement your system cache, or use the cache system described below

``` php
    <?php

    use Desarrolla2\RSSClient\RSSClient;
    use Desarrolla2\RSSClient\Sanitizer\Sanitizer;

    $client = new RSSClient();

    $client->addFeeds(array(
            'http://news.ycombinator.com/rss',
            'http://feeds.feedburner.com/TechCrunch/',
                ), 'news'
        );

    $feeds = $client->fetch('news');

```

### With Cache

This example uses the cache implemented by Seller desarrolla2/cache you must 
select the adapter depending on your needs, you can find all the info in the 
repository [Github] (https://github.com/desarrolla2/Cache).

``` php
    <?php

    use Desarrolla2\RSSClient\RSSCacheClient;
    use Desarrolla2\RSSClient\Sanitizer\Sanitizer;
    use Desarrolla2\Cache\Cache;
    use Desarrolla2\Cache\Adapter\NotCache;

    // It is important that you select and configure your cache adapter
    $client = new RSSCacheClient(new Cache(new File('/tmp')));

```

You can see how to configure desarrolla2/cache in its [README] (https://github.com/desarrolla2/Cache)

The rest of the procedure is exactly the same as if you were using the client without cache.

``` php
    <?php
    
    $client->addFeeds(array(
        'http://news.ycombinator.com/rss',
        'http://feeds.feedburner.com/TechCrunch/',
        ), 'news'
    ));

    $feeds = $client->fetch('news');

```
## Coming soon

* This client only was tested with RSS2.0 other format not guaranteed.

## Contact

You can contact with me on [twitter](https://twitter.com/desarrolla2).