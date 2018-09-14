<?php

namespace Drupal\atomiumprofiler\ProfilingCase;

use Drupal\cfrprofiler\ProfilingCase\ProfilingCaseInterface;

/**
 * @CfrPlugin("atomiumGetSettings2", "atomium_get_settings(*)")
 */
class ProfilingCase_AtomiumGetSettingsCustom1 implements ProfilingCaseInterface {

  /**
   * @var string[]
   */
  private $keys;

  /**
   * @return self
   */
  public static function create() {
    return new self(
      [
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
      ]);
  }

  /**
   * Constructor.
   *
   * @param string[] $keys
   */
  public function __construct(array $keys) {
    require_once drupal_get_path('theme', 'atomium') . '/includes/common.inc';
    $this->keys = $keys;
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
    foreach ($this->keys as $key) {
      atomium_get_settings($key);
    }
  }
}
