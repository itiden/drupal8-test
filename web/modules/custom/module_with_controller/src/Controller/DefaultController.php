<?php

/**
 * @file
 * Contains \Drupal\module_with_controller\Controller\DefaultController.
 */

namespace Drupal\module_with_controller\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class DefaultController.
 *
 * @package Drupal\module_with_controller\Controller
 */
class DefaultController extends ControllerBase {
  /**
   * Index.
   *
   * @return string
   *   Return Hello string.
   */
  public function index() {
    return [
        '#type' => 'markup',
        '#markup' => print_r(array_keys(\Drupal::service('user.permissions')->getPermissions()))
    ];
  }

}
