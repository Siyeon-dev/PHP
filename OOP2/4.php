<?php
class A {
  public $var;
  function __construct($argVar) {
    $this->var = $argVar;
  }
}

$obj1 = new A(18);
$obj2 = new A(218);
$obj3 = new A(18);
$obj4 = $obj1;


// == comparison
if ($obj1 == $obj2)
  echo "obj1 == obj2 : true <br>";
else
  echo "obj1 == obj2 : falses <br>";

if ($obj1 == $obj3)
  echo "obj1 == obj3 : true <br>";
else
  echo "obj1 == obj3 : falses <br>";

echo "--------------------------<br>";

// === comparison
if ($obj1 === $obj3)
  echo "obj1 === obj3 : true <br>";
else
  echo "obj1 === obj3 : falses <br>";

if ($obj1 === $obj4)
  echo "obj1 === obj4 : true <br>";
else
  echo "obj1 === obj4 : falses <br>";
