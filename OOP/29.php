<?php
class A {
  const c_v = 18;
  public $i_v = 19;
  static $s_v = 20;

  function test() {
    // static 참조변수는 오버라이딩 된 대상의 주소값을 가진다.
    // 따라서, 15번의 s_v을 출력한다.
    echo static::$s_v . "<br>";
  }
}

class B extends A {
  static $s_v = 30;

  function test() {
    echo parent::test();
    // self 참조변수는 자신이 선언된 객체의 주소값을 가진다.
    // 따라서, 15번의 s_v를 출력한다.
    echo self::$s_v . "<br>";
  }
}

$b = new B();
$b->test();
