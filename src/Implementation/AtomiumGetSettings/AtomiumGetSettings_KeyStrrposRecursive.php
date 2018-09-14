<?php

namespace Drupal\atomiumprofiler\Implementation\AtomiumGetSettings;

/**
 * @CfrPlugin("keyStrrposRecursive", "strrpos() recursive")
 */
class AtomiumGetSettings_KeyStrrposRecursive implements AtomiumGetSettingsInterface {

  /**
   * @var array[]
   */
  private $settingsFilteredByCid = [];

  /**
   * @var mixed[]
   */
  private $settingsUnfilteredByCid = [];

  /**
   * Clears static caches etc.
   */
  public function reset() {
    $this->settingsFilteredByCid = [];
    $this->settingsUnfilteredByCid = [];
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
    $cid = $theme_key . ':' . $setting_keys;

    if ($base_themes) {
      $cid .= '(b)';
    }

    if ([] === $value_callbacks) {
      $cid .= '()';
    }
    elseif (['trim'] === $value_callbacks) {
      $cid .= '(t)';
    }
    else {
      // Don't cache. There could be closures in $value_callbacks.
      return $this->_atomium_do_get_settings($setting_keys, $base_themes, $value_callbacks);
    }

    if (isset($this->settingsFilteredByCid[$cid])) {
      return $this->settingsFilteredByCid[$cid];
    }

    return $this->settingsFilteredByCid[$cid] = $this->_atomium_do_get_settings(
      $setting_keys,
      $base_themes,
      $value_callbacks);
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
  function _atomium_do_get_settings($setting_keys, $base_themes = TRUE, array $value_callbacks = ['trim']) {

    $value = $this->_atomium_get_settings_unfiltered($setting_keys, $base_themes);

    $empty_string_value = '';
    $empty_string_value_empty = TRUE;
    if ([] !== $value_callbacks && ['trim'] !== $value_callbacks) {
      // Let's see what our value callbacks do to the empty string.
      foreach ($value_callbacks as $value_callback) {
        $empty_string_value = $value_callback($empty_string_value);
      }
      $empty_string_value_empty = empty($empty_string_value);
    }

    if ([] === $value || NULL === $value) {
      return [];
    }

    if ('' === $value) {
      return $empty_string_value_empty
        ? []
        : [$empty_string_value];
    }

    if (\is_string($value)) {
      $value = explode(',', $value);
    }
    elseif (\is_array($value)) {
      // Leave as is.
    }
    else {
      return [];
    }

    foreach ($value_callbacks as $value_callback) {
      $value = array_map($value_callback, $value);
    }

    return array_values(array_filter($value));
  }

  /**
   * @param string $setting_keys
   * @param bool $base_themes
   * @param mixed $else
   *
   * @return array
   */
  function _atomium_get_settings_unfiltered($setting_keys, $base_themes = TRUE, $else = []) {
    $theme_key = $GLOBALS['theme_key'];

    $cid = $theme_key;
    if ($base_themes) {
      $cid .= '(b)';
    }

    if (!isset($this->settingsUnfilteredByCid[$cid])) {
      $this->settingsUnfilteredByCid[$cid] = atomium_get_theme_info($theme_key, 'settings', $base_themes) ?: [];
    }

    if (isset($this->settingsUnfilteredByCid[$cid][$setting_keys])) {
      return $this->settingsUnfilteredByCid[$cid][$setting_keys];
    }

    if ([] === $this->settingsUnfilteredByCid[$cid]) {
      return $this->settingsUnfilteredByCid[$cid][$setting_keys] = $else;
    }

    if (FALSE === $pos = strrpos($setting_keys, '.')) {
      return $this->settingsUnfilteredByCid[$cid][$setting_keys] = $else;
    }

    $prefix = substr($setting_keys, 0, $pos);
    $suffix = substr($setting_keys, $pos + 1);
    $prefix_settings = $this->_atomium_get_settings_unfiltered($prefix, $base_themes);

    if (!isset($prefix_settings[$suffix])) {
      return $this->settingsUnfilteredByCid[$cid][$setting_keys] = $else;
    }

    return $this->settingsUnfilteredByCid[$cid][$setting_keys] = $prefix_settings[$suffix];
  }
}
