<?php

namespace Drupal\atomiumprofiler\Implementation\AtomiumGetSettings;

/**
 * @CfrPlugin("v_3_0", "Atomium native, as in version 3.0")
 */
class AtomiumGetSettings_3_0 implements AtomiumGetSettingsInterface {

  /**
   * Clears static caches etc.
   */
  public function reset() {
    // TODO: Implement reset() method.
  }

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
  public function atomiumGetSettings($setting_keys, $base_themes = TRUE, array $value_callbacks = ['trim']) {
    $theme_key = $GLOBALS['theme_key'];

    $settings = array();

    if ($theme_settings = atomium_get_theme_info($theme_key, 'settings', $base_themes)) {
      _atomium_array_flatten(
        $theme_settings,
        $settings
      );
    }

    $setting_value = array();

    if (isset($settings[$setting_keys])) {
      if (\is_string($settings[$setting_keys])) {
        $setting_value = explode(',', $settings[$setting_keys]);
      }

      if (\is_array($settings[$setting_keys])) {
        $setting_value = $settings[$setting_keys];
      }

      foreach ($value_callbacks as $value_callback) {
        $setting_value = array_map($value_callback, $setting_value);
      }
    }

    return array_values(array_filter($setting_value));
  }
}
