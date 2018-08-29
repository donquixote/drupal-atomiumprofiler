<?php

namespace Drupal\atomiumprofiler\ProfilingCase;

use Drupal\atomium\Attributes;

/**
 * @CfrPlugin("atomiumAttributesToString", "Atomium Attributes->__toString()")
 */
class ProfilingCase_AtomiumAttributesToString extends ProfilingCase_AtomiumBase {

  /**
   * Returns nothing.
   */
  public function run() {
    $original = new Attributes(['class' => ['xxx', 'yyy'], 'selected' => TRUE]);
    for ($i = 1000; $i > 0; --$i) {
      $attributes = clone $original;
      $attributes->__toString();
    }
  }
}

