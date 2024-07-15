<?php

namespace Drupal\cact_general\Plugin\SocialMediaLinks\Iconset;

use Drupal\social_media_links\Plugin\SocialMediaLinks\Iconset\FontAwesome;

/**
 * Provides 'cact social icons' iconset.
 *
 * @Iconset(
 *   id = "cactsocialicons",
 *   publisher = "Cact social icons",
 *   publisherUrl = "http://fontawesome.github.io/",
 *   downloadUrl = "http://fortawesome.github.io/Font-Awesome/",
 *   name = "Cact social icons",
 * )
 */
class CactSocialIcons extends FontAwesome {

  /**
   * {@inheritdoc}
   */
  public function getStyle() {
    return [
      'cact_social' => 'Cact social icons',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getIconElement($platform, $style) {

  }
}
