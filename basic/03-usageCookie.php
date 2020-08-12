<?php
$dept = $_COOKIE['dept'];
$name = $_COOKIE['name'];
$age = $_COOKIE['age'];
echo "학과 : {$dept}<br>이름 : {$name}<br>나이 : {$age}";
$test = "hello world";
echo `{$test}`;
?>