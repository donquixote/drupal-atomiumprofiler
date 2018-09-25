<?php

namespace Drupal\atomiumprofiler\ProfilingCase;

use Drupal\atomium\Attributes;

/**
 * @CfrPlugin("atomiumAttributesAppendExample2", "Atomium Attributes->append() case 2")
 */
class ProfilingCase_AtomiumAttributesAppend2 extends ProfilingCase_AtomiumBase {

  /**
   * Clears static caches etc.
   *
   * This method does not count on profiling time.
   */
  public function reset() {
    // Reset nothing.
  }

  /**
   * Returns nothing.
   */
  public function run() {
    for ($i = 1000; $i > 0; --$i) {
      $attributes = new Attributes(['class' => ['xxx', 'yyy']]);
      $attributes->append('class', ['zzz', 'yyy yy', ['zz']]);
      $attributes->append('selected', TRUE);
      $attributes->append('selected', ['aa', 'bb']);
      $attributes->append('class', 'xxx yyy');
      $attributes->__toString();
    }
  }
}

