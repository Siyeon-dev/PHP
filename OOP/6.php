<?php
class ClassA {
  function __construct() {
    print "Class A's constructor is invoked";
  }
}

class ClassB extends ClassA {
  function __construct() {
    //parent:: 키워드
    parent::__construct();
    print "Class B's constructor is invoked";
  }
}

// 부모 클래스의 상속자 호출시 parent:: 키워드를 사용하면 된다.
// 따라서 
// Class A's constructor is invoked
// Class B's constructor is invoked 가 출력된다.
$obj = new ClassB();
