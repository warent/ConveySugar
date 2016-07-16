<?php

namespace ConveySugar\Utilities;

class Delete extends SugarUtility {

  public function execute($module, &$sugar) {
    $sugar->delete($module, $this->param->recordID);
  }

}

?>
