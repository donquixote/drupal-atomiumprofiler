<?php

namespace Drupal\atomiumprofiler\DataProvider;

use Drupal\cfrop\DataProvider\DataProviderInterface;

class DataProvider_AtomiumGetSettings implements DataProviderInterface {

  /**
   * @var string
   */
  private $key;

  /**
   * @CfrPlugin("atomiumGetSettingsExample", "atomium_get_settings() example")
   *
   * @return self
   */
  public static function blockSettings() {
    return new self('preprocess.block.classes_to_remove');
  }

  /**
   * @param string $key
   */
  public function __construct($key) {
    $this->key = $key;
  }

  /**
   * @return mixed
   */
  public function getData() {
    return atomium_get_settings($this->key);
  }
}
