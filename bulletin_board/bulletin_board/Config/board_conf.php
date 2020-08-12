<?php
// <<-- print PHP Syntax error
error_reporting(E_ALL);
ini_set("display_errors", 1);
// -->> print PHP Syntax error

// 기본적인 bulletin board 에 대한 설정 변수가 저장되는 class
class boardSettings {
  const IS_CHECK_PASSWORD = true;
  const IS_DEBUG_MODE     = false;
}

// <<-- POST's key name
class nameOfPostData {
  // 게시글과 관련된 key 값의 이름
  const BOARD_ID          = "board_id";
  const BOARD_PID         = "board_pid";
  const BOARD_TITLE       = "board_title";
  const BOARD_CONTENTS    = "board_contents";
  const BOARD_REG_DATE    = "board_reg_date";
  // 유저와 관련된 key 값의 이름
  const USER_ID           = "user_id";
  const USER_PW           = "user_pw";
  // 페이지네이션과 관련된 key 값의 이름
  const PAGINATION_PAGE   = "current_page";
  const PAGINATION_BLOCK  = "current_block";
  // 검색 기능과 관련된 key 값의 이름
  const SEARCH_TYPE       = "search_type";
  const SEARCH_TEXT       = "search_text";
  // 덧글 기능과 관련된 key 값의 이름
  const COMMENT_CONTENTS  = "comment_contents";
}
// -->> POST's key name


// <<-- file address of bulletin board 
class boardAddrInfo {
  // VIEW FILENAME
  const FILENAME_LIST             = "../View/list.php";
  const FILENAME_VIEW             = "../View/view.php";
  const FILENAME_WRITE            = "../View/write.php";
  const FILENAME_MODIFY           = "../View/modify.php";
  const FILENAME_DELETE           = "../View/delete.php";
  // CONTROLLER FILENAME
  const FILENAME_LIST_PROCESS     = "../Controller/list_process.php";
  const FILENAME_VIEW_PROCESS     = "../Controller/view_process.php";
  const FILENAME_WRITE_PROCESS    = "../Controller/write_process.php";
  const FILENAME_MODIFY_PROCESS   = "../Controller/modify_process.php";
  const FILENAME_DELETE_PROCESS   = "../Controller/delete_process.php";
  // MODEL FILENAME
  const FILENAME_DB_QUERY         = "../Model/db_query.php";
  const FILENAME_DB_INFO          = "../Model/db_info.php";
  // CONFIG FILENAME
  const FILENAME_BOARD_UTIL       = "../Config/board_util.php";
  const FILENAME_BOARD_CONF       = "../Config/board_conf.php";
}
// -->> file address of bulletin board 


// <<-- 포스트를 저장할 객체
class PostData {
  public $board_id;     // 글 번호
  public $board_pid;    // 부모 게시글 번호
  public $user_name;    // 작성자 이름
  public $user_passwd;  // 패스워드
  public $title;        // 제목
  public $contents;     // 내용
  public $hits;         // 조회수
  public $reg_date;     // 작성일

  // 생성자 함수 정의
  public function __construct(
    $argBoardId,
    $argBoardPid,
    $argUserName,
    $argUserPasswd,
    $argTitle,
    $argHits,
    $argReg_date,
    $argContents
  ) {
    $this->board_id   = $argBoardId;
    $this->board_pid  = $argBoardPid;
    $this->user_name  = $argUserName;
    $this->user_passwd = $argUserPasswd;
    $this->title      = $argTitle;
    $this->contents   = $argContents;
    $this->hits       = $argHits;
    $this->reg_date   = $argReg_date;
  }
}
// -->> 포스트를 저장할 객체

// <<-- 페이지네이션 데이터를 저장할 객체
class PaginationData {
  const numMaxPost      = 10;  // 페이지당 포스트 수
  const numMaxPage      = 10;  // 블럭당 페이지 수

  public $numRows         = 0;  // 총 포스트 수
  public $numPages        = 0;  // 총 페이지 수
  public $numBlocks       = 0;  // 최대 블럭 수
  public $currentPage     = 0;  // 현재 페이지 위치
  public $currentBlock    = 0;  // 현재 블럭 위치
  public $startQueryPoint = 0;  // 쿼리할 지점 위치

  public function __construct(
    $argNumRows,
    $argNumPages,
    $argNumBlocks,
    $argCurrentPage,
    $argCurrentBlock,
    $argStartQueryPoint
  ) {
    $this->numRows         = $argNumRows;
    $this->numPages        = $argNumPages;
    $this->numBlocks       = $argNumBlocks;
    $this->currentPage     = $argCurrentPage;
    $this->currentBlock    = $argCurrentBlock;
    $this->startQueryPoint = $argStartQueryPoint;
  }
}
// -->> 페이지네이션 데이터를 저장할 객체