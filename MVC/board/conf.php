<?php
class Board_conf {
  // <<-- 사용자 입력 값 유효성 검사 함수
  function checkInputValue($argNameOfPostData) {
    // 사용자로부터 입력받는 모든 항목에 대해서 유효성 검사 (순회)
    foreach ($argNameOfPostData as $key => $value) {
      // 입력되지 않은 값이 하나라도 존재한다면, false 반환
      // 입력된 값에 대해서는 HTML 태그 제거 (스크립트 공격 방지 목적)
      if ($_POST[$key] == "") {
        return false;
      }
      // HTML 스크립팅 공격 방지 작업
      $_POST[$key] = htmlspecialchars($_POST[$key], ENT_QUOTES);
    }
    // 모든 유효성 검사가 정상적으로 끝났다면,
    return true;
  }
  // -->>사용자 입력 값 유효성 검사 함수
}

//////PAGINATION///////

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

  public $startPage    = 0;
  public $beforePage   = 0;

  public function setPageInfo($argStart, $argBefore) {
    $this->startPage = $argStart;
    $this->beforePage = $argBefore;
  }

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