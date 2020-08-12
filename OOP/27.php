<?php

// 클래스 매소드의 경우에도 동일 하다.
class A {
  function test() {
    echo "A's test() <br>";
  }

  function callTest() {
    // tihs 를 활용한 동적 바인딩
    // 현재 생성된 객체에 대한 주소를 가리키므로,
    // "B's test()" 가 출력된다.
    $this->test();
  }
}

class B extends A {
  function test() {
    echo "B's test() <br>";
  }
}

$objB = new B();
$objB->callTest();
