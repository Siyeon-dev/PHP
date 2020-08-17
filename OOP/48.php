<?php

class PException extends Exception {
}

class ExceptionTest {
  public function ThrowException() {
    try {
      // 예외 발생
      throw new Pexception();
    } catch (PException $e) {
      echo "PException <br>";
      // 예외 발생
      throw $e;
    } catch (Exception $e) {
      echo "Exception <br>";
    } finally {
      echo "Finally <br>";
    }
  }
}

$obj = new ExceptionTest();
// 14번에서 호출된 예외 발생을 처리할 구문이 없으므로
// 오류 발생
$obj->ThrowException();
