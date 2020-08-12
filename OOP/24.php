<?php
class A {
  public $i_v = "bar";
  const c_v = "foo";

  public function test() {
    // this 참조변수는 인스턴스화 된 객체를 가리킨다.
    echo $this->i_v . "<br>";
    // self 참조변수는 자신이 선언된 위치의 객체를 가리킨다.
    echo self::c_v . "<br>";
  }
}

class B extends A {
  public $i_v = "b_bar";
  const c_v = "b_foo";
}

$obj = new B();
$obj->test();
