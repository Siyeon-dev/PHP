<?php
// 이전, 다음, 현재, 제일 끝 (왼쪽, 오른쪽)
// prev, next, key reset, end

$myArray = array("a" => 5, "b" => 4, 35 => 3);
// 현 키값에 대한 원소 값 획득
echo current($myArray) . "<br>";
// 현 키값 반환
echo key($myArray) . "<br>";
// 키값을 1 증가시키고, 원소 값 반환
echo next($myArray) . "<br>";
// 키값을 1 감소시키고, 원소 값 반환
// echo prev($myArray) . "<br>";
// 마지막 키 값으로 향하고, 원소 값 반환
echo end($myArray) . "<br>";
// 최소 키 값으로 향하고, 원소 값 반환
echo reset($myArray) . "<br>";
