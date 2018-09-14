<?php

namespace Drupal\atomiumprofiler\ProfilingCase;

use Drupal\cfrprofiler\ProfilingCase\ProfilingCaseInterface;

/**
 * @CfrPlugin("link", "Link")
 */
class ProfilingCase_Link implements ProfilingCaseInterface {

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
      l('Blocks', 'admin/structure/block');
    }
  }
}
