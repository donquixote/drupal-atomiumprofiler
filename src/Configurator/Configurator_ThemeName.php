<?php

namespace Drupal\atomiumprofiler\Configurator;

use Drupal\cfrapi\Configurator\Id\Configurator_SelectBase;

class Configurator_ThemeName extends Configurator_SelectBase {

  /**
   * @return string[]
   */
  protected function getSelectOptions() {

    $options = [];
    foreach (list_themes() as $theme_name => $theme_object) {
      if (!$theme_object->status) {
        continue;
      }
      $options[$theme_name] = $theme_object->info['name'];
    }

    return $options;
  }

  /**
   * @param string $id
   *
   * @return string|null
   */
  protected function idGetLabel($id) {
    $theme_objects = list_themes();
    if (!isset($theme_objects[$id])) {
      return NULL;
    }
    if (!isset($theme_objects[$id]->info['name'])) {
      return $id;
    }
    return $theme_objects[$id]->info['name'];
  }

  /**
   * @param string $id
   *
   * @return bool
   */
  protected function idIsKnown($id) {
    $theme_objects = list_themes();
    return isset($theme_objects[$id]);
  }
}
