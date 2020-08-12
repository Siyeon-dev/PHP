<?php

class OverloadingTest {
  // magic method 를 통해서 Overloading 구현.
  function __call($name, $parameters) {
    switch ($name) {
      case 'test':
        $num_of_parameters = count($parameters);
        if ($num_of_parameters == 0)
          $this->test_0();
        else if ($num_of_parameters == 2)
          $this->test_2($parameters[0], $parameters[1]);
        break;
      default:
        break;
    }
  }

  function test_0() {
    echo "test() is invoked <br>";
  }


  function test_2($arg1, $arg2) {
    echo "test({$arg1}, {$arg2}) is invoked <br>";
  }
}

$obj = new OverloadingTest;
$obj->test(1, 2);
