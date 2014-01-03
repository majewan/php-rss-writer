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
        $element->appendChild(
            $element->ownerDocument->createElementNS(MediaContent::MEDIA_NAMESPACE, 'media:keywords', htmlspecialchars($this->keywords))
        );
    }
}
