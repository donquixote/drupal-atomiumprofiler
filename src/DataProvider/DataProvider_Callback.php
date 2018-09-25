<?php

namespace Drupal\atomiumprofiler\DataProvider;

use Drupal\cfrop\DataProvider\DataProviderInterface;

class DataProvider_Callback implements DataProviderInterface {

  /**
   * @var callable
   */
  private $callback;

  /**
   * @var array
   */
  private $args;

  /**
   * @CfrPlugin("callback_theme_registry_callback", "Callback: _theme_registry_callback()")
   *
   * @return \Drupal\atomiumprofiler\DataProvider\DataProvider_Callback
   */
  public static function themeRegistryCallback() {
    /* @see \_theme_registry_callback() */
    return new self('\_theme_registry_callback');
  }

  /**
   * @param callable $callback
   * @param array $args
   */
  public function __construct(callable $callback, array $args = []) {
    $this->callback = $callback;
    $this->args = $args;
  }

  /**
   * @return mixed
   */
  public function getData() {
    return \call_user_func_array($this->callback, $this->args);
  }
}
