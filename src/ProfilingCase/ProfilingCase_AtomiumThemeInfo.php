<?php

namespace Drupal\atomiumprofiler\ProfilingCase;

use Drupal\cfrprofiler\ProfilingCase\ProfilingCaseInterface;

/**
 * @CfrPlugin("atomiumThemeInfo", "atomium_get_theme_info()")
 */
class ProfilingCase_AtomiumThemeInfo implements ProfilingCaseInterface {

  /**
   * Constructor.
   */
  public function __construct() {
    require_once drupal_get_path('theme', 'atomium') . '/includes/common.inc';
  }

  /**
   * Clears static caches etc.
   *
   * This method does not count on profiling time.
   */
  public function reset() {
    // Reset nothing.
  }

  /**
   * No return value.
   */
  public function run() {
    for ($i = 100; $i > 0; --$i) {
      atomium_get_theme_info();
    }
  }
}
