<?php
namespace Suin\RSSWriter\Media;

use Suin\RSSWriter\XmlElementInterface;
use DOMNode;

/**
 * @author HugoPoi
 */
class MediaCategory implements XmlElementInterface
{
    private $category;
    private $scheme;

    public function __construct($category, $scheme = null)
    {
        $this->category = $category;
        $this->scheme = $scheme;
    }

    /**
     * Scheme category of the media object. It is an optional attribute.
     * @param string $scheme
     * @return $this
     */
    public function scheme($scheme)
    {
        $this->scheme = $scheme;
        return $this;
    }

    /**
     * Return XML object
     * @param \DOMNode $element source element to append to
     */
    public function buildXML(DOMNode $element)
    {
        $element->appendChild(
            $content = $element->ownerDocument->createElementNS(MediaContent::MEDIA_NAMESPACE, 'media:category', htmlspecialchars($this->category))
        );
        if($this->scheme != null) $content->setAttribute('scheme', htmlspecialchars($this->scheme));
    }
}
