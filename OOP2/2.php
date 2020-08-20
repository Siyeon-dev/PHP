<?php
class A {
  public $ma = 10;
  public $mb = 20;

  // magic method for clone operator
  function __clone() {
    echo "__Clone() is invoked <br>";
  }

  function setMB($argVar) {
    $this->mb = $argVar;
  }
}

$obj = new A();
$obj->setMB(18);
// 객체 복사 (얕은 복사)
$objC = clone $obj;

echo "MB value of the cloned OBJ : " . $objC->mb;
