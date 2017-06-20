<?php

namespace Drupal\draco_universal_search\Encoder;

use Drupal\serialization\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder as BaseXmlEncoder;

/**
 * Roku Universal Search encoder.
 *
 * Generates the XML for the Universal Search XML feed. The
 * RokuUniversalSearchNormalizer will normalize to the expected format
 * of core's XmlEncoder. We just extend it to override the Symfony XmlEncoder
 * used so we can control the root element.
 */
class RokuUniversalSearchEncoder extends XmlEncoder {

  /**
   * The format that this encoder supports.
   *
   * @var string
   */
  protected static $format = ['roku_us'];

  /**
   * Create a Roku Universal Search Encoder.
   */
  public function __construct() {
    $this->setBaseEncoder(new BaseXmlEncoder('partnerContent'));
  }

  /**
   * {@inheritdoc}
   */
  public function supportsDecoding($format) {
    return FALSE;
  }

}
