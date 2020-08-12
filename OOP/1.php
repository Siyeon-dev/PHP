<?php
class myFirstClass {
  // 맴버변수 선언
  private $name;

  // 생성자 선언
  function __construct($argName) {
    $this->name = $argName;
  }

  // 인스턴스 멤버 메소드 선언
  function printMyName() {
    echo $this->name;
  }
}

// myFirestClass 객체 생성
$mfc = new myFirstClass("박시연");

// 생성된 객체의 "printMyName" 메소드 호출
$mfc->printMyName();
