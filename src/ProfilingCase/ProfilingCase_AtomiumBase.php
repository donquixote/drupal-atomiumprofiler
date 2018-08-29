<?php

namespace Drupal\atomiumprofiler\ProfilingCase;

use Drupal\atomium\Attributes;
use Drupal\cfrprofiler\ProfilingCase\ProfilingCaseInterface;

abstract class ProfilingCase_AtomiumBase implements ProfilingCaseInterface {

  public function __construct() {
    $atomium_path = drupal_get_path('theme', 'atomium');
    xautoload()->adapter->addPsr4(
      'Drupal\atomium',
      $atomium_path . '/includes/classes');
  }
}

