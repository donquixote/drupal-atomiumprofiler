<?php

namespace Drupal\atomiumprofiler\ProfilingCase;

use Drupal\cfrprofiler\ProfilingCase\ProfilingCaseInterface;

class ProfilingCase_RenderElement implements ProfilingCaseInterface {

  /**
   * @var array
   */
  private $element;

  /**
   * @CfrPlugin("renderRegion", "drupal_render(..'region'..)")
   *
   * @return self
   */
  public static function createRegion() {
    return new self(
      [
        '#theme_wrappers' => ['region'],
        '#region' => '__n_a__',
        '#children' => 'Region content',
      ]);
  }

  /**
   * @param array $element
   */
  public function __construct(array $element) {
    $this->element = $element;
  }

  /**
   * Clears static caches etc.
   *
   * This method does not count on profiling time.
   */
  public function reset() {
    // Nothing.
  }

  /**
   * No return value.
   *
   * @throws \Exception
   */
  public function run() {

    for ($i = 10; $i > 0; --$i) {
      // Clone the array.
      $element = $this->element;
      drupal_render($element);
    }
  }
}
