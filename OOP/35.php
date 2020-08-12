<?php

class OverloadingTest {
  // 클래스 내 선언되어 있지 않은
  // 인스턴스 메소드를 호출할 때 수행된다.
  function __call($name, $parameters) {
    echo $name . "(";

    foreach ($parameters as $value)
      echo $value . ", ";

    echo ")<br>";
  }
}

$obj = new OverloadingTest();
$obj->test(1, "two", 3.3);
