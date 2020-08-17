<?php
trait TraitTest {
  function test1() {
    echo "trait:test()1<br>";
  }

  function test2() {
    echo "trait:test()2<br>";
  }
}

class base {
  function test2() {
    echo "base class:test()2<br>";
  }
}

class Main {
  use TraitTest;
  // trait 함수보다 객체 내부의 동일 함수의 우선순위가 높다.
  function test1() {
    echo "Main class:test()1<br>";
  }
}

$obj = new Main();
$obj->test1();
$obj->test2();
