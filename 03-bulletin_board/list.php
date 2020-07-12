<?php
require_once('../../db_info.php');


$postList = []; // 글 객체가 저장되는 배열
// <<-- 포스트를 저장할 객체
class postData {
  public $board_id;
  public $user_name;
  public $title;
  public $hits;
  public $reg_date;
  // 생성자 함수 정의
  public function __construct($argBoardId, $argUserName, $argTitle, $argHits, $argReg_date) {
    $this->board_id = $argBoardId;
    $this->user_name = $argUserName;
    $this->title = $argTitle;
    $this->hits = $argHits;
    $this->reg_date = $argReg_date;
  }
}
// -->> 포스트를 저장할 객체

// <<-- DB 로부터 저장되어있는 글 목록을 가져오는 함수
function getPostOnDB(&$argPostList, $arrayPoint) {
  $conn = connectDB();
  $getPostQuery = "SELECT * FROM mybulletin ORDER BY board_id LIMIT {$arrayPoint[0]}, {$arrayPoint[1]}";

  if (!$result = $conn->query($getPostQuery)) {
    echo "쿼리문 실패! ";
    exit(-1);
  }

  // DB에서 가져온 row 를 postData 객체로 생성 후 배열에 저장
  while ($data = $result->fetch_assoc()) {
    $postData = new postData($data['board_id'], $data['user_name'], $data['title'], $data['hits'], $data['reg_date']);
    $argPostList[] = $postData;
  }

  prtPostData($argPostList); // DB로부터 가져온 글 출력하기
}
// -->> DB 로부터 저장되어있는 글 목록을 가져오는 함수

// <<-- DB 로부터 가져온 글 목록 Table 에 출력하는 함수
function prtPostData($argPostList) {
  foreach ($argPostList as $key) {
    echo "<tr>";
    echo "<td>{$key->board_id}</td>";
    echo "<td>{$key->title}</td>";
    echo "<td>{$key->user_name}</td>";
    echo "<td>{$key->hits}</td>";
    echo "<td>{$key->reg_date}</td>";
    echo "</tr>";
  }
}
// -->> DB 로부터 가져온 글 목록 Table 에 출력하는 함수

// <<-- 페이지네이션 함수
function getPaginationData() {
  $conn = connectDB();
  $result = $conn->query("SELECT * FROM mybulletin");

  $NUM_ROWS = $result->num_rows; // DB 테이블에 저장되어 있는 총 row 수
  $MAX_POST_NUMBER = 2;     // 한 페이지당 최대 포스트 갯수
  $MAX_BLOCK_NUMBER = 2;    // 한 블럭당 보여질 페이지 갯수
  $MAX_PAGE_NUMBER = ceil($NUM_ROWS / $MAX_POST_NUMBER); // 총 페이지 수
  $NUM_BLOCKS = ceil($MAX_PAGE_NUMBER / $MAX_BLOCK_NUMBER);
  // 현재 페이지 넘버 (사용자로부터 입력받지 않았다면, 1번 페이지)
  array_key_exists("start", $_GET) ? $nowPoint = $_GET['start'] : $nowPoint = 1;
  $startPoint = ($nowPoint * $MAX_POST_NUMBER) - $MAX_POST_NUMBER; // 쿼리 시작 지점

  return [$startPoint, $MAX_POST_NUMBER, $MAX_PAGE_NUMBER, $MAX_BLOCK_NUMBER, $NUM_ROWS, $NUM_BLOCKS];
}
// -->> 페이지네이션 함수

// <<-- 페이지네이션 출력 함수
function prtPaginationData($argPaginationData) {
  array_key_exists("block", $_GET) ? $NOW_BLOCK = $_GET['block'] : $NOW_BLOCK = 1;  // 현재 블럭 위치
  array_key_exists("start", $_GET) ? $nowPoint = $_GET['start'] : $nowPoint = 1;    // 현재 보고있는 페이지 위치
  if ($NOW_BLOCK < 1)
    $NOW_BLOCK = 1;

  $NOW_BLOCK == 1 ? $startPoint = 1 : $startPoint = $argPaginationData[2] * $NOW_BLOCK; //현재 페이지 블록 구하기
  $startPoint = $NOW_BLOCK * $argPaginationData[3] - ($argPaginationData[3] - 1);  // 출력될 페이지 넘버 시작 숫자
  $endPoint = $NOW_BLOCK * $argPaginationData[3]; // 출력될 페이지 넘버 마지막 숫자

  if ($NOW_BLOCK != 1) {
    echo "<a href=$_SERVER[PHP_SELF]?start=1>[<<]</a>";
    echo "<a href=$_SERVER[PHP_SELF]?block=" . ($NOW_BLOCK - 1) . "&start=" . ($startPoint - $argPaginationData[3]) . ">[<]</a>";
  } else {
    echo "<a href=$_SERVER[PHP_SELF]?start=1>[<<]</a>";
  }
  $iValue = 0;

  // 페이지 넘버링 출력 <a href>
  for ($i = $startPoint; $i <= $endPoint; $i++) {

    if ($i <= $argPaginationData[2]) {
      if ($nowPoint != $i)
        echo "<a href=$_SERVER[PHP_SELF]?start=$i&block=$NOW_BLOCK>[$i]</a>";
      else
        echo "<a href=$_SERVER[PHP_SELF]?start=$i&block=$NOW_BLOCK style=color:red>[$i]</a>";
      $iValue = $i;
    }
  }
  if ($argPaginationData[2] != $iValue) {
    echo "<a href=$_SERVER[PHP_SELF]?block=" . ($NOW_BLOCK + 1) . "&start=" . ($endPoint + 1) . ">[>]</a>";
    echo "<a href=$_SERVER[PHP_SELF]?start=$argPaginationData[2]&block=" . ($argPaginationData[5]) . ">[>>]</a>";
  } else {
    echo "<a href=$_SERVER[PHP_SELF]?start=$argPaginationData[2]&block=" . ($NOW_BLOCK) . ">[>>]</a>";
  }
}
// -->> 페이지네이션 출력 함수
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
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
  </style>
</head>

<body>
  <table style="width:100% bord" border="1">

    <thead>
      <tr>
        <td colspan="5" style="text-align:center">
          SY Park 게시판
        </td>
      </tr>
      <tr>
        <th>번호</th>
        <th>제목</th>
        <th>작성자</th>
        <th>조회수</th>
        <th>날짜</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $arrayPaginationData = getPaginationData(); // 페이지네이션을 위해 필요 데이터를 가져옵니다.
      getPostOnDB($postList, $arrayPaginationData); // DB로부터 글 가져오고, 출력하기
      ?>
    </tbody>
  </table>
  <!-- 페이지 네이션 정보를 출력합니다. -->
  <div style="margin-left:140px"><?php prtPaginationData($arrayPaginationData) ?></div>
  <?php
  $str = <<<'HTML'
  <form action="write.php" method="POST">
  <input type="submit" id="" value="글쓰기" />
  </form>
  HTML;
  echo $str;
  ?>
</body>

</html>