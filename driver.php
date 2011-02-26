<?php

require 'impl/hook_impl.php';
require 'core/class.php';
require 'mods/foo/mod_info.php';
require 'mods/bar/mod_info.php';
require 'mods/foo/hooks.php';
require 'mods/bar/hooks.php';

build_hook_dispatcher();

$object = new some_class;
$shiny = $object->shiny();
$useful = $object->useful();
echo "shiny: $shiny; useful: $useful\n";
