<?php

class some_class {
  public function shiny() {
    $value = 1;
    hook_invoke('shiny', $value);
    return $value;
  }
  
  public function useful() {
    $value = 42;
    hook_invoke('useful', $value);
    return $value;
  }
}
