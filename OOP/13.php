<?php
class CIR {
  private static $age = 24;
  private static $name = "박시연";


  public static function printName() {
    echo CIR::$name;
  }

  public function printAge() {
    echo CIR::$age;
  }

  // 클래스 맴버 매소드에서 인스턴스 맴버 매소드를 호출하고 있기에
  // 19번 라인에서 오류가 발생한다.
  public static function printInfo() {
    CIR::printName();
    CIR::printAge();
  }
}
