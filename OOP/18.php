<?php
class A {
  function printMyName() {
    echo __CLASS__;
  }
}

class B extends A {
  function printMyName() {
    echo __CLASS__;
  }
}

class C extends A {
  // 오버라이딩 되는 함수의 접근제어자가 부모가 갖고 있는
  // 함수의 접근제어자보다 범위가 좁기 때문에 실행될 수 없다.
  // protected function printMyName() {
  //   echo __CLASS__;
  // }
}

$objB = new B();
$objB->printMyName();

$objC = new C();
$objC->printMyName();
