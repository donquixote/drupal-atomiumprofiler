<?php

namespace Drupal\atomiumprofiler\Implementation\AtomiumGetSettings;

/**
 * @CfrPlugin("staticCache2", "static cache 2")
 */
class AtomiumGetSettings_StaticCache2 implements AtomiumGetSettingsInterface {

  /**
   * @var array[]
   */
  private $settings_flat_filtered_by_cid = [];

  /**
   * @var mixed[]
   */
  private $settings_flat_by_cid = [];

  /**
   * Clears static caches etc.
   */
  public function reset() {
    $this->settings_flat_filtered_by_cid = [];
    $this->settings_flat_by_cid = [];
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
    $settings_flat_filtered = $this->_atomium_get_settings_flat_filtered($theme_key, $base_themes, $value_callbacks);

    return isset($settings_flat_filtered[$setting_keys])
      ? $settings_flat_filtered[$setting_keys]
      : [];
  }

  /**
   * @param string $theme_key
   * @param bool $base_themes
   * @param callable[] $value_callbacks
   *
   * @return mixed
   */
  function _atomium_get_settings_flat_filtered($theme_key, $base_themes = TRUE, $value_callbacks = ['trim']) {
    $cid = $theme_key;
    if ($base_themes) {
      $cid .= '(b)';
    }
    if ([] === $value_callbacks) {
      $trim = FALSE;
    }
    elseif (['trim'] === $value_callbacks) {
      $trim = TRUE;
      $cid .= '(t)';
    }
    else {
      // Don't cache. There could be closures in $value_callbacks.
      $trim = NULL;
      $cid = NULL;
    }

    if (NULL !== $cid && isset($this->settings_flat_filtered_by_cid[$cid])) {
      return $this->settings_flat_filtered_by_cid[$cid];
    }

    $empty_string_value = '';
    $empty_string_value_empty = TRUE;
    if (NULL === $trim) {
      // Let's see what our value callbacks do to the empty string.
      foreach ($value_callbacks as $value_callback) {
        $empty_string_value = $value_callback($empty_string_value);
      }
      $empty_string_value_empty = empty($empty_string_value);
    }

    $theme_settings_flat = $this->_atomium_get_settings_flat_unfiltered($theme_key, $base_themes);


    foreach ($theme_settings_flat as $key => &$value) {
      if (NULL === $value) {
        $value = [];
        continue;
      }
      if ('' === $value) {
        if ($empty_string_value_empty) {
          $value = [];
        }
        else {
          $value = [$empty_string_value];
        }
        continue;
      }
      if ([] === $value) {
        // Leave it as is.
        continue;
      }

      if (\is_string($value)) {
        $value = explode(',', $value);
      }
      elseif (\is_array($value)) {
        // Leave as is.
      }
      else {
        $value = [];
        continue;
      }

      foreach ($value_callbacks as $value_callback) {
        $value = array_map($value_callback, $value);
      }

      $value = array_values(array_filter($value));
    }

    if (NULL !== $cid) {
      $this->settings_flat_filtered_by_cid[$cid] = $theme_settings_flat;
    }

    return $theme_settings_flat;
  }

  /**
   * @param string $theme_key
   * @param bool $base_themes
   *
   * @return array|mixed
   */
  function _atomium_get_settings_flat_unfiltered($theme_key, $base_themes = TRUE) {
    $cid = $theme_key;
    if ($base_themes) {
      $cid .= '(b)';
    }
    if (isset($this->settings_flat_by_cid[$cid])) {
      return $this->settings_flat_by_cid[$cid];
    }
    if (!$theme_settings = atomium_get_theme_info($theme_key, 'settings', $base_themes)) {
      return $this->settings_flat_by_cid[$cid] = [];
    }

    $theme_settings_flat = [];
    _atomium_array_flatten(
      $theme_settings,
      $theme_settings_flat);

    return $this->settings_flat_by_cid[$cid] = $theme_settings_flat;
  }
}
