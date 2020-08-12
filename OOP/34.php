<?php

class Variables {
  public function __construct() {
    if (session_id() === "") {
      session_start();
    }
  }
  // 세션 값 저장
  public function __set($name, $value) {
    $_SESSION['variables'][$name] = $value;
  }
  // 세션 값 불러오기
  public function &__get($name) {
    return $_SESSION['variables'][$name];
  }

  public function __isset($name) {
    return isset($_SESSION['variables'][$name]);
  }
}

$obj = new Variables();
$obj->user_name = "시연";
$obj->user_id   = 12345678;

print_r($_SESSION);
