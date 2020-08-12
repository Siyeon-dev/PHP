<?php
class A {
  public $name;
  public function __construct($argName) {
    $this->name = $argName;
    $this->what = 1;
  }
}

class B extends A {
  public $age;

  public function __construct($argName, $argAge) {
    parent::__construct($argName);
    $this->age = $argAge;
  }

  public function prtInfo() {
    echo $this->what;
  }
}

$obj = new B("박시연", 24);
$obj->prtInfo();
