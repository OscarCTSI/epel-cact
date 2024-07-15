<?php

/**
 * @file
 */

use Drupal\date_with_defined_ranges\DateWithCustomRanges;

/**
 * Implements hook_views_plugins_filter_alter().
 */
function date_with_defined_ranges_views_plugins_filter_alter(&$info) {
  $info['date']['class'] = DateWithCustomRanges::class;
  if (isset($info['datetime'])) {
    $info['datetime']['class'] = DateWithCustomRanges::class;
  }
}
