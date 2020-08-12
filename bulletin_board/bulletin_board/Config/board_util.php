<?php
// <<-- 새롭게 만든 conf 클래스 유효성 검사에 있어서 사용될 수 있음
class confPostData {
  private static $arrayPostData = [];

  static function getWritedData() {
    return self::$arrayPostData;
  }

  static function setWritedData($argNameOfPostData) {
    self::$arrayPostData = $argNameOfPostData;
  }
}
// -->>

// <<-- 사용자 입력 값 유효성 검사 함수
function checkInputValue($argNameOfPostData) {
  confPostData::setWritedData($argNameOfPostData);
  // 사용자로부터 입력받는 모든 항목에 대해서 유효성 검사 (순회)
  foreach (confPostData::getWritedData() as $key => $value) {
    // 입력되지 않은 값이 하나라도 존재한다면, false 반환
    // 입력된 값에 대해서는 HTML 태그 제거 (스크립트 공격 방지 목적)
    if ($_POST[$value] == "") {
      if (boardSettings::IS_DEBUG_MODE)
        echo $_POST[$value];
      return false;
    }
    // HTML 스크립팅 공격 방지 작업
    $_POST[$value] = htmlspecialchars($_POST[$value], ENT_QUOTES);
  }
  // 모든 유효성 검사가 정상적으로 끝났다면,
  return true;
}
// -->>사용자 입력 값 유효성 검사 함수

// <<-- 비밀번호를 비교하는 함수
function comparePassword($argPwFromDB, $argPwFromUser) {
  if (password_verify($argPwFromUser, $argPwFromDB))
    return true;
  else
    return false;
}
// -->> 비밀번호를 비교하는 함수

// <<-- 사용자 비밀번호 입력 값 암호화 함수
function encrptUserPw() {
  $hashedPasswd = password_hash($_SESSION['password'], PASSWORD_DEFAULT);

  return $hashedPasswd;
}
// -->> 사용자 비밀번호 입력 값 암호화 함수

// <<-- DB 로부터 저장되어있는 글 정보를 가져오는 함수
function getPostOnDB($argBoardIdType, $argBoardId) {
  $arrayArticleData = getSelectedOnDB($argBoardIdType, $argBoardId);

  return $arrayArticleData;
}
// -->> DB 로부터 저장되어있는 글 정보를 가져오는 함수


// <<-- process.php 실행 종료 후 그에 따른 .php 호출 함수
function movePage($validationResult, $passwdCheckResult, $beforeViewPage, $afterViewPage) {
  // '유효성 검사 실패' 혹은 '패스워드 불일치' 시에 이전 페이지로 돌아갑니다
  if ($validationResult == false || $passwdCheckResult == false) {
    echo "<script>";
    // '유효성 검사 실패' 혹은 '패스워드 불일치' 에 따라 해당 문장을 출력합니다.
    if ($validationResult == false)
      echo "alert('입력하지 않은 항목이 있습니다.');";
    else if ($passwdCheckResult == false)
      echo "alert('패스워드가 틀렸습니다.');";
    // 비정상적으로 process.php 가 진행되었을 경우 이전 페이지로 이동합니다..
    echo "location.href='{$beforeViewPage}'";
    echo "</script>";
  } else {
    // 정상적으로 process.php 가 진행되었을 경우 원하는 페이지로 이동합니다.
    echo "<script>";
    echo "location.href='{$afterViewPage}'";
    echo "</script>";
  }
}
// -->> process.php 실행 종료 후 그에 따른 .php 호출 함수

// <<-- 로그인하지 않은 사용자가 특정 페이지에 접근하는 경우 페이지 이동
function isNOTuser() {
  echo "<script>";
  echo "alert('로그인을 하십시오.');";
  echo "location.href='list.php'";
  echo "</script>";
}
// -->> 로그인하지 않은 사용자가 특정 페이지에 접근하는 경우 페이지 이동

// <<-- 페이지네이션 함수
function getPaginationData($argArraySearchedData) {
  $conn = connectDB();
  $query = "SELECT * FROM mybulletin WHERE board_pid = 0";

  // <<-- 특정 검색어 검색 시 키워드 추가 조건문
  if ($argArraySearchedData[0] != "") {
    $query .= " AND " . $argArraySearchedData[0] . $argArraySearchedData[1];
  } else {
    $query .= ";";
  }
  // -->>

  if (!$result = $conn->query($query)) {
    echo "쿼리문 실패! 겟페이지네이션데이타 ";
    exit(-1);
  }

  $NUM_ROWS        = $result->num_rows; // DB 테이블에 저장되어 있는 총 row 수
  $NUM_PAGES       = ceil($NUM_ROWS / PaginationData::numMaxPost);  // 총 페이지 수
  $NUM_BLOCKS      = ceil($NUM_PAGES / PaginationData::numMaxPage); // 총 블럭 수
  $currentPage     = array_key_exists(nameOfPostData::PAGINATION_PAGE, $_GET) ? $_GET[nameOfPostData::PAGINATION_PAGE] : $currentPage  = 1;  // 현재 페이지
  $currentBlock    = array_key_exists(nameOfPostData::PAGINATION_BLOCK, $_GET) ? $_GET[nameOfPostData::PAGINATION_BLOCK] : $currentBlock = 1;  // 현재 블록

  $startQueryPoint = ($currentPage * PaginationData::numMaxPost) - PaginationData::numMaxPost;  // 쿼리 시작 지점 (현재 페이지 * 페이지당 포스트 수)  

  // 현재 블록 위치는 1 보다 작을 수 없다.
  if ($currentBlock <= 1) {
    $currentBlock = 1;
  }

  // 페이지네이션 관련 변수 객체 생성
  $paginationObj = new PaginationData($NUM_ROWS, $NUM_PAGES, $NUM_BLOCKS, $currentPage, $currentBlock, $startQueryPoint);

  return $paginationObj;
}
// -->> 페이지네이션 함수

