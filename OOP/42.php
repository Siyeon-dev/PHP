<?php

trait Ttest {
  private $test = "test i-variable";

  function __construct() {
    echo "construct";
  }

  function __destruct() {
    echo "destruct";
  }

  function test() {
    echo "test()";
  }
}

class Main {
  use Ttest;

  function test1() {
    echo "test1";
  }
}

echo "가자 !";
$obj = new Main();
$obj->test();
$obj->test1();
