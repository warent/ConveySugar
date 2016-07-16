<?php

namespace ConveySugar\Utilities;

class Search extends SugarUtility {

  public function init() {
    $this->pdefault('offset', 0);
    $this->pdefault('limit', -1);
  }

  public function execute($module, &$sugar) {
    $this->module = $module;
    while (($this->param->offset = $this->doSearch($sugar)) > 0) {
      // Continue
    }
  }

  private function doSearch(&$sugar) {

    if ($this->param->offset >= $this->param->limit && $this->param->limit != -1) return;

    if ($this->param->offset) {
      $results = $sugar->search($this->module, [
        'offset' => $this->param->offset
        ]);
    } else {
      $results = $sugar->search($this->module);
    }

    $continue = true;

    if (array_key_exists('records', $results)) {
      $continue = call_user_func($this->param->resultsFn, ['results' => $results['records'], $this->param->offset]);
    } else {
      // This means we have a single record
      $continue = call_user_func($this->param->resultsFn, ['results' => $results, 'offset' => $this->param->offset]);
      return 0;
    }

    // Our lambda function breaks the recursive lookup with a false return
    if ($continue === false) {
      return;
    }

    return $results['next_offset'];

  }

}

?>
