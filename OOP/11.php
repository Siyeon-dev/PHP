<?
class CI {
  // 클래스 맴버 변수 선언
  private static $classValue = 1;
  // 클래스 맴버 메소드 선언
  public static function printClassName() {
    echo __CLASS__;
  }
  // 인스턴스 맴버 메소드 선언
  public function printClassValue() {
    // 클래스 맴버 변수 참조
    echo CI::$classValue;
  }
  // 인스턴스 맴버 메소드 선언
  public function increaceClassValue() {
    // 클래스 맴버 변수 참조. 후위 증가.
    CI::$classValue++;
  }
}

CI::printClassName;

$objA = new CI();
$objB = new CI();
// 클래스 맴버 변수는 "stack" 메모리 공간에
// 데이터를 저장하므로, 28라인에서 실행된 increaceClassValue 에 의해
// classValue 의 값은 2가 되고, 29번 라인에서 2가 출력이 된다.
$objA = increaceClassValue();
$objB->printClassValue;