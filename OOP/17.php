<?php
class A {
  function __construct() {
    echo "A's constructor is invoked.<br>";
  }

  function __destruct() {
    echo "A's destructor is invoked.<br>";
  }
}

class B extends A {
  function __construct() {
    echo "B's constructor is invoked.<br>";
  }

  // function __destruct() {
  //   echo "B's destructor is invoked.<br>";
  // }
}

class C extends B {
  function __construct() {
    echo "C's constructor is invoked.<br>";
  }

  // function __destruct() {
  //   echo "C's destructor is invoked.<br>";
  // }
}
// 생성자 함수는 class C 내부에 있는 내용이 출력되고,
// 소멸자 함수는 존재하지 않으므로, 상속을 타고 올라가
// 소멸자 함수가 존재하는 class의 소멸자 함수를 실행한다.
$objA = new C();
