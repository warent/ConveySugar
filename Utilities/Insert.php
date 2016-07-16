<?php

namespace ConveySugar\Utilities;

use Log;

class Insert extends SugarUtility {

  public function execute($module, &$sugar) {
    $this->module = $module;
    return $sugar->create($this->module, $this->param->values);
  }

}

?>
