<?php

namespace Drupal\atomiumprofiler\ProfilingCase;

use Drupal\cfrprofiler\ProfilingCase\ProfilingCaseInterface;

/**
 * @CfrPlugin("atomiumFindTemplates", "atomium_find_templates()")
 */
class ProfilingCase_AtomiumFindTemplates implements ProfilingCaseInterface {

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
    for ($i = 0; $i < 100; ++$i) {
      atomium_find_templates();
    }
  }
}
