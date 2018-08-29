<?php

namespace Drupal\atomiumprofiler\ProfilingCase;

use Drupal\atomium\Attributes;

/**
 * @CfrPlugin("atomiumAttributesAppendExample2", "Atomium Attributes->append() case 2")
 */
class ProfilingCase_AtomiumAttributesAppend2 extends ProfilingCase_AtomiumBase {

  /**
   * Returns nothing.
   */
  public function run() {
    $original = new Attributes(['class' => ['xxx', 'yyy']]);
    for ($i = 1000; $i > 0; --$i) {
      $attributes = clone $original;
      $attributes->append('class', ['zzz', 'yyy yy', ['zz']]);
      $attributes->append('selected', TRUE);
      $attributes->append('selected', ['aa', 'bb']);
      $attributes->append('class', 'xxx yyy');
    }
  }
}

