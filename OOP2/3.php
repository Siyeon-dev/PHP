<?php
class A {
  static $cloned_count = 0;

  // magic method for clone operator
  function __clone() {
    echo "__clone() is invoked <br>";
    A::$cloned_count++;
  }

  function __construct() {
    echo A::$cloned_count . "<br>";
  }
}

$obj = new A();

for ($i = 0; $i < 5; $i++) {
  // cloning...
  $cObj[$i] = clone $obj;
}

echo A::$cloned_count;
