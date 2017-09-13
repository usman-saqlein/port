<?php

$prod_live = array(
  'remote-host' => '45.55.61.100',
  'remote-user' => 'roboking',
);

$qa_live = array(
  'remote-host' => '45.55.187.23',
  'remote-user' => 'roboking',
);

$paths = array(
  'local-root' => '/Users/clobby/dev/devdesktop',
  'server-root' => '/var/www/spark',
);

$aliases['dev'] = array(
  'uri' => 'ccn.dd:8083',
  'root' => $paths['local-root'].'/ccn/web',
  'path-aliases' => array(
    '%dump-dir' => $paths['local-root'].'/ccn/drush/drush_dump',
    '%files' => $paths['local-root'].'/ccn/web/sites/default/files',
  ),
  'command-specific' => array (
    'sql-sync' => array (
      'target-dump' => $paths['local-root'].'/ccn/drush/drush_dump/example.sql',
      'sanitize' => FALSE,
    ),
  ),
);

$aliases['test'] = array(
  'uri' => 'ccntest.dd:8083',
  'root' => $paths['local-root'].'/test/ccn/web',
  'path-aliases' => array(
    '%dump-dir' => $paths['local-root'].'/test/ccn/drush/drush_dump',
    '%files' => $paths['local-root'].'/test/ccn/web/sites/default/files',
  ),
  'command-specific' => array (
    'sql-sync' => array (
      'target-dump' => $paths['local-root'].'/test/ccn/drush/drush_dump/example.sql',
      'sanitize' => FALSE,
    ),
  ),
);

$aliases['stage'] = array(
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

$aliases['prod'] = $aliases['stage'] + $prod_live;
$aliases['qa'] = $aliases['stage'] + $qa_live;
