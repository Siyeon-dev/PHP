<?php
class CIR {
  private static $age = 24;
  private        $name = "박시연";

  // 클래스 맴버 매소드에서 인스턴스 맴버를 호출할 수 없다.
  public static function printName() {
    echo $this->name;
  }
  // 반면, 인스턴스 맴버 매소드에서 클래스 맴버를 호출할 수 있다.
  public function printAge() {
    echo CIR::$age;
  }

  // 그 차이를 printInfo 에서 확인할 수 있다.
  public static function printInfo() {
    CIR::printName();
    $this->printAge();
  }
}

CIR::printInfo();

$objA = new CIR();
$objA->printInfo();
