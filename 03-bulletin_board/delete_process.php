<?php
require_once('../db_info.php');
require_once('./boardConfig.php');

// <<-- DB 로부터 해당 포스트의 작성된 패스워드를 가져오는 함수
function getPasswordOnDB() {
  $conn = connectDB();

  $getPasswdQuery = "SELECT user_passwd FROM mybulletin WHERE board_id=";
  $getPasswdQuery .= $_POST['board_pid'] != "" ? $_POST['board_pid'] : $_POST['board_id'];

  if (!$result = $conn->query($getPasswdQuery)) {
    echo "<br>쿼리문 실패! getPassword<br>" . $conn->error;
    exit(-1);
  }
  $userPwOnDB = $result->fetch_array();
  return $userPwOnDB[0];
}
// -->> DB 로부터 해당 포스트의 작성된 패스워드를 가져오는 함수

// <<-- 비밀번호를 비교하는 함수
function comparePassword($argPwFromDB, $argPwFromUser) {
  if (password_verify($argPwFromUser, $argPwFromDB)) {
    return true;
  } else
    return false;
}
// -->> 비밀번호를 비교하는 함수

// <<-- 글을 지우는 함수
function deletePost() {
  $conn = connectDB();
  $deletePostQuery = "DELETE FROM mybulletin WHERE board_id=";
  $deletePostQuery .= $_POST['board_pid'] != "" ? $_POST['board_pid'] : $_POST['board_id'];

  if (!$result = $conn->query($deletePostQuery)) {
    echo "쿼리문 실패! delete";
    exit(-1);
  }
}
// -->> 글을 지우는 함수


// <<-- list.php 호출 함수
function hrefListPage($argResult) {
  if (!$argResult) {
    echo '<script>';
    echo 'alert("패스워드가 일치하지 않습니다.");';
    echo 'location.href="view.php?board_id=' . $_POST['board_id'] . '";';
    echo '</script>';
  } else if ($_POST['board_pid'] != "") {
    echo '<script>';
    echo 'alert("해당 댓글이 삭제되었습니다.");';
    echo 'location.href="view.php?board_id=' . $_POST['board_id'] . '";';
    echo '</script>';
  } else {
    echo '<script>alert("해당 글이 삭제되었습니다.");</script>';
    $str = <<<'HTML'
      <script>
        location.href="list.php";
      </script>
    HTML;
    echo $str;
  }
}
// -->> list.php 호출 함수

if (boardConf::IS_CHECK_PASSWORD) {
  // 비밀번호 검사 할 때,
  // 디비 비밀번호와 입력받은 비밀번호의 비교 후 삭제를 한다.
  if (comparePassword(getPasswordOnDB(), $_POST['userPw'])) {
    deletePost();
    hrefListPage(true);
  } else {
    hrefListPage(false);
  }
  // 비밀번호 감사하지 않을 때,
  // 바로 비교하지않고 바로 삭제를 한다.
} else {
  deletePost();
  hrefListPage(true);
}
