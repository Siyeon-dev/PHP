<?php
trait Hello {
  public function sayHelloWord() {
    echo 'Hello' . $this->getWorld();
  }
  // trait 내부에 추상 매소드 선언
  abstract public function getWorld();
}

class MyHelloWorld {
  use Hello;

  private $world;
  // trait에서 받은 추상 매소드를 구현해야한다.
  public function getWorld() {
    return $this->world;
  }

  public function setWorld($val) {
    $this->world = $val;
  }
}

$obj = new MyHelloWorld();
$obj->setWorld("bar");
$obj->sayHelloWord();




////////////////////////////////////////

trait PropertiesTrait {
  public $same = true;
  public $different = false;
  private $test = 19;
}



trait PropertiesExample {
  public $same = true;
  public $different = true;
  private $test = 19;
}
