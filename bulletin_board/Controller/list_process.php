<?php
require_once('../Config/board_conf.php');
require_once('../Config/board_util.php');
require_once('../Model/db_query.php');
session_destroy();

$postList = [];

// 검색을 하지 않았을 경우 기본적으로 공백값을 담아둡니다.
if (!array_key_exists(nameOfPostData::SEARCH_TYPE, $_GET)) {
  $_GET[nameOfPostData::SEARCH_TYPE] = "";
  $_GET[nameOfPostData::SEARCH_TEXT] = "";
}

// 페이지네이션 유지를 위해서 변형되지 않은 검색 데이터를 따로 저장합니다.
if ($_GET[nameOfPostData::SEARCH_TYPE] != "") {
  $arrayPureSearch = [$_GET[nameOfPostData::SEARCH_TYPE], $_GET[nameOfPostData::SEARCH_TEXT]];
} else {
  $arrayPureSearch = ["", ""];
}

// 검색 기능에 대한 데이터 유효성 검사를 실시합니다.
$arraySearchedData = checkInputValueTest([nameOfPostData::SEARCH_TYPE, nameOfPostData::SEARCH_TEXT]);
$paginationObj = getPaginationData($arraySearchedData); // 페이지네이션을 위해 필요 데이터를 가져옵니다.

if (boardSettings::IS_DEBUG_MODE) {
  print_r($arraySearchedData);
  print_r($paginationObj);
}

// <<-- search 항목 사용자 입력 값 유효성 검사 함수
function checkInputValueTest($argNameOfPostData) {
  confPostData::setWritedData($argNameOfPostData);
  $writedData = confPostData::getWritedData();

  $checkedData = [];

  if (!array_key_exists(nameOfPostData::SEARCH_TYPE, $_GET) || !array_key_exists(nameOfPostData::SEARCH_TEXT, $_GET)) {
    $_GET[nameOfPostData::SEARCH_TYPE] = "";
    $_GET[nameOfPostData::SEARCH_TEXT] = "";
  }

  // 모든 항목 공란 검사
  foreach ($writedData as $key => $value) {
    if ($_GET[$value] == "") {
      return ["", ""];
    } else {
      // HTML 태그 제거 (스크립트 공격 방지 목적)
      $_GET[$value] = htmlspecialchars($_GET[$value], ENT_QUOTES);
    }
  }

  // 쿼리문 입력 양식 설정
  $search = $_GET[nameOfPostData::SEARCH_TYPE] . " LIKE ";
  $searchText = "'%" . $_GET[nameOfPostData::SEARCH_TEXT] . "%'";
  print_r($search, $searchText);
  return [$search, $searchText];
}
// -->>사용자 입력 값 유효성 검사 함수



// <<-- DB 로부터 저장되어있는 글 목록을 가져오는 함수
// **** 인자값이 추가되어야 한다. -> 선택에 따라 만들어진 쿼리문을 전달 받는 인자값
function getPostListOnDB(&$argPostList, $argPaginationObj, $argArraySearchedData) {
  $conn = connectDB();

  $searchedData = $argArraySearchedData;

  // <<-- 특정 검색어 검색 시 키워드 추가 조건문
  if ($argArraySearchedData[0] != "") {
    $argArraySearchedData[0] = "AND " . $argArraySearchedData[0];
  }
  $getPostQuery = "SELECT * FROM mybulletin WHERE board_pid = 0 {$argArraySearchedData[0]} {$argArraySearchedData[1]} ORDER BY board_id " .
    "DESC LIMIT {$argPaginationObj->startQueryPoint}, " . PaginationData::numMaxPost;

  if (!$result = $conn->query($getPostQuery)) {
    echo "쿼리문 실패! 겟포스트온디비 ";
    exit(-1);
  }
  // -->>

  // DB에서 가져온 row 를 postData 객체로 생성 후 배열에 저장
  while ($data = $result->fetch_assoc()) {
    $postData = new PostData(
      $data['board_id'],
      $data['board_pid'],
      $data['user_name'],
      $data['user_passwd'],
      $data['title'],
      $data['hits'],
      $data['reg_date'],
      $data['contents']
    );

    $argPostList[] = $postData;
  }

  prtPostData($argPostList, $argPaginationObj, $searchedData); // DB로부터 가져온 글 출력하기
}
// -->> DB 로부터 저장되어있는 글 목록을 가져오는 함수


// <<-- DB 로부터 가져온 글 목록 Table 에 출력하는 함수
function prtPostData($argPostList, $argPaginationObj, $searchedData) {
  foreach ($argPostList as $key) {
    echo '<tr align=center>';
    echo "<td>{$key->board_id}</td>";

    echo "<td><a href=view.php?";
    echo  nameOfPostData::BOARD_ID . "={$key->board_id}&";
    echo  nameOfPostData::PAGINATION_PAGE . "=" . $argPaginationObj->currentPage . "&";
    echo  nameOfPostData::PAGINATION_BLOCK . "=" . $argPaginationObj->currentBlock . "&";
    echo  nameOfPostData::SEARCH_TYPE . "=" . $searchedData[0] . "&";
    echo  nameOfPostData::SEARCH_TEXT . "=" . $searchedData[1] . ">{$key->title}</a></td>";

    echo "<td>{$key->user_name}</td>";
    echo "<td>{$key->hits}</td>";
    echo "<td>" . date_format(date_create($key->reg_date), "Y년 m월 d일") . "</td>";
    echo "</tr>";
  }
}
// -->> DB 로부터 가져온 글 목록 Table 에 출력하는 함수

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
