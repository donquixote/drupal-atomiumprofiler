<?php

namespace Drupal\atomiumprofiler\DataProvider;

use Drupal\cfrop\DataProvider\DataProviderInterface;

/**
 * @CfrPlugin("atomiumThemelessRegistry", "atomium_themeless_registry()")
 */
class DataProvider_AtomiumThemelessRegistry implements DataProviderInterface {

  /**
   * @return array
   */
  public function getData() {
    include_once drupal_get_path('theme', 'atomium')
    . '/includes/registry.inc';
    $registry = \_atomium_load_themeless_registry();
    return $registry['link'];
  }
}
