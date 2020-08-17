<?php
trait Arms {
  private $itemL = "trait:arm -> 왼손";
  private $itemR = "trait:arm -> 오른손";
  private $itemT = "trait:arm -> 무장";

  function prtArms() {
    echo $this->itemL . ": ";
    echo $this->itemR . "<br>";
  }
}

trait HF {
  private $itemH = "trait:HF -> 머리";
  private $itemF = "trait:HF -> 다리";

  function prtHead() {
    echo $this->itemH . "<br>";
  }

  function prtFoot() {
    echo $this->itemF . "<br>";
  }
}


trait tbody {
  function prtBody() {
    echo "trait:body -> 몸체 <br>";
  }
}

class cbody {
  function prtBody() {
    echo "class:body -> 몸체<br>";
  }
}

class Gundam extends cbody {
  use HF, Arms, tbody;

  function printAll() {
    $this->prtHead();
    $this->prtArms();
    $this->prtFoot();

    echo "무장 " . $this->itemT . "<br>";
  }
}

$obj = new Gundam();
$obj->printAll();
