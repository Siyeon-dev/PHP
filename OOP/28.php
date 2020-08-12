<?php

class A {
  public static function who() {
    echo __CLASS__;
  }

  public static function test() {
    // self 참조변수는 자신이 선언된 객체의 주소값을 가진다.
    self::who();
    // 반면 static 참조변수는
    // late static binding 이 적용되어,
    // 오버라이딩 된 method를 호출하게 된다.
    static::who();
  }
}

class B extends A {
  public static function who() {
    echo __CLASS__;
  }
}

B::test();
