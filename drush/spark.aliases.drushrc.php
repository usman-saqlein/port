<?php
//  'remote-host' => '45.55.61.100',
$common_live = array(
  'remote-host' => '165.227.190.16',
  'remote-user' => 'roboking',
);

$paths = array(
  'local-root' => '/Users/clobby/dev/devdesktop/test/ccn',
  'server-root' => '/var/www/spark',
);

$aliases['loc'] = array(
  'uri' => 'ccn.dd:8083',
  'root' => $paths['local-root'].'/web',
  'path-aliases' => array(
    '%dump-dir' => $paths['local-root'].'/drush/drush_dump',
    '%files' => $paths['local-root'].'/web/sites/default/files',
  ),
  'command-specific' => array (
    'sql-sync' => array (
      'target-dump' => $paths['local-root'].'/drush/drush_dump/example.sql',
      'sanitize' => FALSE,
    ),
  ),
);

$aliases['dev'] = array(
  'uri' => 'default',
  'root' => $paths['server-root'].'/web',
  'path-aliases' => array(
    '%drush' => '/usr/local/bin/drush',
    '%dump-dir' => $paths['server-root'].'/drush/drush_dump',
    '%files' => $paths['server-root'].'/web/sites/default/files',
  ),
  'command-specific' => array (
    'sql-sync' => array (
      'source-dump' => $paths['server-root'].'/drush/drush_dump/example.sql',
    ),
  ),
);

$aliases['stage'] = $aliases['dev'] + $common_live;
