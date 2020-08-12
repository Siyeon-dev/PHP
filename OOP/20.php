<?php

class A {
  // 생성된 객체를 저장할 변수
  private static $objRef = null;

  // 생성자 함수
  private function __construct() {
    echo "A's constructor is invoked<br>";
  }

  // 객체를 생성할 함수
  // 객체가 이미 있는 경우는 $objRef 를 반환한다.
  static function getObject() {
    if (self::$objRef == null) {
      self::$objRef = new A();
    }

    return self::$objRef;
  }

  function printMyName() {
    echo __METHOD__;
  }
}

$objA = A::getObject();
$objA->printMyName();
