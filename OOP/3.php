<?php
class ClassA {
  // 클래스 내부에 __construct 함수가 없는 경우
  // 클래스 명과 동일한 함수가 생성자 함수 역할을 한다.
  function ClassA() {
    print "ClassA() is userd as a constructor";
  }
}

$obj = new ClassA();
