<?php

namespace Drupal\atomiumprofiler\ProfilingCase;

use Drupal\atomium\htmltag\Attributes\AttributesFactory;

/**
 * @CfrPlugin("atomiumHtmltagAppendExample2", "Atomium htmltag Attributes->append()")
 */
class ProfilingCase_AtomiumHtmltagAppend extends ProfilingCase_AtomiumBase {

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
    $original = AttributesFactory::build(['class' => ['xxx', 'yyy']]);

    for ($i = 1000; $i > 0; --$i) {
      $attributes = clone $original;
      $attributes->append('class', ['zzz', 'yyy yy', ['zz']]);
      $attributes->append('selected', TRUE);
      $attributes->append('selected', ['aa', 'bb']);
      $attributes->append('class', 'xxx yyy');
    }
  }
}

