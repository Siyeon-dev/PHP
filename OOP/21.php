<?php
class A {
  private   $a1 = "a1";
  protected $a2 = "a2";
  public    $a3 = "a3";

  public function Test(A $argA, B $argB) {
    echo $argA->a1 . "<br>";
    echo $argA->a2 . "<br>";
    echo $argA->a3 . "<br>";

    echo $argB->b1 . "<br>";
    echo $argB->b2 . "<br>";
    echo $argB->b3 . "<br>";
  }
}

class B {
  private   $b1 = "b1";
  protected $b2 = "b2";
  public    $b3 = "b3";
}


$objA1 = new A();
$objA2 = new A();
$objB = new B();

$objA1->Test($objA2, $objB);
