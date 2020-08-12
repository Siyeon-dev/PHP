<?php

class OverloadingTest {
  function __set($name, $arg) {
    print $name . " : " . $arg . "<br>";
  }

  function __get($name) {
    print $name . "<br>";
  }
  // isset() 함수 호출 시 실행
  function __isset($name) {
    print "__isset() -> " . $name . "<br>";
    return true;
  }
  // unset() 함수 호출 시 실행
  function __unset($name) {
    print "__unset() -> " . $name . "<br>";
    return true;
  }
}

$obj = new OverloadingTest();
$obj->test = 18;
$var_a = $obj->opent;

isset($obj->test);
unset($obj->opnet);
