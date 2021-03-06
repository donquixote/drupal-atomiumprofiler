<?php

namespace Drupal\atomiumprofiler\ProfilingCase;

use Drupal\cfrprofiler\ProfilingCase\ProfilingCaseInterface;

/**
 * @CfrPlugin("atomiumGetSettings2", "atomium_get_settings(*)")
 */
class ProfilingCase_AtomiumGetSettings2 implements ProfilingCaseInterface {

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
    // This sequence of keys were taken from an example site.
    foreach ([
      'preprocess.block.classes_to_remove',
      'preprocess.region.classes_to_remove',
      'preprocess.node.classes_to_remove',
      'preprocess.node.classes_to_remove',
      'preprocess.node.classes_to_remove',
      'preprocess.node.classes_to_remove',
      'preprocess.node.classes_to_remove',
      'preprocess.node.classes_to_remove',
      'preprocess.node.classes_to_remove',
      'preprocess.node.classes_to_remove',
      'preprocess.node.classes_to_remove',
      'preprocess.node.classes_to_remove',
      'preprocess.node.classes_to_remove',
      'preprocess.node.classes_to_remove',
      'preprocess.node.classes_to_remove',
      'preprocess.node.classes_to_remove',
      'preprocess.block.classes_to_remove',
      'preprocess.region.classes_to_remove',
      'preprocess.html.classes_to_remove',
      'preprocess.region.classes_to_remove',
      'alter.css_alter.exclude',
      'preprocess.node.classes_to_remove',
    ] as $key) {
      atomium_get_settings($key);
    }
  }
}
