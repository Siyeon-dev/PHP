<?php
require_once('../Config/board_conf.php');
require_once('../Config/board_util.php');
require_once('../Model/db_query.php');

if (!array_key_exists(nameOfPostData::BOARD_ID, $_SESSION)) {
  $_SESSION[nameOfPostData::BOARD_ID] = $_GET[nameOfPostData::BOARD_ID];
}
if (!array_key_exists(nameOfPostData::PAGINATION_PAGE, $_SESSION)) {
  $_SESSION[nameOfPostData::PAGINATION_PAGE] = $_GET[nameOfPostData::PAGINATION_PAGE];
  $_SESSION[nameOfPostData::PAGINATION_BLOCK] = $_GET[nameOfPostData::PAGINATION_BLOCK];
  $_SESSION[nameOfPostData::SEARCH_TEXT] = $_GET[nameOfPostData::SEARCH_TEXT];
  $_SESSION[nameOfPostData::SEARCH_TYPE] = $_GET[nameOfPostData::SEARCH_TYPE];
}


$postData = getPostOnDB(nameOfPostData::BOARD_ID, $_SESSION[nameOfPostData::BOARD_ID]); // 게시글에 대한 정보를 가지고 있는 객체입니다.

increaseHits($_SESSION);


/////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////// FUNCTION DECLARATION  //////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
// <<-- DB 로부터 가져온 글 목록 Table 에 출력하는 함수
function prtCommentData($argCommentData) {

  foreach ($argCommentData as $comment) {
    echo '<tr align=center>';
    echo "<td>{$comment->user_name}</td>";
    echo "<td>{$comment->contents}</td>";
    echo "<td>" . date_format(date_create($comment->reg_date), "Y/m/d") . "</td>";
    if (checkUserBalid($comment->board_id)) {
      echo "<td><form action='" . boardAddrInfo::FILENAME_DELETE_PROCESS . "'method='POST'><button>삭제</button>";
      echo "<input type='hidden' name='" . nameOfPostData::BOARD_ID . "' value='" . $_SESSION[nameOfPostData::BOARD_ID] . "'>";
      echo "<input type='hidden' name='" . nameOfPostData::BOARD_PID . "' value='" . $comment->board_id . "'></form></td>";
    } else {
      echo "<td></td>";
    }
    echo "</tr>";
  }
}
// -->> DB 로부터 가져온 글 목록 Table 에 출력하는 함수
/////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////// FUNCTION DECLARATION  //////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
