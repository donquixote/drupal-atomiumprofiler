<?php

namespace Drupal\atomiumprofiler\Configurator;

use Drupal\cfrapi\CfrCodegenHelper\CfrCodegenHelperInterface;
use Drupal\cfrapi\Configurator\ConfiguratorInterface;
use Drupal\cfrapi\SummaryBuilder\SummaryBuilderInterface;

class Configurator_CustomPhp implements ConfiguratorInterface {

  /**
   * @var bool
   */
  private $required;

  private $elementDefaults = [];

  /**
   * @param bool $required
   */
  public function __construct($required = TRUE) {
    $this->required = $required;
  }

  /**
   * @param int $nRows
   * @param int $nColumns
   *
   * @return static
   */
  public function withDimensions($nRows, $nColumns) {
    $clone = clone $this;
    $clone->elementDefaults['#rows'] = $nRows;
    $clone->elementDefaults['#cols'] = $nColumns;
    return $clone;
  }

  /**
   * @param int $nRows
   *
   * @return static
   */
  public function withRows($nRows) {
    $clone = clone $this;
    $clone->elementDefaults['#rows'] = $nRows;
    return $clone;
  }

  /**
   * @param int $nCols
   *
   * @return static
   */
  public function withCols($nCols) {
    $clone = clone $this;
    $clone->elementDefaults['#cols'] = $nCols;
    return $clone;
  }

  /**
   * @param mixed $conf
   *   Configuration from a form, config file or storage.
   * @param string|null $label
   *   Label for the form element, specifying the purpose where it is used.
   *
   * @return array
   */
  public function confGetForm($conf, $label) {

    if (!\is_string($conf)) {
      $conf = NULL;
    }

    return [
      /* @see \theme_textarea() */
      '#type' => 'textarea',
      '#title' => $label,
      '#default_value' => $conf,
      '#required' => $this->required,
    ] + $this->elementDefaults;
  }

  /**
   * @param mixed $conf
   *   Configuration from a form, config file or storage.
   * @param \Drupal\cfrapi\SummaryBuilder\SummaryBuilderInterface $summaryBuilder
   *   An object that controls the format of the summary.
   *
   * @return mixed|string|null
   *   A string summary is always allowed. But other values may be returned if
   *   $summaryBuilder generates them.
   */
  public function confGetSummary($conf, SummaryBuilderInterface $summaryBuilder) {

    if (NULL === $conf || '' === $conf || !\is_string($conf)) {
      if ($this->required) {
        return t('Missing value');
      }

      return 'NULL';
    }

    if (\strlen($conf) > 30) {
      $conf = substr($conf, 0, 27) . '[..]';
    }

    return check_plain(var_export($conf, TRUE));
  }

  /**
   * @param mixed $conf
   *   Configuration from a form, config file or storage.
   *
   * @return mixed
   *   Value to be used in the application.
   */
  public function confGetValue($conf) {
    if (!\is_string($conf) || '' === $conf) {
      return NULL;
    }
    return $conf;
  }

  /**
   * @param mixed $conf
   *   Configuration from a form, config file or storage.
   * @param \Drupal\cfrapi\CfrCodegenHelper\CfrCodegenHelperInterface $helper
   *
   * @return string
   *   PHP statement to generate the value.
   */
  public function confGetPhp($conf, CfrCodegenHelperInterface $helper) {
    if (!\is_string($conf) || '' === $conf) {
      return 'NULL';
    }
    return var_export($conf, TRUE);
  }
}
