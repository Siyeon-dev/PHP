<?php
require_once('../db_info.php');
require_once('./boardConfig.php');

// <<-- 환경 설정 class
class confData {
  private $writedData = ["title", "userId", "userPw", "text", "board_id"];

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

// <<-- DB 로부터 해당 포스트의 작성된 패스워드를 가져오는 함수
function getPasswordOnDB() {
  $conn = connectDB();
  $getPasswdQuery = "SELECT user_passwd FROM mybulletin WHERE board_id={$_POST['board_id']}";

  if (!$result = $conn->query($getPasswdQuery)) {
    echo "쿼리문 실패! ";
    exit(-1);
  }
  $userPwOnDB = $result->fetch_array();
  return $userPwOnDB[0];
}
// -->> DB 로부터 해당 포스트의 작성된 패스워드를 가져오는 함수

// <<-- 비밀번호를 비교하는 함수
function comparePassword($argPwFromDB, $argPwFromUser) {
  if (password_verify($argPwFromUser, $argPwFromDB))
    return true;
  else
    return false;
}
// -->> 비밀번호를 비교하는 함수

function updatePostDB() {
  $conn = connectDB();
  $updateQuery = "UPDATE mybulletin SET " .
    "title = '{$_POST['title']}', " .
    "user_name = '{$_POST['userId']}', " .
    "contents = '{$_POST['text']}', " .
    "reg_date = now() " . "WHERE board_id = {$_POST['board_id']}";

  if (!$conn->query($updateQuery)) {
    echo "쿼리문 실패";
  }
}


// <<-- list.php 호출 함수
function hrefListPage($argResult) {
  if ($argResult == 0)
    echo '<script>alert("입력하지 않은 항목이 존재합니다.");</script>';
  else if ($argResult == 2) {
    echo '<script>alert("비밀번호를 확인해주세요.");</script>';
    $str = <<<'HTML'
      <script>
        location.href="list.php";
      </script>
    HTML;
    echo $str;
  }

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
  // echo comparePassword(getPasswordOnDB(), $_POST['userPw']);
  comparePassword(getPasswordOnDB(), $_POST['userPw']) ? updatePostDB() : hrefListPage(2); // list.php 호출;

  hrefListPage(1); // list.php 호출 (이동)
} else {
  hrefListPage(0); // list.php 호출
}
