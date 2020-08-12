<?php

class OverloadingTest {
  // 클래스 내 선언되어 있지 않은
  // 클래스 매소드를 호출할 때 수행
  static function __callstatic($name, $parameters) {
    echo $name . "(";

    foreach ($parameters as $value)
      echo $value . ",";

    echo ")<br>";
  }
}

OverloadingTest::test(1, "two", 3.3);
