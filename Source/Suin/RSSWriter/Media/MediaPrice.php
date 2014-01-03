<?php
namespace Suin\RSSWriter\Media;

use Suin\RSSWriter\XmlElementInterface;
use DOMNode;

/**
 * @author HugoPoi
 */
class MediaPrice implements XmlElementInterface
{
    private $type;
    private $price;
    private $currency;

    public function __construct($price, $currency, $type = null)
    {
        $this->price = $price;
        $this->type = $type;
        $this->currency = $currency;
    }

    /**
     * Price of the media object.
     * @param string $price
     * @return $this
     */
    public function price($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * Type of the price media object. It is an optional attribute.
     * @param string $type
     * @return $this
     */
    public function type($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Currency name of the price media object. (ex : EUR)
     * @param string $currency
     * @return $this
     */
    public function currency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * Return XML object
     * @param \DOMNode $element source element to append to
     */
    public function buildXML(DOMNode $element)
    {
        $element->appendChild(
            $content = $element->ownerDocument->createElementNS(MediaContent::MEDIA_NAMESPACE, 'media:price')
        );
        $content->setAttribute('price', htmlspecialchars($this->price));
        if($this->type != null) $content->setAttribute('type', htmlspecialchars($this->type));
        $content->setAttribute('currency', htmlspecialchars($this->currency));
    }
}
