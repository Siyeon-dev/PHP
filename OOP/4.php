<?php
class ClassA {
  function __construct() {
    print "Class A's constructor is invoked";
  }
}

class ClassB extends ClassA {
}

// 상속 클래스 내부에 생성자가 별도로 없을 경우
// 상위 클래스의 생성자를 상속받는다.
// 따라서, Class A's constructor is invoked 출력!
$obj = new ClassB();
