<?php
require_once('../db_info.php');

// <<-- 환경 설정 class
class confData {
  private $writedData = ["comment-name", "comment-passwd", "comment-contents", "board_id"];

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
  $_POST['comment-passwd'] = password_hash($_POST['comment-passwd'], PASSWORD_DEFAULT);
}
// -->> 사용자 비밀번호 입력 값 암호화 함수

// <<-- 게시글 DB 저장 함수
function insertIntoDB() {
  encrptUserPw();

  $conn = connectDB();
  $insertQuery = "INSERT INTO mybulletin VALUES(0, '{$_POST['board_id']}', '{$_POST['comment-name']}', 
                '{$_POST['comment-passwd']}', '', '{$_POST['comment-contents']}', 0, now());";

  if (!$conn->query($insertQuery)) {
    echo "쿼리문 실패";
  }
}
// -->> 게시글 DB 저장 함수

// <<-- list.php 호출 함수
function hrefListPage($argResult) {
  if ($argResult == false)
    echo '<script>alert("입력하지 않은 항목이 존재합니다.");</script>';

  echo '<script>';
  echo 'location.href="view.php?board_id=' . $_POST['board_id'] . '";';
  echo '</script>';
}
// -->> list.php 호출 함수


if (checkInputValue()) {
  insertIntoDB();
  hrefListPage(true);
};
