<?php
require_once('../Config/board_conf.php');
require_once('../Config/board_util.php');
require_once('../Model/db_query.php');

$postList = [];

if (isset($_SESSION[nameOfPostData::BOARD_ID])) {
  unset($_SESSION[nameOfPostData::BOARD_ID]);
}

// 로그아웃 버튼 눌렀을 경우 로그인 관련 세션 데이터 해제
if (isset($_GET['logout'])) {
  unset($_SESSION['name']);
  unset($_SESSION['password']);
}
// 로그인 버튼 눌렀을 경우 유저가 있는지 확인
if (isset($_GET['userId']))
  $resultUserExist = checkUserLogin($_GET['userId'], $_GET['userPw']);
else
  $resultUserExist = 0;


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
$arraySearchedData = checkSearchValue([nameOfPostData::SEARCH_TYPE, nameOfPostData::SEARCH_TEXT]);
$paginationObj = getPaginationData($arraySearchedData); // 페이지네이션을 위해 필요 데이터를 가져옵니다.

// <<-- search 항목 사용자 입력 값 유효성 검사 함수
function checkSearchValue($argNameOfPostData) {
  confPostData::setWritedData($argNameOfPostData);
  $writedData = confPostData::getWritedData();

  $checkedData = [];

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


function prtLoginResult($resultUserExist) {
  if (!$resultUserExist) {
    $str = <<<'HTML'
    <form action="" method="GET">
      <table>
        <tr>
          <td><label for="userId">ID :</label></td>
          <td><input type="text" name="userId"></td>
          <td><label for="userPw">PW :</label></td>
          <td><input type="password" name="userPw"></td>
          <td><input type="submit" value="Login"></td>
        </tr>
      </table>
    </form>
    HTML;
    echo $str;
  } else {
    echo "<form action='' method='GET'>";
    echo "<table>";
    echo "<tr>";
    echo "<td><label for='userId'>ID :</label></td>";
    echo "<td>{$_SESSION['name']}</td>";
    echo "<td><input type='submit' name='logout' value='Logout'></td>";
    echo "</tr>";
    echo "</table>";
    echo "</form>";
  }
}
