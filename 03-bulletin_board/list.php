<?php
require_once('../db_info.php');
require_once('./boardConfig.php');

$postList = []; // 글 객체가 저장되는 배열


// <<-- DB 로부터 저장되어있는 글 목록을 가져오는 함수
// **** 인자값이 추가되어야 한다. -> 선택에 따라 만들어진 쿼리문을 전달 받는 인자값
function getPostOnDB(&$argPostList, $argPaginationObj, $argArraySearchedData) {
  $conn = connectDB();

  if ($argArraySearchedData[0] != "") {
    $argArraySearchedData[0] = "AND " . $argArraySearchedData[0];
  }
  $getPostQuery = "SELECT * FROM mybulletin WHERE board_pid = 0 {$argArraySearchedData[0]} {$argArraySearchedData[1]} ORDER BY board_id " .
    "DESC LIMIT {$argPaginationObj->startQueryPoint}, " . PaginationData::numMaxPost;

  if (!$result = $conn->query($getPostQuery)) {
    echo "쿼리문 실패! 겟포스트온디비 ";
    exit(-1);
  }

  // DB에서 가져온 row 를 postData 객체로 생성 후 배열에 저장
  while ($data = $result->fetch_assoc()) {
    $postData = new PostData($data['board_id'], $data['user_name'], $data['title'], $data['hits'], $data['reg_date'], null);
    $argPostList[] = $postData;
  }

  prtPostData($argPostList); // DB로부터 가져온 글 출력하기
}
// -->> DB 로부터 저장되어있는 글 목록을 가져오는 함수

// <<-- DB 로부터 가져온 글 목록 Table 에 출력하는 함수
function prtPostData($argPostList) {
  foreach ($argPostList as $key) {
    echo '<tr align=center>';
    echo "<td>{$key->board_id}</td>";
    echo "<td><a href=view.php?board_id={$key->board_id}>{$key->title}</a></td>";
    echo "<td>{$key->user_name}</td>";
    echo "<td>{$key->hits}</td>";
    echo "<td>{$key->reg_date}</td>";
    echo "</tr>";
  }
}
// -->> DB 로부터 가져온 글 목록 Table 에 출력하는 함수

// <<-- 페이지네이션 함수
function getPaginationData($argArraySearchedData) {
  $conn = connectDB();
  $query = "SELECT * FROM mybulletin";

  if ($argArraySearchedData[0] != "") {
    $query .= " WHERE " . $argArraySearchedData[0] . $argArraySearchedData[1];
  } else {
    $query .= ";";
  }
  if (!$result = $conn->query($query)) {
    echo "쿼리문 실패! 겟페이지네이션데이타 ";
    exit(-1);
  }

  $NUM_ROWS        = $result->num_rows; // DB 테이블에 저장되어 있는 총 row 수
  $NUM_PAGES       = ceil($NUM_ROWS / PaginationData::numMaxPost);  // 총 페이지 수
  $NUM_BLOCKS      = ceil($NUM_PAGES / PaginationData::numMaxPage) - 1; // 총 블럭 수
  $currentPage     = array_key_exists("start", $_GET) ? $_GET['start'] : $currentPage  = 0;  // 현재 페이지
  $currentBlock    = array_key_exists("block", $_GET) ? $_GET['block'] : $currentBlock = 0;  // 현재 블록
  $startQueryPoint = $currentPage * PaginationData::numMaxPost;  // 쿼리 시작 지점 (현재 페이지 * 페이지당 포스트 수)

  if ($currentBlock <= 0) {
    $currentBlock = 0;
  }

  // 페이지네이션 관련 변수 객체 생성
  $paginationObj = new PaginationData($NUM_ROWS, $NUM_PAGES, $NUM_BLOCKS, $currentPage, $currentBlock, $startQueryPoint);
  $conn->close();
  return $paginationObj;
}
// -->> 페이지네이션 함수

// <<-- 페이지네이션 출력 함수
function prtPaginationData($argPaginationObj, $argArraySearchedData) {
  $startPage = $argPaginationObj->currentBlock * PaginationData::numMaxPage; // 현 블록에서 첫 페이지 숫자
  $arraySearchedData[0] =  "AND " . $argArraySearchedData[0];

  // [<<][<] 출력 구문
  // 총 블럭 값과 현재 위치한 블럭 값이 같을 경우
  if ($argPaginationObj->currentBlock != 0) {
    echo "<a href=$_SERVER[PHP_SELF]?start=0&search=" . $argArraySearchedData[0] . "&search-text=" . $argArraySearchedData[1] . ">[<<]</a>";
    echo "<a href=$_SERVER[PHP_SELF]?block=" . ($argPaginationObj->currentBlock - 1) . "&start=" . ($startPage - PaginationData::numMaxPage) . "&search=" . $argArraySearchedData[0] . "&search-text=" . $argArraySearchedData[1] . ">[<]</a>";
  } else {
    echo "<a href=$_SERVER[PHP_SELF]?start=0&search=" . $argArraySearchedData[0] . "&search-text=" . $argArraySearchedData[1] . ">[<<]</a>";
  }

  // 페이지 넘버링 출력 <a href>
  for ($i = $startPage; $i < $startPage + PaginationData::numMaxPage; $i++) {
    // 출력되는 페이지는 총 페이지 수를 넘지 않는다.
    if ($i < $argPaginationObj->numPages) {
      // 현재 보고 있는 페이지와 출력되는 페이지가 같을 경우 "빨간색" 으로 표시한다
      if ($argPaginationObj->currentPage != $i)
        echo "<a href=$_SERVER[PHP_SELF]?start=$i&block=$argPaginationObj->currentBlock" . "&search=" . $argArraySearchedData[0] . "&search-text=" . $argArraySearchedData[1] . ">[" . ($i + 1) . "]" . "</a>";
      else
        echo "<a href=$_SERVER[PHP_SELF]?start=$i&block=$argPaginationObj->currentBlock&search=" . $argArraySearchedData[0] . "&search-text=" . $argArraySearchedData[1] . " style=color:red>[" . ($i + 1) . "]</a>";
    }
  }
  // [>>][>] 출력 구문
  // 총 블럭 값과 현재 위치한 블럭 값이 같을 경우
  if ($argPaginationObj->numBlocks > $argPaginationObj->currentBlock) {
    echo "<a href=$_SERVER[PHP_SELF]?block=" . ($argPaginationObj->currentBlock + 1) . "&start=" . ($startPage + PaginationData::numMaxPage) . "&search=" . $argArraySearchedData[0] . "&search-text=" . $argArraySearchedData[1] . ">[>]</a>";
    echo "<a href=$_SERVER[PHP_SELF]?start=" . ($argPaginationObj->numPages - 1) . "&block=" . ($argPaginationObj->numBlocks) . "&search=" . $argArraySearchedData[0] . "&search-text=" . $argArraySearchedData[1] . ">[>>]</a>";
  } else {
    echo "<a href=$_SERVER[PHP_SELF]?start=" . ($argPaginationObj->numPages - 1) . "&block=" . ($argPaginationObj->numBlocks) . "&search=" . $argArraySearchedData[0] . "&search-text=" . $argArraySearchedData[1] . ">[>>]</a>";
  }
}
// -->> 페이지네이션 출력 함수



