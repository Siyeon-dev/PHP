<?php
require_once('../Config/board_conf.php');
require_once('../Config/board_util.php');
require_once('../Model/db_info.php');
require_once('../Model/db_query.php');

// <<-- 사용자 비밀번호 입력 값 암호화 함수
function encrptUserPw() {
  $_POST[nameOfPostData::USER_PW] = password_hash($_POST[nameOfPostData::USER_PW], PASSWORD_DEFAULT);
}
// -->> 사용자 비밀번호 입력 값 암호화 함수


// 사용자 입력 값 유효성 검사를 통과하면 DB 등록
// 통과하지 못하면 팝업 출력 후 list.php 호출
if (checkInputValue([nameOfPostData::USER_ID, nameOfPostData::USER_PW, nameOfPostData::BOARD_TITLE, nameOfPostData::BOARD_CONTENTS])) {
  encrptUserPw();       // 입력한 패스워드 해쉬 암호화
  insertIntoDB($_POST); // 게시글 DB 저장 함수 실행

  movePage(true, true, boardAddrInfo::FILENAME_WRITE, boardAddrInfo::FILENAME_LIST); // list.php 호출 (이동)
} else {
  movePage(false, true, boardAddrInfo::FILENAME_WRITE, boardAddrInfo::FILENAME_LIST); // write.php 호출 (이전 페이지로 이동)
}
