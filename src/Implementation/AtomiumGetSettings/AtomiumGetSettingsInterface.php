<?php

namespace Drupal\atomiumprofiler\Implementation\AtomiumGetSettings;

/**
 * @see \atomium_get_settings()
 */
interface AtomiumGetSettingsInterface {

  /**
   * Clears static caches etc.
   */
  public function reset();

  /**
   * Get settings from the current theme info file.
   *
   * @param string $setting_keys
   *   The settings to get, flattened (concatenated with ".")
   * @param bool $base_themes
   *   TRUE to get the value in the base_themes
   *   if the settings is not found in current theme,
   *   FALSE otherwise.
   * @param array $value_callbacks
   *   The list of callbacks to apply to retrieved values.
   *
   * @return array
   *   The settings as an array.
   */
  public function atomiumGetSettings($setting_keys, $base_themes = TRUE, array $value_callbacks = array('trim'));

}
