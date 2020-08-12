<?php
require_once('../Config/board_conf.php');
require_once('../Config/board_util.php');
require_once('../Model/db_query.php');


// if (!array_key_exists('name', $_SESSION))
//   isNOTuser();

$IS_PASSWD_OK     = true;   // 패스워드 일치 검사 통과 여부
$IS_VALID_OK      = false;  // 유효성 검사 통과 여부

// 덧글 추가 혹은 게시글 추가에 따라 작업 완료 후 페이지 이동에 대한 목적지가 달라집니다.
if (array_key_exists(nameOfPostData::BOARD_PID, $_POST) && $_POST[nameOfPostData::BOARD_PID] == 'true') {
  // 덧글에 관련된 작업은 이동경로가 VIEW 로 설정됩니다. 
  $beforePage = boardAddrInfo::FILENAME_VIEW;
  $afterPage  = boardAddrInfo::FILENAME_VIEW;
  // 
  $IS_COMMENT = $_POST[nameOfPostData::BOARD_ID]; // 덧글의 board_pid 값을 저장합니다.
} else {
  // 게시글과 관련된 작업은 이동경로가 WRITE 혹은 LIST 로 설정됩니다. 
  $beforePage = boardAddrInfo::FILENAME_WRITE;
  $afterPage  = boardAddrInfo::FILENAME_LIST;

  $IS_COMMENT = false;   // board_pid 값을 falsy 로 설정합니다.
}

// 사용자 입력 값 유효성 검사를 통과하면 DB 등록
// 통과하지 못하면 팝업 출력 후 list.php 호출
if (checkInputValue([nameOfPostData::BOARD_TITLE, nameOfPostData::BOARD_CONTENTS])) {
  $IS_VALID_OK = true;
  $hashedPasswd = encrptUserPw();       // 입력한 패스워드 해쉬 암호화

  insertIntoDB($_POST, $IS_COMMENT, $hashedPasswd); // 게시글 DB 저장 함수 실행
}

// 유효성 검사 및 패스워드 검사 확인 여부에 따라 페이지 이동
movePage($IS_VALID_OK, $IS_PASSWD_OK, $beforePage, $afterPage); // write.php 호출 (이전 페이지로 이동)
