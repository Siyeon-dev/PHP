<?php

class MyIterator implements Iterator {
  private $var = array();

  public function __construct($array) {
    if (is_array($array)) {
      $this->var = $array;
    }
  }
  public function rewind() {
    echo "rewinding <br>";
    reset($this->var);
  }
  public function valid() {
    $key = key($this->var);
    $var = ($key !== NULL && $key !== false);

    echo "valid: $var<br>";
    return $var;
  }
  public function current() {
    $var = current($this->var);
    echo "current: $var<br>";
    return $var;
  }
  public function key() {
    $var = key($this->key);
    echo "key : $var<br>";
    return $var;
  }
  public function next() {
    $var = next($this->var);
    echo "next: $var<br>";
    return $var;
  }
}


$values = new MyIterator([1, 2, 3, 4]);
foreach ($values as $a => $b)
  print "$a : $b <br>";
