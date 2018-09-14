<?php

namespace Drupal\atomiumprofiler\DataProvider;

use Drupal\cfrop\DataProvider\DataProviderInterface;

/**
 * @CfrPlugin("atomiumFindTemplates", "atomium_find_templates()")
 */
class DataProvider_AtomiumFindTemplates implements DataProviderInterface {

  /**
   * @return array
   */
  public function getData() {
    return atomium_find_templates();
  }
}
