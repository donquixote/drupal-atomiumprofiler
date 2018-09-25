<?php

namespace Drupal\atomiumprofiler\ProfilingCase;

use Drupal\cfrprofiler\ProfilingCase\ProfilingCaseInterface;

/**
 * @CfrPlugin("arraySumModuleList", "['template'] + module_list()")
 */
class ProfilingCase_ArraySumModuleList implements ProfilingCaseInterface {

  /**
   * Clears static caches etc.
   *
   * This method does not count on profiling time.
   */
  public function reset() {
    // TODO: Implement reset() method.
  }

  /**
   * No return value.
   *
   * @throws \Exception
   */
  public function run() {
    $ml = module_list();
    for ($i = 1000; $i > 0; --$i) {
      $arr = ['template'];
      $arr += $ml;
    }
  }
}
