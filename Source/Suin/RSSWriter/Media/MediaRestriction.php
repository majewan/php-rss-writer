<?php
namespace Suin\RSSWriter\Media;

use Suin\RSSWriter\XmlElementInterface;
use DOMNode;

/**
 * @author HugoPoi
 */
class MediaRestriction implements XmlElementInterface
{
    private $restriction;
    private $relationship;
    private $type;

    public function __construct($restriction,$relationship = null, $type = null)
    {
        $this->restriction = $restriction;
        $this->relationship = $relationship;
        $this->type = $type;
    }

    /**
     * Restriction credit of the media object. It is an optional attribute.
     * @param string $restriction
     * @return $this
     */
    public function restriction($restriction)
    {
        $this->restriction = $restriction;
        return $this;
    }

    /**
     * Relationship credit of the media object. It is an optional attribute.
     * @param string $relationship
     * @return $this
     */
    public function relationship($relationship)
    {
        $this->relationship = $relationship;
        return $this;
    }

    /**
     * Type name of the media object. It is an optional attribute.
     * @param string $type
     * @return $this
     */
    public function type($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Return XML object
     * @param \DOMNode $element source element to append to
     */
    public function buildXML(DOMNode $element)
    {
        $element->appendChild(
            $content = $element->ownerDocument->createElementNS(MediaContent::MEDIA_NAMESPACE, 'media:restriction', htmlspecialchars($this->restriction))
        );
        if($this->relationship != null) $content->setAttribute('relationship', htmlspecialchars($this->relationship));
        if($this->type != null) $content->setAttribute('type', htmlspecialchars($this->type));
    }
}
