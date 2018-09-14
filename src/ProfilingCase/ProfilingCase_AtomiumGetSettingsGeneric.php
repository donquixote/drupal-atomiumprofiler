<?php

namespace Drupal\atomiumprofiler\ProfilingCase;

use Drupal\atomiumprofiler\Implementation\AtomiumGetSettings\AtomiumGetSettingsInterface;
use Drupal\cfrprofiler\ProfilingCase\ProfilingCaseInterface;

class ProfilingCase_AtomiumGetSettingsGeneric implements ProfilingCaseInterface {

  /**
   * @var \Drupal\atomiumprofiler\Implementation\AtomiumGetSettings\AtomiumGetSettingsInterface
   */
  private $implementation;

  /**
   * @var string[]
   */
  private $keys;

  /**
   * @CfrPlugin("atomiumGetSettingsGeneric", "atomium_get_settings(*) generic")
   *
   * @param \Drupal\atomiumprofiler\Implementation\AtomiumGetSettings\AtomiumGetSettingsInterface $implementation
   *
   * @return self
   */
  public static function create(AtomiumGetSettingsInterface $implementation) {
    return new self(
      $implementation,
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
   * @param \Drupal\atomiumprofiler\Implementation\AtomiumGetSettings\AtomiumGetSettingsInterface $implementation
   * @param string[] $keys
   */
  public function __construct(AtomiumGetSettingsInterface $implementation, array $keys) {
    $this->implementation = $implementation;
    $this->keys = $keys;
  }

  /**
   * Clears static caches etc.
   *
   * This method does not count on profiling time.
   */
  public function reset() {
    // Reset nothing.
    $this->implementation->reset();
  }

  /**
   * No return value.
   */
  public function run() {
    foreach ($this->keys as $key) {
      $this->implementation->atomiumGetSettings($key);
    }
  }
}
