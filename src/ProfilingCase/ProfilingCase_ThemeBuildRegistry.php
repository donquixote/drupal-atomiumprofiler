<?php

namespace Drupal\atomiumprofiler\ProfilingCase;

use Drupal\cfrprofiler\ProfilingCase\ProfilingCaseInterface;

/**
 * @CfrPlugin("themeRegistryRebuild", "Theme registry rebuild")
 */
class ProfilingCase_ThemeBuildRegistry implements ProfilingCaseInterface {

  /**
   * Clears static caches etc.
   *
   * This method does not count on profiling time.
   */
  public function reset() {
    drupal_theme_rebuild();
  }

  /**
   * No return value.
   *
   * @throws \Exception
   */
  public function run() {
    theme_get_registry();
  }
}
