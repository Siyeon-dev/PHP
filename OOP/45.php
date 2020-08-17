<?php
trait A {
  public function smallTalk() {
    echo "a";
  }

  public function bigTalk() {
    echo "A";
  }
}

trait B {
  public function smallTalk() {
    echo "b";
  }

  public function bigTalk() {
    echo "B";
  }
}

class Talker {
  use A, B {
    // 모호성 발생에 대한 처리
    A::smallTalk insteadof B;
    B::bigTalk insteadof A;
  }
}

$obj = new Talker();
$obj->smallTalk();
$obj->bigTalk();
