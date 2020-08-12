<?php
require_once('../Config/board_conf.php');
require_once('../Config/board_util.php');
require_once('../Model/db_query.php');

// 덧글 삭제가 아닌 경우(게시글 삭제) 'board_pid'의 default 값은 공백입니다. 
if (!array_key_exists(nameOfPostData::BOARD_PID, $_POST)) {
  $_POST[nameOfPostData::BOARD_PID] = "";
  // 게시글과 관련된 작업은 이동경로가 WRITE 혹은 LIST 로 설정됩니다. 
  $beforePage = boardAddrInfo::FILENAME_VIEW;
  $afterPage  = boardAddrInfo::FILENAME_LIST;
} else {
  // 덧글에 관련된 작업은 이동경로가 VIEW 로 설정됩니다. 
  $beforePage = boardAddrInfo::FILENAME_VIEW;
  $afterPage  = boardAddrInfo::FILENAME_VIEW;
}

runDelete($beforePage, $afterPage);

/////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////// FUNCTION DECLARATION  //////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
function runDelete($beforePage, $afterPage) {
  $IS_VALID_OK      = true;  // 유효성 검사 통과 여부
  $IS_COMPARE_OK    = false;  // 패스워드 일치 여부
  // 패스워드 검사 실행 여부에 따라 분기
  if (boardSettings::IS_CHECK_PASSWORD) {
    // BOARD_PID 에 값이 존재한다면, boardIdType 에 'board_pid' 가 저장된다. (기본은 board_id)
    $boardIdType = $_POST[nameOfPostData::BOARD_PID] != "" ? nameOfPostData::BOARD_PID : nameOfPostData::BOARD_ID;
    // board_id 값을 통해 해당하는 글의 데이터 객체를 가져옵니다.
    $postData = getPostOnDB($boardIdType, $_SESSION['board_id']);

    if (boardSettings::IS_DEBUG_MODE) {

      echo "boardIdType : " . $boardIdType . "<br>";
      echo "boardId : " . $_POST[nameOfPostData::BOARD_ID] . "<br>";
      echo "is Copare : " . $IS_COMPARE_OK;
      print_r($postData);
    }

    // 비밀번호 검사 할 때,
    // 디비 비밀번호와 입력받은 비밀번호의 비교 후 삭제를 한다.
    if (comparePassword($postData[1]->user_passwd, $_SESSION['password'])) {
      $IS_COMPARE_OK = true;
      deletePost($_POST); // 해당 글 삭제
    }
    // 페이지 이동
    movePage($IS_VALID_OK, $IS_COMPARE_OK, $beforePage, $afterPage);
  } else {
    // 비밀번호 감사하지 않을 때,
    // 바로 비교하지않고 바로 삭제를 한다.
    deletePost($_POST);
  }
}
