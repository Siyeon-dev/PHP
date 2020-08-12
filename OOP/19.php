<?php
class A {
  private   $privateValue   = 10;
  protected $protectedValue = 11;
  public    $publicValue    = 12;
}

class B extends A {
  function test() {
    echo $this->protectedValue . "<br>";
  }
}

$objA = new A();
$objB = new B();

// private 와 protected 는 참조할 수 없다.
// 반면, public 은 참조할 수 있다.
echo $objA->privateValue . "<br>";
echo $objA->protectedValue . "<br>";
echo $objA->publicValue . "<br>";

echo $objB->privateValue . "<br>";
echo $objB->protectedValue . "<br>";
echo $objB->publicValue . "<br>";
