<?php

$mod_infos['foo'] = array(
  'shiny' => array('priority' => 1),
  // replace means lower-priority hooks will not be called
  'useful' => array('priority' => 100, 'replace' => true),
  // This will fail:
  //'useful' => array('priority' => 1, 'replace' => true),
);
