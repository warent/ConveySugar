<?php

namespace ConveySugar\Utilities;

class Count extends SugarUtility {

  public function execute($module, &$sugar) {
    return $sugar->countRecords($module)['record_count'];
  }

}

?>
