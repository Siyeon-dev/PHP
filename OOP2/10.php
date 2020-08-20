<?php
class A {
  public $value = array(5, 4, 3);
}

$obj = new A();

foreach ($obj->value as $key => $value) {
  echo $key . ":" . $value . "<br>";
}
