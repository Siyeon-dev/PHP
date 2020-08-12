<?php
// 추상 클래스 A 
abstract class A {
  // 추상 매소드 선언
  abstract function getValue();
}

// 현 객체에서 추상 매소드를 구현하지 않겠다면,
// 추상 클래스로 지정하여, 객체 생성을 방지하고
// 자식 클래스에게 추상 매서드 구현을 강제할 수 있다.
abstract class B extends A {
}

class C extends B {
  // 추상 매소드 구현
  function getValue() {
    echo "print GV";
  }
}

$Obj = new C();
$Obj->getValue();
