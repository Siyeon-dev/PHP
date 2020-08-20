<?php

class test {
  // VS code 추상 매서드 자동 생성은 ?

  private $pv = 19;
  protected $ptv = 1919;
  public $pbv = 191919;

  public function prtIteration() {
    // 객체 내부에서 iteration 을 실행하면 접근제어자에 관계없이
    // 모든 맴버 변수에 대해서 출력이 가능하다.
    // (default 설정일 경우 !)
    foreach ($this as $key => $value) {
      echo "{$key} => {$value}<br>";
    }
  }
}

$obj = new test();
$obj->prtIteration();
