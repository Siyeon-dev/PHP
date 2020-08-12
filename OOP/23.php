<?php
class MyClass {
  const CONST_VALUE = 'A contant value <br>';
}

$classname = "myClass";
// 문자열을 double colon 의 좌항에 둘 수 있다.
echo $classname::CONST_VALUE;
echo MyClass::CONST_VALUE;


class otherClass extends MyClass {
  public static $my_static = 'static var <br>';

  public static function doubleColon() {
    echo parent::CONST_VALUE;
    echo self::$my_static;
  }
}

$classname = 'otherClass';
// class member method 도 동일하다.
$classname::doubleColon();
otherClass::doubleColon();
