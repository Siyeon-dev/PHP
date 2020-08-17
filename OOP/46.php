<?php
trait A {
  // 상수에 대해서는 모호성 문제로 인해서,
  // 동일 이름의 변수 선언이 불가능 하다.
  // private $pv = 1515;

  private function test1() {
    echo "A::test1()";
  }
  private function test2() {
    echo "A::test2()";
  }
}

class Main {
  use A {
    //pv as public;
    test1 as public;
    test2 as public;
  }
}

$obj = new Main();
$obj->test1();
$obj->test2();
// echo $obj->pv . "<br>";
