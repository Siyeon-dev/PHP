<?php
class A {
  // 클래스 맴버 변수
  public static $MyName = "멋쟁이 시연~";
  // 인스턴스 맴버 변수
  private       $MyAge  = "24";

  // 클래스 메소드 정의
  static public function printMyName() {
    echo self::$MyName;
  }
  // 인스턴스 메소드 정의
  public function printMyAge() {
    echo $this->MyAge;
  }
}
// 클래스 맴버 매소드 호출법
// 클래스명::매소드명
A::printMyName();

$objB = new A();
$objB->printMyAge();
