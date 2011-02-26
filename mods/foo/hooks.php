<?php

function foo_shiny(&$value) {
  echo "in foo_shiny\n";
  $value = 'foo';
}

function foo_useful(&$value) {
  echo "in foo_useful\n";
  $value *= 2;
}
