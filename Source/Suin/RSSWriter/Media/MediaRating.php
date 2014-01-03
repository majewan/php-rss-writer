<?php
namespace Suin\RSSWriter\Media;

use Suin\RSSWriter\XmlElementInterface;
use DOMNode;

/**
 * @author HugoPoi
 */
class MediaRating implements XmlElementInterface
{
    private $rating;

    public function __construct($rating)
    {
        $this->rating = $rating;
    }

    /**
     * Return XML object
     * @param \DOMNode $element source element to append to
     */
    public function buildXML(DOMNode $element)
    {
        $element->appendChild(
            $element->ownerDocument->createElementNS(MediaContent::MEDIA_NAMESPACE, 'media:rating', htmlspecialchars($this->rating))
        );
    }
}
