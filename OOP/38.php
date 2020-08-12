<?php
// 추상 매소드가 존재하므로, 추상 클래스가 되어야한다.
abstract class AbstractClass {
  // 추상 매소드 선언
  abstract protected function getValue();
  // 추상 매소드를 선언하고, 매개변수 하나가 필요함을 명시한다.
  abstract protected function prefixValue($prefix);

  public function printOut() {
    print $this->getValue() . "\n";
  }
}

// 추상 클래스를 상속받는다.
class ConcreteClass extends AbstractClass {
  // 추상 매소드에 대해서 구현한다.
  protected function getValue() {
    return "ConcreteClass";
  }
  public function prefixValue($prefix) {
    return "{$prefix} ConcreteClass";
  }
}

$Obj = new ConcreteClass();
echo $Obj->printOut() . "<br>";
echo $Obj->prefixValue("test") . "<br>";
