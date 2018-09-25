<?php

namespace Drupal\atomiumprofiler\DataProvider;

use Drupal\atomiumprofiler\Configurator\Configurator_ThemeName;
use Drupal\cfrop\DataProvider\DataProviderInterface;
use Drupal\cfrreflection\Configurator\Configurator_CallbackMono;

/**
 * @CfrPlugin("atomiumFindTemplates", "atomium_find_templates()")
 */
class DataProvider_AtomiumRegistryForOtherTheme implements DataProviderInterface {

  /**
   * @var string
   */
  private $themeName;

  /**
   * @CfrPlugin("registryForOtherTheme", "_atomium_get_registry_from_other_theme(?)")
   *
   * @return \Drupal\cfrapi\Configurator\ConfiguratorInterface
   */
  public static function plugin() {
    return Configurator_CallbackMono::createFromClassName(
      self::class,
      new Configurator_ThemeName());
  }

  /**
   * @CfrPlugin("registryForAtomiumzero", "_atomium_get_registry_from_other_theme('atomiumzero')")
   *
   * @return \Drupal\cfrop\DataProvider\DataProviderInterface
   */
  public static function createForAtomiumzero() {
    return new self('atomiumzero');
  }

  /**
   * @param string $themeName
   */
  public function __construct($themeName) {
    $this->themeName = $themeName;
  }

  /**
   * @return array
   */
  public function getData() {
    include_once drupal_get_path('theme', 'atomium')
    . '/includes/registry.inc';
    $registry = \_atomium_get_registry_from_other_theme($this->themeName);
    return $registry['link'];
  }
}
