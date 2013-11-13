# Custom logic for process RSS

Maybe you need your custom logic for feed process. In this case you need to create a custom processor that implements
ProcessorInterface

``` php
<?php

use Desarrolla2\RSSClient\Parser\Processor\ProcessorInterface;

class CustomProcessor implements ProcessorInterface
{
    /**
     * @var array
     */
    protected $mediaTypes = array(
        'content',
        'keywords',
        'thumbnail',
        'category',
        'comments',
    );

    /**
     * @param NodeInterface $node
     * @param \DOMElement   $item
     *
     * @return mixed|void
     */
    public function execute(NodeInterface $node, \DOMElement $item)
    {
        foreach ($this->mediaTypes as $mediaType) {
            /* Implement getNodeValueByTagName yourself */
            $value = $this->getNodeValueByTagName($item, $mediaType);
            if ($value) {
                $node->setExtended(
                    $mediaType,
                    $value
                );

            }
        }
    }
}

```

And them push it on the top of processors stack.

``` php
<?php

use Desarrolla2\RSSClient\RSSClient;

$client = new RSSClient();
$client->pushProcessor( new CustomProcessor($client->getSanitizerHandler()));

```

Now you can continue normally.

``` php
<?php

$client->fetch();

```


