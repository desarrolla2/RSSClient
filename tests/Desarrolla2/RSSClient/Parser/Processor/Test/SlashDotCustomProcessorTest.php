<?php
/**
 * This file is part of the RSSClient package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Desarrolla2\RSSClient\Parser\Processor\Test;

use Desarrolla2\RSSClient\Handler\Sanitizer\SanitizerHandlerDummy;
use Desarrolla2\RSSClient\Parser\Processor\AbstractProcessor;
use Desarrolla2\RSSClient\Node\NodeInterface;
use Desarrolla2\RSSClient\Node\RSS20 as Node;
use Desarrolla2\RSSClient\Parser\Processor\ProcessorInterface;
use DOMDocument;

/**
 * SlashDotCustomProcessor
 */
class SlashDotCustomProcessorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Node
     */
    protected $node;

    /**
     * @var SlashDotCustomProcessor
     */
    protected $processor;

    /**
     * @var \DOMElement
     */
    protected $domElement;

    protected function setUp()
    {
        $this->node = new Node();
        $this->processor = new SlashDotCustomProcessor(
            new SanitizerHandlerDummy()
        );
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
            <channel xmlns:slash="http://purl.org/rss/1.0/modules/slash/">
                <item>
                    <slash:comments>2</slash:comments>
                    <slash:department>sound-of-nails-being-hammered</slash:department>
                    <slash:section>yro</slash:section>
                    <slash:hit_parade>2,1,1,1,0,0,0</slash:hit_parade>
                </item>
            </channel>';
        $this->domDocument = new DOMDocument();
        $this->domDocument->strictErrorChecking = false;
        $this->domDocument->loadXML($xml);
        $result = $this->domDocument->getElementsByTagName('item');
        $this->domElement = $result->item(0);
    }

    public function testSlashDotCustomProcessor()
    {
        $this->processor->execute($this->node, $this->domElement);
        $this->assertEquals('2', $this->node->getExtended('comments'));
        $this->assertEquals('sound-of-nails-being-hammered', $this->node->getExtended('department'));
        $this->assertEquals('yro', $this->node->getExtended('section'));
        $this->assertEquals('2,1,1,1,0,0,0', $this->node->getExtended('hit_parade'));

    }

}

class SlashDotCustomProcessor implements ProcessorInterface
{
    /**
     * @var array
     */
    protected $slashTypes = array(
        'comments',
        'department',
        'section',
        'hit_parade'
    );

    /**
     * @param NodeInterface $node
     * @param \DOMElement   $item
     *
     * @return mixed|void
     */
    public function execute(NodeInterface $node, \DOMElement $item)
    {
        foreach ($this->slashTypes as $slashType) {
            $value = $this->getNodeValueByTagName($item, $slashType);
            if ($value) {
                $node->setExtended(
                    $slashType,
                    $value
                );

            }
        }
    }

    protected function getNodeValueByTagName(\DOMElement $domNode, $tagName)
    {
        try {
            $results = $domNode->getElementsByTagNameNS(
                'http://purl.org/rss/1.0/modules/slash/',
                $tagName
            );
            if ($results->length) {
                foreach ($results as $result) {
                    if ($result->nodeValue) {
                        return $result->nodeValue;
                    }
                }
            }
        } catch (\Exception $e) {
            throw new ParseException($e->getMessage());
        }
    }
}