<?php

trait Ttest {
  private $test = "test i-variable";
  // trait 의 생성자 함수
  function __construct() {
    echo "construct<br>";
  }
  // trait 의 소멸자 함수
  function __destruct() {
    echo "destruct<br>";
  }

  function test() {
    echo "test()<br>";
  }
}

class Main {
  use Ttest;

  function test1() {
    echo "test1<br>";
  }
}

echo "가자 !<br>";
$obj = new Main();
$obj->test();
$obj->test1();
