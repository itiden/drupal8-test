<?php
/**
 * @file
 * Drush aliases for all sites.
 */

$aliases['local'] = array(
  'root' => '/var/www/web',
  'uri'  => 'local.drupal8.itiden.se',
);

$aliases['demo'] = array(
  'root' => '/var/www/drupal8.itiden.se/current/web',
  'uri'  => 'drupal8.itiden.se',
  'remote-host' => '178.62.95.103',
  'remote-user' => 'itiden',
  'ssh-options' => '-o PasswordAuthentication=yes',
);
