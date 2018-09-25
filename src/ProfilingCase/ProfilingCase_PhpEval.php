<?php

namespace Drupal\atomiumprofiler\ProfilingCase;

use Drupal\atomiumprofiler\Configurator\Configurator_CustomPhp;
use Drupal\cfrapi\Configurator\Configurator_IntegerInRange;
use Drupal\cfrprofiler\ProfilingCase\ProfilingCaseInterface;
use Drupal\cfrreflection\Configurator\Configurator_CallbackConfigurable;

class ProfilingCase_PhpEval implements ProfilingCaseInterface {

  /**
   * @var string
   */
  private $php;

  /**
   * @var string|null
   */
  private $phpReset;

  /**
   * @CfrPlugin("evalRepeated", "PHP eval() repeated")
   *
   * @return \Drupal\cfrapi\Configurator\ConfiguratorInterface
   */
  public static function pluginRepeated() {
    return Configurator_CallbackConfigurable::createFromClassStaticMethod(
      self::class,
      'createRepeated',
      [
        new Configurator_IntegerInRange(1),
        (new Configurator_CustomPhp())
          ->withRows(10),
        new Configurator_CustomPhp(FALSE),
      ],
      [
        t('Number of repetitions'),
        t('PHP code to repeat for profiling.'),
        t('Optional PHP code for reset() method.')
      ]);
  }

  /**
   * @param int $nRepetitions
   * @param string $php
   * @param string|null $resetPhp
   *
   * @return \Drupal\atomiumprofiler\ProfilingCase\ProfilingCase_PhpEval
   * @throws \Exception
   */
  public static function createRepeated($nRepetitions, $php, $resetPhp = NULL) {
    if (!is_int($nRepetitions)) {
      throw new \Exception("Number of repetitions must be integer.");
    }
    $php = str_replace("\n", "\n  ", $php);
    $php = <<<EOT
for (\$i = $nRepetitions; \$i > 0; --\$i) {
  $php
} 
EOT;

    $case = new self($php);
    if ($resetPhp !== NULL) {
      $case = $case->withResetPhp($resetPhp);
    }
    return $case;
  }

  /**
   * @CfrPlugin("eval", "PHP eval()")
   *
   * @return \Drupal\cfrapi\Configurator\ConfiguratorInterface
   */
  public static function plugin() {
    return Configurator_CallbackConfigurable::createFromClassStaticMethod(
      self::class,
      'create',
      [
        (new Configurator_CustomPhp())
          ->withRows(10),
        new Configurator_CustomPhp(FALSE),
      ],
      [
        t('PHP code to profile.'),
        t('Optional PHP code for reset() method.')
      ]);
  }

  /**
   * @param string $php
   * @param string|null $resetPhp
   *
   * @return self
   */
  public static function create($php, $resetPhp = NULL) {
    $case = new self($php);
    if ($resetPhp !== NULL) {
      $case = $case->withResetPhp($resetPhp);
    }
    return $case;
  }

  /**
   * @param string $php
   */
  public function __construct($php) {
    $this->php = $php;
  }

  /**
   * @param string $phpReset
   *
   * @return static
   */
  public function withResetPhp($phpReset) {
    $clone = clone $this;
    $clone->phpReset = $phpReset;
    return $clone;
  }

  /**
   * Clears static caches etc.
   *
   * This method does not count on profiling time.
   */
  public function reset() {
    if (NULL === $this->phpReset) {
      return;
    }
    eval($this->phpReset);
  }

  /**
   * No return value.
   *
   * @throws \Exception
   */
  public function run() {
    eval($this->php);
  }
}
