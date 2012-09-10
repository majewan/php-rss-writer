<?php

namespace Suin\RSSWriter;

use \Suin\RSSWriter\SimpleXMLElement;
use DOMNode;

class Item implements \Suin\RSSWriter\ItemInterface
{
	/** @var string */
	protected $title;
	/** @var string */
	protected $url;
	/** @var string */
	protected $description;
	/** @var array */
	protected $categories = array();
	/** @var string */
	protected $guid;
	/** @var bool */
	protected $isPermalink;
	/** @var int */
	protected $pubDate;
    /** @var XmlElementInterface[] */
    protected $childs = array();

	/**
	 * Set item title
	 * @param string $title
	 * @return $this
	 */
	public function title($title)
	{
		$this->title = $title;
		return $this;
	}

	/**
	 * Set item URL
	 * @param string $url
	 * @return $this
	 */
	public function url($url)
	{
		$this->url = $url;
		return $this;
	}

	/**
	 * Set item description
	 * @param string $description
	 * @return $this
	 */
	public function description($description)
	{
		$this->description = $description;
		return $this;
	}

	/**
	 * Set item category
	 * @param string $name   Category name
	 * @param string $domain Category URL
	 * @return $this
	 */
	public function category($name, $domain = null)
	{
		$this->categories[] = array($name, $domain);
		return $this;
	}

	/**
	 * Set GUID
	 * @param string $guid
	 * @param bool   $isPermalink
	 * @return $this
	 */
	public function guid($guid, $isPermalink = false)
	{
		$this->guid = $guid;
		$this->isPermalink = $isPermalink;
		return $this;
	}

	/**
	 * Set published date
	 * @param int $pubDate Unix timestamp
	 * @return $this
	 */
	public function pubDate($pubDate)
	{
		$this->pubDate = $pubDate;
		return $this;
	}

	/**
	 * Append item to the channel
	 * @param \Suin\RSSWriter\ChannelInterface $channel
	 * @return $this
	 */
	public function appendTo(ChannelInterface $channel)
	{
		$channel->addItem($this);
		return $this;
	}

    /**
     * Return XML object
     * @param \DOMNode $element
     */
	public function buildXML(DOMNode $element)
	{
        $doc = $element->ownerDocument;
        $element->appendChild($item = $doc->createElement('item'));
        $item->appendChild($doc->createElement('title', htmlentities($this->title)));
        $item->appendChild($doc->createElement('link', htmlentities($this->url)));
        $item->appendChild($doc->createElement('description', htmlentities($this->description)));

		foreach ( $this->categories as $category )
		{
            $categoryElement = $doc->createElement($doc->createElement('category', $category[0]));
            $item->appendChild($categoryElement);
			if (isset($category[1])) {
                $categoryElement->setAttribute('domain', $category[1]);
			}
		}

		if ( $this->guid )
		{
            $guid = $doc->createElement('guid', $this->guid);
            $item->appendChild($guid);
			if ($this->isPermalink){
				$guid->setAttribute('isPermaLink', 'true');
			}
		}

		if ( $this->pubDate !== null )
		{
            $item->appendChild($doc->createElement('pubDate', date(DATE_RSS, $this->pubDate)));
		}
        foreach($this->childs as $child) {
            $child->buildXML($item);
        }
	}

    /**
     * Add child element
     * @param $child
     * @return mixed
     */
    public function addChild(XmlElementInterface $child)
    {
        $this->childs[] = $child;
    }
}
