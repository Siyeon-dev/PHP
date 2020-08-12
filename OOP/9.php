<?php
class MyClass {
  // const 키워드 사용하여 상수 정의
  const CONSTANT = "const value";

  function showConstValue() {
    // self:: 키워드를 이용하여
    // 클래스 내부 메소드에서 접근할 수 있다.
    echo self::CONSTANT;
  }
}

echo MyClass::CONSTANT;
$classname = "MyClass";
// 클래스명을 이와 같이 같은 문자열을 담고있는
// 변수로 대체할 수 있다.
echo $classname::CONSTANT;

$class = new MyClass();
$class->showConstValue();

echo $class::CONSTANT;
