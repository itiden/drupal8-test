<?php

/**
 * @file
 * Contains \Drupal\module_with_controller\Tests\DefaultController.
 */

namespace Drupal\module_with_controller\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the module_with_controller module.
 *
 * @group module_with_controller
 */
class DefaultControllerTest extends WebTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = array('node', 'module_with_controller');

  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return array(
      'name' => "module_with_controller DefaultController's controller functionality",
      'description' => 'Test Unit for module module_with_controller and controller DefaultController.',
      'group' => 'Other',
    );
  }

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
    $web_user = $this->drupalCreateUser(array(
      'access content'
    ));
    $this->drupalLogin($web_user);
  }

  /**
   * Tests module_with_controller functionality.
   */
  public function testDefaultController() {
    $this->drupalGet('module_with_controller');
    $this->assertResponse(200);
  }

}
