<?php

namespace Suin\RSSWriter;

use \DOMDocument;
use \Suin\RSSWriter\ChannelInterface;

class Feed implements \Suin\RSSWriter\FeedInterface
{
	/** @var \Suin\RSSWriter\ChannelInterface[] */
	protected $channels = array();
  protected $namespaces = array();

	/**
	 * Add channel
	 * @param \Suin\RSSWriter\ChannelInterface $channel
	 * @return $this
	 */
	public function addChannel(ChannelInterface $channel)
	{
		$this->channels[] = $channel;
		return $this;
	}

	/**
	 * Add Extra Namespace support
	 * @param NameSpaceURI
	 * @param QualifiedName
	 * @return $thisJ
	 */
	public function addNamespace($namespaceURI, $qualifiedName)
  {
    $this->namespaces[] = array('namespaceURI' => $namespaceURI,'qualifiedName' => $qualifiedName);
  }

    /**
     * Render XML
     * @param bool $formatOutput whether pretty format output. Defautls to true
     * @return string
     */
	public function render($formatOutput = true)
	{
        $xml = new DOMDocument('1.0', 'utf-8');
        $xml->formatOutput = $formatOutput;
        $rss = $xml->createElement('rss');
        $rss->setAttribute('version', '2.0');
        $xml->appendChild($rss);
    foreach ($this->namespaces as $namespace){
      $xml->createAttributeNS($namespace['namespaceURI'],$namespace['qualifiedName']);
    }
		foreach ($this->channels as $channel) {
            $channel->buildXML($xml->documentElement);
		}

        return $xml->saveXML();
	}

	/**
	 * Render XML
	 * @return string
	 */
	public function __toString()
	{
		return $this->render();
	}
}
