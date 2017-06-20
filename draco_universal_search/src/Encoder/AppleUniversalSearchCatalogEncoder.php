<?php

namespace Drupal\draco_universal_search\Encoder;

use Drupal\serialization\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder as BaseXmlEncoder;

/**
 * Apple Universal Search catalog fee encoder.
 *
 * Generates the XML for the Universal Search XML feed. The
 * AppleUniversalSearchNormalizer will normalize to the expected format of
 * core's XMLEncoder. We just extend it to override the Symfony XmlEncoder
 * used so we can control the root element.
 */
class AppleUniversalSearchCatalogEncoder extends XmlEncoder {

  /**
   * The format that this encoder supports.
   *
   * @var string
   */
  protected static $format = ['apple_us_catalog'];

  /**
   * Create a Apple Universal Search Encoder.
   */
  public function __construct() {
    $this->setBaseEncoder(new BaseXmlEncoder('umcCatalog'));
  }

  /**
   * {@inheritdoc}
   */
  public function supportsDecoding($format) {
    return FALSE;
  }

}
