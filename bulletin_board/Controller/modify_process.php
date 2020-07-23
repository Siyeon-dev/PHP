<?php
require_once('../Config/board_conf.php');
require_once('../Config/board_util.php');
require_once('../Model/db_query.php');

// modify.php 페이지에서 수정 버튼을 눌렀을 때,
// runModify를 실행하도록 합니다.
if (array_key_exists(nameOfPostData::USER_PW, $_POST)) {
  $postData = getPostOnDB(nameOfPostData::BOARD_ID, $_POST[nameOfPostData::BOARD_ID]); // 게시글에 대한 정보를 가지고 있는 객체입니다.
  runModify($postData, $_POST[nameOfPostData::USER_PW]);
}
/////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////// FUNCTION DECLARATION  //////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
// <<-- 우효성 검사와 비밀번호 일치여부를 확인하고, 게시글 업데이트 후, 페이지 이동 함수
// 사용자 입력 값 유효성 검사를 통과하면 DB 등록
// 통과하지 못하면 팝업 출력 후 list.php 호출
function runModify($argPostObj, $argPwFromUser) {
  $IS_VALID_OK      = false;  // 유효성 검사 통과 여부
  $IS_COMPARE_OK    = false;  // 패스워드 일치 여부

  // 유효성 검사 진행
  if (checkInputValue([nameOfPostData::USER_ID, nameOfPostData::USER_PW, nameOfPostData::BOARD_TITLE, nameOfPostData::BOARD_CONTENTS, nameOfPostData::BOARD_ID]))
    $IS_VALID_OK = true;

  // 비밀번호 일치 여부 확인 진행
  if (comparePassword($argPostObj[1]->user_passwd, $argPwFromUser)) {
    updatePostDB($_POST); // 게시글 업데이트
    $IS_COMPARE_OK = true;
  }

  // 디버깅 모드
  if (boardSettings::IS_DEBUG_MODE) {
    echo "<br>IS_VALID_OK :" . $IS_VALID_OK . "<br>";
    echo "IS_COMPARE_OK : " . $IS_COMPARE_OK . "<br>";
  }

  // 유효성 검사 및 패스워드 검사 확인 여부에 따라 페이지 이동
  movePage($IS_VALID_OK, $IS_COMPARE_OK, boardAddrInfo::FILENAME_MODIFY, boardAddrInfo::FILENAME_VIEW); // list.php 호출 (이동)
}
// -->> 우효성 검사와 비밀번호 일치여부를 확인하고, 게시글 업데이트 후 페이지 이동 함수
/////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////// FUNCTION DECLARATION  //////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
