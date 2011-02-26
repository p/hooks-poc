<?php

function hook_invoke($hook_name, &$arg) {
  global $hook_dispatcher;
  return $hook_dispatcher->$hook_name($arg);
}

function build_hook_dispatcher() {
  global $mod_infos;
  
  $ordered = array();
  $levels = array();
  
  foreach ($mod_infos as $mod => $info) {
    foreach ($info as $hook => $options) {
      $priority = $options['priority'];
      if (empty($ordered[$hook])) {
        $ordered[$hook] = array();
      }
      if (isset($ordered[$hook][$priority])) {
        die("duplicate priority $priority for hook $hook (guilty mod $mod, previous mod {$ordered[$hook][$priority]})");
      }
      $ordered[$hook][$priority] = array($mod, $options);
      $levels[$priority] = true;
    }
  }
  
  echo "Ordered mod map:\n";
  var_dump($ordered);
  
  $text = '';
  
  $text .= "class hook_dispatcher_base {\n";
  foreach (array_keys($ordered) as $hook) {
    $text .= "  function $hook(&\$args) {}\n";
  }
  $text .= "}\n";
  
  $sorted_levels = array_keys($levels);
  sort($sorted_levels);
  
  $prev_level = 'base';
  foreach ($sorted_levels as $level) {
    $text .= "class hook_dispatcher_$level extends hook_dispatcher_$prev_level {\n";
    foreach ($ordered as $hook => $mods) {
      foreach ($mods as $priority => $info) {
        list($mod, $options) = $info;
        if ($level == $priority) {
          $text .= "  public function $hook(&\$args) {\n";
          if (!isset($options['replace']) || !$options['replace']) {
            $text .= "    parent::$hook(\$args);\n";
          }
          $text .= "    ${mod}_$hook(\$args);\n";
          $text .= "  }\n";
        }
      }
    }
    $text .= "}\n";
    $prev_level = $level;
  }
  $text .= "class hook_dispatcher extends hook_dispatcher_$prev_level {\n";
  $text .= "}\n";
  
  echo "Generated dispatcher hierarchy:\n";
  echo $text;
  
  eval($text);
  global $hook_dispatcher;
  $hook_dispatcher = new hook_dispatcher;
}

$mod_infos = array();

$defined_hooks = array('shiny', 'useful');