// <<-- 페이지네이션 출력 함수
function prtPaginationData($argPaginationObj, $argArraySearchedData) {
  $startPage = ($argPaginationObj->currentBlock - 1) * (PaginationData::numMaxPage - 1) + $argPaginationObj->currentBlock; // 현 블록에서 첫 페이지 숫자
  $beforePage = $startPage - PaginationData::numMaxPage;

  // 전으로 돌아갈 수 있는 페이지는 1 미만일 수 없다.
  if ($beforePage < 1) $beforePage = 1;

  // [<<][<] 출력 구문
  // 총 블럭 값과 현재 위치한 블럭 값이 같을 경우
  if ($argPaginationObj->currentBlock != 1) {
    echo "<a href=$_SERVER[PHP_SELF]?" . nameOfPostData::PAGINATION_PAGE . "=1" .
      "&" . nameOfPostData::SEARCH_TYPE . "=" . $argArraySearchedData[0] .
      "&" . nameOfPostData::SEARCH_TEXT . "=" . $argArraySearchedData[1] .
      ">[<<]</a>";

    echo "<a href=$_SERVER[PHP_SELF]?" . nameOfPostData::PAGINATION_BLOCK . "=" . ($argPaginationObj->currentBlock - 1) .
      "&" . nameOfPostData::PAGINATION_PAGE . "=" . ($beforePage) .
      "&" . nameOfPostData::SEARCH_TYPE . "=" . $argArraySearchedData[0] .
      "&" . nameOfPostData::SEARCH_TEXT . "=" . $argArraySearchedData[1] .
      ">[<]</a>";
  } else {
    echo "<a href=$_SERVER[PHP_SELF]?" . nameOfPostData::PAGINATION_PAGE . "=1" .
      "&" . nameOfPostData::SEARCH_TYPE . "=" . $argArraySearchedData[0] .
      "&" . nameOfPostData::SEARCH_TEXT . "=" . $argArraySearchedData[1] .
      ">[<<]</a>";
  }
  // 페이지 넘버링 출력 <a href>
  for ($i = $startPage; $i < $startPage + PaginationData::numMaxPage; $i++) {
    // 출력되는 페이지는 총 페이지 수를 넘지 않는다.
    if ($i <= $argPaginationObj->numPages) {

      // 현재 보고 있는 페이지와 출력되는 페이지가 같을 경우 "빨간색" 으로 표시한다
      if ($argPaginationObj->currentPage != $i)
        echo "<a href=$_SERVER[PHP_SELF]?" . nameOfPostData::PAGINATION_PAGE . "=$i&" .
          nameOfPostData::PAGINATION_BLOCK . "=$argPaginationObj->currentBlock&" . nameOfPostData::SEARCH_TYPE . "=" .
          $argArraySearchedData[0] . "&" . nameOfPostData::SEARCH_TEXT . "=" . $argArraySearchedData[1] .
          ">[" . ($i) . "]" . "</a>";
      else

        echo "<a href=$_SERVER[PHP_SELF]?" . nameOfPostData::PAGINATION_PAGE . "=$i&" .
          nameOfPostData::PAGINATION_BLOCK . "=$argPaginationObj->currentBlock&" . nameOfPostData::SEARCH_TYPE . "=" .
          $argArraySearchedData[0] . "&" . nameOfPostData::SEARCH_TEXT . "=" . $argArraySearchedData[1] .
          " style=color:red>[" . ($i) . "]</a>";
    }
  }
  // [>>][>] 출력 구문
  // 총 블럭 값과 현재 위치한 블럭 값이 같을 경우
  if ($argPaginationObj->numBlocks > $argPaginationObj->currentBlock) {
    echo "<a href=$_SERVER[PHP_SELF]?" . nameOfPostData::PAGINATION_BLOCK . "=" . ($argPaginationObj->currentBlock + 1) .
      "&" . nameOfPostData::PAGINATION_PAGE . "=" . ($startPage + PaginationData::numMaxPage) .
      "&" . nameOfPostData::SEARCH_TYPE . "=" . $argArraySearchedData[0] .
      "&" . nameOfPostData::SEARCH_TEXT . "=" . $argArraySearchedData[1] .
      ">[>]</a>";

    echo "<a href=$_SERVER[PHP_SELF]?" . nameOfPostData::PAGINATION_PAGE . "=" . ($argPaginationObj->numPages) .
      "&" . nameOfPostData::PAGINATION_BLOCK . "=" . ($argPaginationObj->numBlocks) .
      "&" . nameOfPostData::SEARCH_TYPE . "=" . $argArraySearchedData[0] .
      "&" . nameOfPostData::SEARCH_TEXT . "=" . $argArraySearchedData[1] .
      ">[>>]</a>";
  } else {
    echo "<a href=$_SERVER[PHP_SELF]?" . nameOfPostData::PAGINATION_PAGE . "=" . ($argPaginationObj->numPages) .
      "&" . nameOfPostData::PAGINATION_BLOCK . "=" . ($argPaginationObj->numBlocks) .
      "&" . nameOfPostData::SEARCH_TYPE . "=" . $argArraySearchedData[0] .
      "&" . nameOfPostData::SEARCH_TEXT . "=" . $argArraySearchedData[1] .
      ">[>>]</a>";
  }
}
// -->> 페이지네이션 출력 함수
