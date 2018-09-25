<?php

namespace Drupal\atomiumprofiler\DataProvider;

use Drupal\cfrop\DataProvider\DataProviderInterface;

/**
 * @CfrPlugin("theme_get_registry", "theme_get_registry()")
 */
class DataProvider_ThemeRegistry implements DataProviderInterface {

  /**
   * @return array
   */
  public function getData() {
    drupal_theme_rebuild();
    return theme_get_registry()['link'];
  }
}
