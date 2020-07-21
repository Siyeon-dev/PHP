<?php
// <<-- print PHP Syntax error
error_reporting(E_ALL);
ini_set("display_errors", 1);
// -->> print PHP Syntax error

// 기본적인 bulletin board 에 대한 설정 변수가 저장되는 class
class boardSettings {
  const IS_CHECK_PASSWORD = true;
  const IS_DEBUG_MODE = true;
}

// <<-- POST's key name
class nameOfPostData {
  // 게시글과 관련된 key 값의 이름
  const BOARD_ID          = "board_id";
  const BOARD_PID         = "board_pid";
  const BOARD_TITLE       = "board_title";
  const BOARD_CONTENTS    = "board_contents";
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


// <<-- default file address of bulletin board 
class boardAddrInfo {
  // 기본 'URL' 과 'PATH' Address 설정
  const URL             = "http://localhost";
  const PATH            =  "/PHP/bulletin_board/";
  const UPPER_FOLDER    = "../";
  // MVC Model 에 따라 Folder Address 설정
  const MVC_MODEL       = "Model/";
  const MVC_VIEW        = "View/";
  const MVC_CONTROLLER  = "Controller/";
  // .php File Address
  const FILENAME_LIST             = "../View/list.php";
  const FILENAME_VIEW             = "../View/view.php";
  const FILENAME_WRITE            = "../View/write.php";
  const FILENAME_MODIFY           = "../View/modify.php";
  const FILENAME_DELETE           = "../View/delete.php";

  const FILENAME_WRITE_PROCESS    = "../Controller/write_process.php";
  const FILENAME_DELETE_PROCESS   = "../Controller/delete_process.php";
  const FILENAME_MODIFY_PROCESS   = "../Controller/modify_process.php";
  const FILENAME_VIEW_PROCESS     = "../Controller/view_process.php";

  const FILENAME_DB_QUERY         = "../Model/db_query.php";
  const FILENAME_BOARD_UTIL       = "../Model/board_util.php";
}
// -->> default file address of bulletin board 

// <<-- 포스트를 저장할 객체
class PostData {
  public $board_id;
  public $board_pid;
  public $user_name;
  public $user_passwd;
  public $title;
  public $contents;
  public $hits;
  public $reg_date;

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
  const numMaxPost      = 4;  // 페이지당 포스트 수
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