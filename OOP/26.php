<?php

class A {
  public $a;

  function setA($argA) {
    // PHP 에서는 변수에 대한 동적 바인딩이 가능하다.
    // 따라서 인자값에 따라 a 의 자료형이 변환이 된다.
    $this->a = $argA;
  }
}

$obj = new A();

$obj->setA(2);
echo $obj->a . "<br>";
$obj->setA(2.3);
echo $obj->a . "<br>";
$obj->setA("Two");
echo $obj->a;
