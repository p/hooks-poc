<?php

function bar_shiny(&$value) {
  echo "in bar_shiny\n";
  $value = 'bar';
}

function bar_useful(&$value) {
  echo "in bar_useful\n";
  $value += 1000;
}
