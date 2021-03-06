<?php
// 기본적인 bulletin board 에 대한 설정 변수가 저장되는 class
class boardConf {
  const IS_CHECK_PASSWORD = true;
}

// <<-- 포스트를 저장할 객체
class PostData {
  public $board_id;
  public $board_pid;
  public $user_name;
  public $title;
  public $contents;
  public $hits;
  public $reg_date;

  // 생성자 함수 정의
  public function __construct(
    $argBoardId,
    $argBoardPid,
    $argUserName,
    $argTitle,
    $argHits,
    $argReg_date,
    $argContents
  ) {
    $this->board_id   = $argBoardId;
    $this->board_pid  = $argBoardPid;
    $this->user_name  = $argUserName;
    $this->title      = $argTitle;
    $this->contents   = $argContents;
    $this->hits       = $argHits;
    $this->reg_date   = $argReg_date;
  }
}
// -->> 포스트를 저장할 객체

// <<-- 페이지네이션 데이터를 저장할 객체
class PaginationData {
  const numMaxPost      = 3;  // 페이지당 포스트 수
  const numMaxPage      = 3;  // 블럭당 페이지 수

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