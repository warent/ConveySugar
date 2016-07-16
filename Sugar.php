<?php

namespace ConveySugar;

class Sugar {

  private $sugar;

  public function __construct($params = []) {
    $this->sugar = new \Spinegar\Sugar7Wrapper\Rest();
    $this->sugar->setUrl($params['SUGAR_URL'])
      ->setUsername($params['SUGAR_USERNAME'])
      ->setPassword($params['SUGAR_PASS'])
      ->connect();
  }

  public function execute($module, $utility) {
    return $utility->execute($module, $this->sugar);
  }

  public function &getSugar() {
    return $this->sugar;
  }
}
