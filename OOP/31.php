<?php
class OverloadingTest {
}

$obj = new OverloadingTest();
$obj->test = 18; // test 이름의 맴버 변수 동적 할당
$var_a = $obj->opnet;
