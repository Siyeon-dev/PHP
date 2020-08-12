<?php

class OverloadingTest {
  function test() {
    echo "test() is invoked <br>";
  }
  // PHP 에서는 overloading 을 지원하지 않으므로, 
  // 오류가 발생합니다.
  function test($arg1, $arg2) {
    echo "test ({$arg1} {$arg2}) is invoked <br>";
  }
}

$obj = new OverloadingTest();
$obj->test();
$obj->test(1, 2);
