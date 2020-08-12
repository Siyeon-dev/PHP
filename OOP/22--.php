<?php
class A {
  static public function Test() {
    echo __CLASS__;
  }

  public function prtTest() {
    self::Test();
    static::Test();
  }
}

class B extends A {
  static public function Test() {
    echo __CLASS__;
  }
}

$obj = new B();
$obj->prtTest();
