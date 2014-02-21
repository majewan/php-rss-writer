<?php

namespace Suin\RSSWriter;

use \Suin\RSSWriter\ChannelInterface;

interface FeedInterface
{
	/**
	 * Add channel
	 * @param \Suin\RSSWriter\ChannelInterface $channel
	 * @return $thisJ
	 */
	public function addChannel(ChannelInterface $channel);

	/**
	 * Add Extra Namespace support
	 * @param NameSpaceURI
	 * @param QualifiedName
	 * @return $thisJ
	 */
	public function addNamespace(\string $namespaceURI,\string $qualifiedName);

	/**
	 * Render XML
	 * @return string
	 */
	public function render();

	/**
	 * Render XML
	 * @return string
	 */
	public function __toString();
}
