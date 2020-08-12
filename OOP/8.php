<?php
class PClass {
  private $name;
  private $age;
  function __construct($name, $age) {
    echo "PClass constructor is invoked";
    // $this 참조변수를 통해 객체의 인스턴스 맴버 변수에 접근한다.
    // $this 참조변수를 사용할 때는 -> (화살표 연산자) 를 사용하고,
    // 뒤에 붙는 변수명에는 $를 사용하지 않는다.
    $this->name = $name;
    $this->age = $age;
  }
  // 인스턴스 맴버 메소드 선언
  function printMyName() {
    echo "My name : " . $this->name;
  }
  function printMyAge() {
    echo "My Age : " . $this->age;
  }
  function printMyInfo() {
    // 인스턴스 멤버 매소드를 호출하는 방식 또한
    // 인스턴스 맴버 변수를 호출하는 방법과 같다.
    $this->printMyName();
    $this->printMyAge();
  }
}

$obj = new PClass("박시연", 24);
// obj에 화살표 연산자를 사용하여 인스턴스 맴버에 접근할 수 있다.
$obj->printMyInfo();
