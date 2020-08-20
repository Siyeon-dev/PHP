<?php

class B {
  public $bar = 'foo';
}

class A {
  public $myObj;

  function setObj($argObj) {
    $this->myObj = $argObj;
  }

  // clone key가 실행될 때 호출되는 megic method
  function __clone() {
    $this->myObj = clone $this->myObj;
  }
}

$obj1 = new A();
$obj1->setObj(new B());


// 원래는 얕은 복사로 구현이 된다.
// -> scalar 값은 원 값이 복사
// -> reference 값은 주소 값이 복사
// 그러나 clone magic method 로 인해
// reference 의 주소값에 대상을 복사해버렸기 때문에 깊은 복사로 구현이 된다.
$obj2 = clone $obj1;

$obj1->myObj->bar = "sypark";
echo $obj2->myObj->bar;
