# Warning !!

RSSClient will not be updated, you should consider migrating to FastFeed https://github.com/FastFeed/FastFeed

# RSSClient

RSSClient is a simple to use RSS library to fetch and use RSS feeds. RSSClient is very fast!

[![Build Status](https://secure.travis-ci.org/desarrolla2/RSSClient.png)](http://travis-ci.org/desarrolla2/RSSClient) [![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/desarrolla2/RSSClient/badges/quality-score.png?s=7a7212c89918ef32a6deaf517d2e9a6dbf62aff1)](https://scrutinizer-ci.com/g/desarrolla2/RSSClient/) [![Code Coverage](https://scrutinizer-ci.com/g/desarrolla2/RSSClient/badges/coverage.png?s=63d93e31dc96210e3e531c741c66d6a80bb028d2)](https://scrutinizer-ci.com/g/desarrolla2/RSSClient/)

[![Latest Stable Version](https://poser.pugx.org/desarrolla2/rss-client/v/stable.png)](https://packagist.org/packages/desarrolla2/rss-client) [![Total Downloads](https://poser.pugx.org/desarrolla2/rss-client/downloads.png)](https://packagist.org/packages/desarrolla2/rss-client)  [![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/desarrolla2/rssclient/trend.png)](https://bitdeli.com/desarrolla2)

## Formats Supported

* [RSS2.0](http://cyber.law.harvard.edu/rss/rss.html)
* [Atom1.0](http://tools.ietf.org/html/rfc4287)

## Installation

### With Composer

It is best installed it through [packagist](http://packagist.org/packages/desarrolla2/rss-client) 
by including `desarrolla2/rss-client` in your project composer.json require:

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

$client = new RSSClient();

$client->addFeeds(
    array(
        'http://news.ycombinator.com/rss',
        'http://feeds.feedburner.com/TechCrunch/',
    ),
    'news'
);

$feeds = $client->fetch('news');

```

### With Cache

This example uses the cache implemented by `desarrolla2/cache` you must
select the adapter depending on your needs, you can find all the info in the 
[Github repository] (https://github.com/desarrolla2/Cache).

``` php
<?php

// It is important that you select and configure your cache adapter
$client = new RSSClient();
$client->setCache(new Cache(new File('/tmp')));

```

You can see how to configure desarrolla2/cache in its [README] (https://github.com/desarrolla2/Cache)

The rest of the procedure is exactly the same as if you were using the client without cache.

``` php
<?php

$client->addFeeds(
    array(
        'http://news.ycombinator.com/rss',
        'http://feeds.feedburner.com/TechCrunch/',
    ),
    'news'
);

$feeds = $client->fetch('news');

```

### Limiting the number of elements

You can use the second parameter of `fetch` to limit the number of elements

``` php
<?php

$feeds = $client->fetch('news', 20);

```

## Other

* Do you need a [custom processor] (https://github.com/desarrolla2/RSSClient/blob/master/doc/custom-process.md) ?
* [API docs](http://rssclient.desarrolla2.com/api/namespaces/Desarrolla2.RSSClient.html)


## Contact

You can contact with me on [twitter](https://twitter.com/desarrolla2).


