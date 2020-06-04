<?php
// 배열의 합을 구하는 함수 sum
function sum($argList) {
    $result = 0;
    foreach($argList as $value)
        $result += $value;
    return $result;
}
// 배열의 평균 값을 구하는 함수 average
function average($argList) {
    return sum($argList) /count($argList);
}

// 버블정렬 함수 sort_bubble
function sort_bubble(&$argList, $argIsAscendingOrder) {

    for($i = 0; $i < count($argList); $i++) {
        for($j = 0; $j < count($argList); $j++) {
            // 오름차순 정렬
            if($argIsAscendingOrder != true) {
                if($argList[$i] > $argList[$j]) {
                    $temp = $argList[$i];
                    $argList[$i] = $argList[$j];
                    $argList[$j] = $temp;
                }
            // 내림차순 정렬
            } else {
                if($argList[$i] < $argList[$j]) {
                    $temp = $argList[$i];
                    $argList[$i] = $argList[$j];
                    $argList[$j] = $temp;
                }
            }
        }
    }
}
function median($argList) {
    $result = 0;
    $index = count($argList) / 2;
    // 배열의 갯수가 짝수인 경우
    if(count($argList) % 2 == 0)
        $result = ($argList[$index] + $argList[$index + 1]) / 2;
    // 배열의 갯수가 홀수인 경우
     else
        $result = $argList[$index];
    return $result;
}