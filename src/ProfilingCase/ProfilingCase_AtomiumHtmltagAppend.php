<?php

namespace Drupal\atomiumprofiler\ProfilingCase;

use drupol\htmltag\Attribute\AttributeFactory;
use drupol\htmltag\Attributes\Attributes;
use drupol\htmltag\Attributes\AttributesFactory;

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

    $factory = new AttributeFactory();

    for ($i = 1000; $i > 0; --$i) {
      $attributes = new Attributes($factory,['class' => ['xxx', 'yyy']]);
      $attributes->append('class', ['zzz', 'yyy yy', ['zz']]);
      $attributes->append('selected', TRUE);
      $attributes->append('selected', ['aa', 'bb']);
      $attributes->append('class', 'xxx yyy');
      $attributes->render();
    }
  }
}

