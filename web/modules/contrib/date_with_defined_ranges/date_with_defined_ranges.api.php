<?php

/**
 * @file
 * Hooks provided by the date_with_defined_ranges module.
 */

/**
 * @addtogroup hooks
 * @{
 */


/**
 * This hook alters list of date time ranges.
 *
 * @param array $output
 *   List of id => label time ranges.
 */
function hook_date_custom_ranges_list_alter(array &$output) {
  $output['custom_range'] = t('This is custom range label');
}

/**
 * This hook alters effect of range calculation.
 *
 * @param array $output
 *   List of id => label time ranges.
 * @param string $range
 *   Machine name of range.
 */
function hook_date_custom_ranges_calculate_alter(array &$output, $range) {
  if ($range == 'custom_range') {
    $now = time();
    $date_min = DrupalDateTime::createFromTimestamp($now);
    $date_max = DrupalDateTime::createFromTimestamp($now);
    $output['max'] = $date_min->modify('-2 years')->format('U');
    $output['min'] = $date_max->modify('-6 years')->format('U');
  }
}

/**
 * @} End of "addtogroup hooks".
 */
