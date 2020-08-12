<?php
class ClassA {
  function __construct() {
    print "Class A's constructor is invoked";
  }

  // 소멸자 함수
  function __destruct() {
    print "Class A's destructor is invoked";
  }
}

$obj = new ClassA();

echo "before destroying";
// 객체를 해제함에 따라서 소멸자 함수가 호출된다.
unset($obj);
echo "after destroying";
