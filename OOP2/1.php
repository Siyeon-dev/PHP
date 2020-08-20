<?php

class Test {
  private $i_v1 = "var 1";
  private $i_v2 = "";

  function prtAllVar() {
    echo $this->i_v1 . " : " . $this->i_v2 . "<br>";
  }

  function setVar($argVar) {
    $this->i_v2 = $argVar;
  }
}

$obj = new Test();
$obj->setVar("YES!");
// 객체 직렬화 (serialize)
echo serialize($obj);

$byteStream = serialize($obj);
// 객체 직렬화 해제 (unserialize)
$unserializedObj = unserialize($byteStream);

echo "<br><br> ----- after unserializing ----- <br><br>";
$unserializedObj->prtAllVar();
