<?php
class ClassA {
  function __construct() {
    print "Class A's constructor is invoked";
  }
}

class ClassB extends ClassA {
  function __construct() {
    print "Class B's constructor is invoked";
  }
}

// 상속 시 부모 클래스의 생성자는 자동으로 호출되지 않는다.
// 따라서 Class B's constructor is invoked 가 출력된다.
$obj = new ClassB();
