<?php
require_once('../Config/board_conf.php');
require_once('../Config/board_util.php');
require_once('../Model/db_info.php');
require_once('../Model/db_query.php');

session_start();


$_POST[nameOfPostData::BOARD_ID] = 439;




if (array_key_exists(nameOfPostData::SEARCH_TYPE, $_POST)) {
  $_SESSION[nameOfPostData::SEARCH_TYPE]      = $_POST[nameOfPostData::SEARCH_TYPE];
  $_SESSION[nameOfPostData::SEARCH_TEXT]      = $_POST[nameOfPostData::SEARCH_TEXT];
  $_SESSION[nameOfPostData::PAGINATION_PAGE]  = $_POST[nameOfPostData::PAGINATION_PAGE];
  $_SESSION[nameOfPostData::PAGINATION_BLOCK] = $_POST[nameOfPostData::PAGINATION_BLOCK];
}

// <<-- DB 로부터 저장되어있는 글 정보를 가져오는 함수
function getPostOnDB() {
  // 
  $arrayArticleData = getSelectedOnDB(nameOfPostData::BOARD_ID, $_POST[nameOfPostData::BOARD_ID]);

  return $arrayArticleData;
}
// -->> DB 로부터 저장되어있는 글 정보를 가져오는 함수

// <<-- DB 로부터 저장되어있는 덧글 정보를 가져오는 함수
function getCommentOnDB($argArticleData) {
  $board_id = $argArticleData->board_id;

  $arrayCommentData = getSelectedOnDB(nameOfPostData::BOARD_PID, $_POST[nameOfPostData::BOARD_ID]);

  prtPostData($arrayCommentData, $board_id); // DB로부터 가져온 글 출력하기
}

// <<-- DB 로부터 가져온 글 목록 Table 에 출력하는 함수
function prtPostData($argCommentData, $post_board_id) {

  foreach ($argCommentData as $comment) {
    echo '<tr align=center>';
    echo "<td>{$comment->user_name}</td>";
    echo "<td>{$comment->contents}</td>";
    echo "<td>" . date_format(date_create($comment->reg_date), "Y/m/d") . "</td>";

    echo "<td><form action=" . boardAddrInfo::FILENAME_DELETE . "method='POST'><button>삭제</button>";
    echo "<input type='hidden' name='" . nameOfPostData::BOARD_ID . "' value='" . $post_board_id . "'>";
    echo "<input type='hidden' name='" . nameOfPostData::BOARD_PID . "' value='" . $comment->board_id . "'></form></td>";
    echo "</tr>";
  }
}
// -->> DB 로부터 가져온 글 목록 Table 에 출력하는 함수
