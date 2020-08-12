<?php
// 인터페이스 구현
interface engine {
  // 인터페이스에는 상수와 추상 매서드만이 선언될 수 있다.
  const cylinder_num = 4;
  // abstract keyword 가 없지만, interface 내부에
  // 선언된 모든 매서드는 추상 매소드로 간주된다.
  public function go();
  public function stop();
}
// 인터페이스를 상속받기 위해서는 implements keyword 를 사용한다.
class BenzEngine implements engine {
  // 추상 매소드 구현
  public function go() {
    echo "BenzEngine go<br>";
  }
  // 추상 매소드 구현
  public function stop() {
    echo "BenzEngine stop<br>";
  }
}
class NissanQ50 {
  private $engine;
  function __construct($argEngine) {
    $this->engine = $argEngine;
  }
  function go() {
    $this->engine->go();
  }
  function stop() {
    $this->engine->stop();
  }
}

$engine = new BenzEngine();
$q50 = new NissanQ50($engine);
$q50->go();
$q50->stop();
