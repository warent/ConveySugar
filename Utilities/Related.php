<?php

namespace ConveySugar\Utilities;

class Related extends SugarUtility {

  const TYPE_NORMAL = 0;
  const TYPE_NAKED = 1;
  const TYPE_BACK = 2;

  const TRANSFORM_JSON = 0;
  const TRANSFORM_BOOL = 1;

  public function init() {
    $this->pdefault('number', 1);
    $this->pdefault('type', static::TYPE_NORMAL);
    $this->pdefault('transform', static::TRANSFORM_JSON);
    $this->pdefault('resultsFn', null);
    $this->pdefault('offset', 0);
    $this->pdefault('limit', -1);
  }

  public function execute($module, &$sugar) {
    try {

      $this->module = $module;

      // SugarAPI handles relations strangely
      if ($this->param->type == static::TYPE_NORMAL) $_relation = strtolower($module) . "_" . strtolower($this->param->relation) . "_{$this->param->number}";
      else if ($this->param->type == static::TYPE_NAKED) $_relation = $this->param->relation;
      else if ($this->param->type == static::TYPE_BACK) $_relation = strtolower($this->param->relation) . "_" . strtolower($module) . "_{$this->param->number}";

      if (is_null($this->param->resultsFn)) {
        $relatedResult = $sugar->related($module, $this->param->recordID, $_relation);

        if ($this->param->transform == static::TRANSFORM_BOOL) {
          if (!count($relatedResult['records'])) return false;
          return true;
        }
        else return $relatedResult;
      } else {
        $this->_relation = $_relation;
        while (($this->param->offset = $this->doRelated($sugar)) > 0) {
          // Continue;
        }
      }
    } catch (\Guzzle\Http\Exception\ClientErrorResponseException $e) {
      $stat = $e->getResponse()->getStatusCode();
      return $e;
    }
  }


  private function doRelated(&$sugar) {

    if ($this->param->offset >= $this->param->limit && $this->param->limit != -1) return;

    if ($this->param->offset) {
      $results = $sugar->related($this->module, $this->param->recordID, $this->_relation, [
        'offset' => $this->param->offset
        ]);
    } else {
      $results = $sugar->related($this->module, $this->param->recordID, $this->_relation);
    }

    $continue = true;

    if (array_key_exists('records', $results)) {
      $continue = call_user_func($this->param->resultsFn, ['records' => $results['records'], 'offset' => $this->param->offset]);
    } else {
      // This means we have a single record
      $continue = call_user_func($this->param->resultsFn, ['records' => $results, 'offset' => $this->param->offset]);
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
