<?php
class A {
  // 접근제어자 protected : 상속 관계 내부에서 사용 가능
  protected $name = "박시연";

  public function printName() {
    echo $this->name . "<br>";
  }
}
// class A 로부터 상속
class B extends A {
  protected $age = 24;

  public function printAge() {
    echo $this->age . "<br>";
  }

  public function printInfo() {
    $this->printName();
    $this->printAge();
  }
}

$objA = new B();
$objA->printInfo();
