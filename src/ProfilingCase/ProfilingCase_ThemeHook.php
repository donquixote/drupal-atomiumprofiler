<?php

namespace Drupal\atomiumprofiler\ProfilingCase;

use Drupal\cfrprofiler\ProfilingCase\ProfilingCaseInterface;

class ProfilingCase_ThemeHook implements ProfilingCaseInterface {

  /**
   * @var string
   */
  private $hook;

  /**
   * @var array
   */
  private $variables;

  /**
   * @CfrPlugin(
   *   "atomiumprofiler_example_with_element",
   *   "theme('atomiumprofiler_example_with_element', *)"
   * )
   *
   * @return self
   */
  public static function exampleWithElement() {
    return new self(
      /* @see theme_atomiumprofiler_example_with_element() */
      'atomiumprofiler_example_with_element',
      ['element' => []]);
  }

  /**
   * @CfrPlugin(
   *   "atomiumprofiler_example_with_variables",
   *   "theme('atomiumprofiler_example_with_variables', *)"
   * )
   *
   * @return self
   */
  public static function exampleWithVariables() {
    return new self(
      /* @see theme_atomiumprofiler_example_with_variables() */
      'atomiumprofiler_example_with_variables',
      ['text' => 'hello']);
  }

  /**
   * @CfrPlugin(
   *   "atomiumprofiler_example_minimal",
   *   "theme('atomiumprofiler_example_minimal', *)"
   * )
   *
   * @return self
   */
  public static function exampleMinimal() {
    return new self(
      /* @see theme_atomiumprofiler_example_minimal() */
      'atomiumprofiler_example_minimal',
      []);
  }

  /**
   * @param string $hook
   * @param array $variables
   */
  public function __construct($hook, array $variables) {
    $this->hook = $hook;
    $this->variables = $variables;
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
   *
   * @throws \Exception
   */
  public function run() {
    for ($i = 10000; $i > 0; --$i) {
      theme($this->hook, $this->variables);
    }
  }
}
