<?php
namespace Suin\RSSWriter\Media;

use Suin\RSSWriter\XmlElementInterface;
use DOMNode;

/**
 * @author HugoPoi
 */
class MediaKeywords implements XmlElementInterface
{
    private $keywords;
    public $_item;

    public function __construct($keywords)
    {
        $this->keywords = $keywords;
    }

    /**
     * Return XML object
     * @param \DOMNode $element source element to append to
     */
    public function buildXML(DOMNode $element)
    {
        $element->appendChild($mediaKeywords = 
            $element->ownerDocument->createElementNS(MediaContent::MEDIA_NAMESPACE, 'media:keywords')
        );

        if($this->_item->_channel->_feed->escapeTextWithCDATA){
          $mediaKeywords->appendChild(new \DOMCdataSection(htmlspecialchars($this->keywords)));
        }else{
          $mediaKeywords->appendChild(new \DOMText(htmlspecialchars($this->keywords)));
        }
    }
}
