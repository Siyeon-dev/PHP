<?php

class A {
  public $i_v = "i_v 1";
  const   c_v = "c_v 1";
  static $s_v = "s_v 1";

  public function test() {
    // this 참조변수는 인스턴스화 된 객체의 주소를 가리킨다.
    echo $this->i_v . "<br>";
    // self 참조변수는 자신이 선언된 객체의 주소를 가리킨다.
    echo self::$s_v . "<br>";
  }
}

class B extends A {
  public $i_v = "i_v 2";
  const   c_v = "c_v 2";
  static $s_v = "s_v 2";

  public function syp() {
    // self 참조변수는 자신이 선언된 객체의 주소를 가리킨다.
    echo self::$s_v . "<br>";
    parent::test();
  }
}

$objB = new B();
$objB->syp();
