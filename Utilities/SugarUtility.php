<?php

namespace ConveySugar\Utilities;

abstract class SugarUtility {

  public $param;

  public function __construct($params = []) {
    $this->param = new \stdClass();
    foreach ($params as $key => $val) {
      $this->param->{$key} = $val;
    }

    if (method_exists($this, 'init')) {
      $this->init();
    }
  }

  public function pdefault($param, $default) {
    $this->param->{$param} = isset($this->param->{$param}) ? $this->param->{$param} : $default;
  }

  abstract public function execute($module, &$sugar);
}

?>
