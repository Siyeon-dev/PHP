<?php
require_once('../../db_info.php');

// <<-- 환경 설정 class
class confData {
  private $writedData = ["title", "userId", "userPw", "text"];

  function getWritedData() {
    return $this->writedData;
  }
}
// -->> 환경 설정 class

// <<-- 사용자 입력 값 유효성 검사 함수
function checkInputValue() {
  $conf = new confData();
  $writedData = $conf->getWritedData();

  // 모든 항목 공란 검사
  foreach ($writedData as $key => $value) {
    if ($_POST["{$value}"] == "") {
      return false;
    } else {
      // HTML 태그 제거 (스크립트 공격 방지 목적)
      $_POST["{$value}"] = htmlspecialchars($_POST["{$value}"], ENT_QUOTES);
    }
  }

  return true;
}
// -->>사용자 입력 값 유효성 검사 함수

// <<-- 사용자 비밀번호 입력 값 암호화 함수
function encrptUserPw() {
  $_POST['userPw'] = password_hash($_POST['userPw'], PASSWORD_DEFAULT);
}
// -->> 사용자 비밀번호 입력 값 암호화 함수

// <<-- 게시글 DB 저장 함수
function insertIntoDB() {
  encrptUserPw();

  $conn = connectDB();
  $insertQuery = "INSERT INTO mybulletin VALUES(0, 0, '{$_POST['userId']}', 
                '{$_POST['userPw']}', '{$_POST['title']}', '{$_POST['text']}', 0, now());";

  if (!$conn->query($insertQuery)) {
    echo "쿼리문 실패";
  }
}
// -->> 게시글 DB 저장 함수

// <<-- list.php 호출 함수
function hrefListPage($argResult) {
  if (!$argResult)
    echo '<script>alert("입력하지 않은 항목이 있습니다.");</script>';
  $str = <<<'HTML'
  <script>
    location.href="list.php";
  </script>
  HTML;
  echo $str;
}
// -->> list.php 호출 함수


// 사용자 입력 값 유효성 검사를 통과하면 DB 등록
// 통과하지 못하면 팝업 출력 후 list.php 호출
if (checkInputValue()) {
  insertIntoDB(); // 게시글 DB 저장 함수 실행
  hrefListPage(true); // list.php 호출 (이동)
} else {
  hrefListPage(false); // list.php 호출
}