// <<-- 환경 설정 class
class confData {
  private $writedData = ["search", "search-text"];

  function getWritedData() {
    return $this->writedData;
  }
}
// -->> 환경 설정 class

// <<-- search 항목 사용자 입력 값 유효성 검사 함수
function checkInputValue() {
  $conf = new confData();
  $writedData = $conf->getWritedData();

  $checkedData = [];

  // $_GET 으로 넘어오는 값이 없을 경우에 공백을 return 한다.
  if (!array_key_exists('search', $_GET)) {
    return ["", ""];
  }

  // 모든 항목 공란 검사
  foreach ($writedData as $key => $value) {
    if ($_GET["{$value}"] == "") {
      return ["", ""];
    } else {
      // HTML 태그 제거 (스크립트 공격 방지 목적)
      $_GET["{$value}"] = htmlspecialchars($_GET["{$value}"], ENT_QUOTES);
    }
  }

  // 쿼리문 입력 양식 설정
  $_GET['search'] = $_GET['search'] . " LIKE ";
  $_GET['search-text'] = "'%" . $_GET['search-text'] . "%'";

  return [$_GET['search'], $_GET['search-text']];
}
// -->>사용자 입력 값 유효성 검사 함수

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://spoqa.github.io/spoqa-han-sans/css/SpoqaHanSans-kr.css" rel="stylesheet" type="text/css" />
  <style type="text/css">
    a:link {
      color: black;
      text-decoration: none;
    }

    a:visited {
      color: black;
      text-decoration: none;
    }

    a:hover {
      color: black;
      text-decoration: none;
    }

    /* styles.css */
    @import url(https://spoqa.github.io/spoqa-han-sans/css/SpoqaHanSans-kr.css);

    * {
      margin: 0;
      box-sizing: border-box;
      letter-spacing: -0.03em;
    }

    html {
      font-family: "SpoqaHanSans";
      font-size: 16px;
      line-height: 1.5;
      color: #1f2d3d;
    }

    body {
      display: flex;
      justify-content: center;
      align-items: center;
      width: 100%;
      height: 100vh;
      margin: 0 auto;
    }

    table {
      border: 1px solid #000;
      border-collapse: collapse;
    }

    td,
    th {
      white-space: nowrap;
      vertical-align: center;
      text-align: center;
      font-size: 13px;
    }

    th {
      padding: 4px 12px;
    }

    td {
      padding: 12px 24px;
      font-size: 12px;
    }

    thead {
      background-color: #000;
      color: #fff;
    }

    tbody th {
      background-color: #1f2d3d;
      color: #fff;
    }
  </style>
</head>

<body>
  <table style="width:100% bord; text-align:center;" border="1">

    <thead>
      <tr>
        <th width="50">번호</th>
        <th width="500">제목</th>
        <th width="50">작성자</th>
        <th>조회수</th>
        <th>날짜</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $arraySearchedCookie = 0;

      if (array_key_exists('search', $_GET)) {
        $arraySearchedCookie = [$_GET['search'], $_GET['search-text']];
      } else {
        $arraySearchedCookie = ["", ""];
      }
      $arraySearchedData = checkInputValue();

      $paginationObj = getPaginationData($arraySearchedData); // 페이지네이션을 위해 필요 데이터를 가져옵니다.
      getPostOnDB($postList, $paginationObj, $arraySearchedData); // DB로부터 글 가져오고, 출력하기
      ?>
      <tr>
        <td colspan="5">
          <form method="GET">
            <select name="search" id="search">
              <option value="title">제목</option>
              <option value="user_name">작성자</option>
              <option value="contents">내용</option>
              <option value="CONCAT(title,contents)">제목 + 내용</option>
            </select>
            <input type="text" name="search-text">
            <button type="submit">
              검색
            </button>
          </form>
        </td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="5"><?php prtPaginationData($paginationObj, $arraySearchedCookie) ?></td>
      </tr>
      <tr>
        <td>
          <form action="write.php" method="POST">
            <input type="submit" id="" value="글쓰기" />
          </form>
        </td>
      </tr>
    </tfoot>
    </form>
  </table>

</body>

</html>