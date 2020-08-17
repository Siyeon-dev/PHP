<?php
class MYcustomException extends Exception {
}

function doStuff() {
  try {
    // 예외 발생
    throw new InvalidArgumentException("You are doing it worng!", 112);
  } catch (Exception $e) {
    // 예외 발생
    throw new MYcustomException("something happend", 911, $e);
  }
}

try {
  doStuff();
} catch (Exception $e) {
  // 11번 라인에서 발생된 예외를
  // 17번의 catch 문에서 처리한다.
  do {
    printf("%s : %d %s (%d) [%s]<br>", $e->getFile(), $e->getLine(), $e->getMessage(), $e->getCode(), get_class($e));
  } while ($e = $e->getPrevious());
}

////////////////////////////////////////////////////////////////////

function exception_handler($exception) {
  echo "Uncaught exception", $exception->getMessage(), "\n";
}

set_exception_handler('exception_handler');

throw new Exception('Uncaught Exception');
echo "Not Executed\n";
