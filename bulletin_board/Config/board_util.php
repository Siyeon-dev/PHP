<?php
// <<-- 새롭게 만든 conf 클래스 유효성 검사에 있어서 사용될 수 있음
class confPostData {
  private static $arrayPostData = [];

  static function getWritedData() {
    return self::$arrayPostData;
  }

  static function setWritedData($argNameOfPostData) {
    self::$arrayPostData = $argNameOfPostData;
  }
}
// -->>


// <<-- 사용자 입력 값 유효성 검사 함수
function checkInputValue($argNameOfPostData) {
  confPostData::setWritedData($argNameOfPostData);

  // 사용자로부터 입력받는 모든 항목에 대해서 유효성 검사 (순회)
  foreach (confPostData::getWritedData() as $key => $value) {
    // 입력되지 않은 값이 하나라도 존재한다면, false 반환
    // 입력된 값에 대해서는 HTML 태그 제거 (스크립트 공격 방지 목적)
    if ($_POST[$value] == "") {
      if (boardSettings::IS_DEBUG_MODE)
        echo $_POST[$value];

      return false;
    } else {
      $_POST[$value] = htmlspecialchars($_POST[$value], ENT_QUOTES);
      // 입력받은 POST data를 연관배열에 복사 (insert DB 함수 인자값 전달용)  
      // $arrayArticleData[$value] = $_POST[$value];
    }
  }

  // 모든 유효성 검사가 정상적으로 끝났다면,
  return true;
}
// -->>사용자 입력 값 유효성 검사 함수


// <<-- 비밀번호를 비교하는 함수
function comparePassword($argPwFromDB, $argPwFromUser) {
  if (password_verify($argPwFromUser, $argPwFromDB))
    return true;
  else
    return false;
}
// -->> 비밀번호를 비교하는 함수



// <<-- process.php 실행 종료 후 그에 따른 .php 호출 함수
function movePage($validationResult, $passwdCheckResult, $beforeViewPage, $afterViewPage) {

  // '유효성 검사 실패' 혹은 '패스워드 불일치' 시에 이전 페이지로 돌아갑니다
  if ($validationResult == false || $passwdCheckResult == false) {
    echo "<script>";

    // '유효성 검사 실패' 혹은 '패스워드 불일치' 에 따라 해당 문장을 출력합니다.
    if ($validationResult == false)
      echo "alert('입력하지 않은 항목이 있습니다.');";
    else if ($passwdCheckResult == false)
      echo "alert('패스워드가 틀렸습니다.');";

    echo "location.href='{$beforeViewPage}'";
    echo "</script>";
  }

  // 정상적으로 process.php 가 진행되었을 경우 원하는 페이지로 이동합니다.
  echo "<script>";
  echo "location.href='{$afterViewPage}'";
  echo "</script>";
}
// -->> list.php 호출 함수