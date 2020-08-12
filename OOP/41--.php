<?php
interface Red {
  public function printRed();
}
interface Green {
  public function printGreen();
}
interface Blue {
  public function printBlue();
}
// 인터페이스는 다중 상속이 가능하다.
// 인터페이스가 인터페이스를 상속받는 경우
// keyword 로써 extends 를 사용한다.
interface Color extends Red, Green, Blue {
  public function printColor();
}
interface Black {
  public function printBlack();
}

// 일반 클래스가 인터페이스를 상속받는 경우
// keyword 로써 implements 를 사용한다.
class Printer implements Color, Black {
  public function printRed() {
    echo "빨간색 출력 <br>";
  }
  public function printGreen() {
    echo "초록색 출력 <br>";
  }
  public function printBlue() {
    echo "파란색 출력 <br>";
  }

  public function printColor() {
    echo "컬러모드 출력---- <br>";
    $this->printRed();
    $this->printGreen();
    $this->printBlue();
  }

  public function printBlack() {
    echo "흑백모드 출력---- <br>";
    echo "검정색 출력";
  }
}

$MyPrinter = new Printer();
$MyPrinter->printColor();
$MyPrinter->printBlack();
