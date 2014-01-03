<?php
namespace Suin\RSSWriter\Media;

use Suin\RSSWriter\XmlElementInterface;
use DOMNode;

/**
 * @author HugoPoi
 */
class MediaCredit implements XmlElementInterface
{
    private $credit;
    private $role;
    private $scheme;

    public function __construct($credit,$role = null, $scheme = null)
    {
        $this->credit = $credit;
        $this->scheme = $scheme;
        $this->role = $role;
    }

    /**
     * Scheme credit of the media object. It is an optional attribute.
     * @param string $scheme
     * @return $this
     */
    public function scheme($scheme)
    {
        $this->scheme = $scheme;
        return $this;
    }

    /**
     * Role credit of the media object. It is an optional attribute.
     * @param string $role
     * @return $this
     */
    public function role($role)
    {
        $this->role = $role;
        return $this;
    }

    /**
     * Credit name of the media object. It is an optional attribute.
     * @param string $credit
     * @return $this
     */
    public function credit($credit)
    {
        $this->credit = $credit;
        return $this;
    }

    /**
     * Return XML object
     * @param \DOMNode $element source element to append to
     */
    public function buildXML(DOMNode $element)
    {
        $element->appendChild(
            $content = $element->ownerDocument->createElementNS(MediaContent::MEDIA_NAMESPACE, 'media:credit', htmlspecialchars($this->credit))
        );
        if($this->scheme != null) $content->setAttribute('scheme', htmlspecialchars($this->scheme));
        if($this->role != null) $content->setAttribute('role', htmlspecialchars($this->role));
    }
}
