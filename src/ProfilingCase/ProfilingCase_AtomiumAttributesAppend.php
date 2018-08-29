<?php

namespace Drupal\atomiumprofiler\ProfilingCase;

use Drupal\atomium\Attributes;
use Drupal\cfrprofiler\ProfilingCase\ProfilingCaseInterface;

class ProfilingCase_AtomiumAttributesAppend implements ProfilingCaseInterface {

  /**
   * @var \Drupal\atomium\Attributes
   */
  private $original;

  /**
   * @var string
   */
  private $appendName;

  /**
   * @var array|bool|string
   */
  private $appendValue;

  /**
   * @CfrPlugin("atomiumAttributesAppendExample", "Atomium Attributes->append() example")
   *
   * @return self
   */
  public static function example() {
    return self::create(
      ['class' => ['aaa', 'bbb']],
      'class',
      ['ccc', 'ddd']);
  }

  /**
   * @param array $original
   * @param string $append_name
   * @param array|bool|string $append_value
   *
   * @return self
   */
  public static function create(array $original, $append_name, $append_value) {
    require_once drupal_get_path('theme', 'atomium') . '/includes/classes/Attributes.php';
    return new self(
      new Attributes($original),
      $append_name,
      $append_value);
  }

  /**
   * @param \Drupal\atomium\Attributes $original
   * @param string $append_name
   * @param array|bool|string $append_value
   */
  private function __construct(Attributes $original, $append_name, $append_value) {
    $this->original = $original;
    $this->appendName = $append_name;
    $this->appendValue = $append_value;
  }

  /**
   * Returns nothing.
   */
  public function run() {
    for ($i = 10000; $i > 0; --$i) {
      $attributes = clone $this->original;
      $attributes->append($this->appendName, $this->appendValue);
    }
  }
}

