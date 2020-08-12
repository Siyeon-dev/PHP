<?php

class OverloadingTest {
  // 클래스 내 선언되어 있지 않은
  // 맴버들에 대해 값을 저장 할 때 호출된다.
  function __set($name, $arg) {
    print $name . " : " . $arg . "<br>";
  }
  // 클래스 내 선언되어 있지 않은
  // 맴버들에 대해 값을 읽어올 때 호출된다.
  function __get($name) {
    print $name . "<br>";
  }
}

$obj = new OverloadingTest();
$obj->test = 18;

$var_a = $obj->opent;
