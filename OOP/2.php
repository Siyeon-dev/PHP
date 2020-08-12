<?php
class BaseClass {
  function __construct() {
    print "In BaseClass constructor<br>";
  }
}

// 생성자 함수 호출에 따라서
// In BaseClass constructor 출력
$obj = new BaseClass();
