<?php

namespace Suin\RSSWriter;

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

  public $_channel;

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
		$channel->addChild($this);
    $this->_channel = $channel;
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
        $item->appendChild($title = $doc->createElement('title'));
        $item->appendChild($doc->createElement('link', htmlspecialchars($this->url)));
        $item->appendChild($description = $doc->createElement('description'));

        if($this->_channel->_feed->escapeTextWithCDATA){
          $title->appendChild(new \DOMCdataSection(htmlspecialchars($this->title)));
          $description->appendChild(new \DOMCdataSection(htmlspecialchars($this->description)));
        }else{
          $title->appendChild(new \DOMText(htmlspecialchars($this->title)));
          $description->appendChild(new \DOMText(htmlspecialchars($this->description)));
        }

		foreach ( $this->categories as $category )
		{
            $item->appendChild($categoryElement = $doc->createElement('category', $category[0]));
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
        $child->_item = $this;
    }
}
