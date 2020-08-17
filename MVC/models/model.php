<?php
class model {
  const USER_NAME = "root";
  const SERVER_URL = "127.0.0.1";
  const DB_PASSWD = "Kyanite1!";
  const DB_NAME = "ycj_test";

  // <<-- DB 연결 함수 connectDB
  function connectDB() {
    $conn = new mysqli(self::SERVER_URL, self::USER_NAME, self::DB_PASSWD, self::DB_NAME);

    if ($conn->connect_errno) {
      echo "error" . $conn->errno;
      exit(-1);
    }

    return $conn;
  }
  // <<-- DB 로부터 저장되어있는 글 목록을 가져오는 함수
  function getList($argArraySearchedData, $argPaginationObj) {
    $conn = $this->connectDB();

    // 특정 검색어 검색 시 키워드 추가 조건문
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

    // 2차원 배열 형태로 반환
    $data = $result->fetch_all();
    return $data;
  }
  // <<-- 게시글, 덧글 조회 기능
  function getArticle($argBoardType, $argBoardValue) {
    $arrayData = null;

    $conn = $this->connectDB();

    $selectQuery = "SELECT * FROM mybulletin WHERE " .
      $argBoardType . " = " . $argBoardValue;

    if (!$result = $conn->query($selectQuery)) {
      echo "쿼리문 실패! " . $conn->error;
      exit(-1);
    }

    // DB에서 가져온 row 를 postData 객체로 생성 후 배열에 저장
    while ($data = $result->fetch_assoc()) {
      $arrayData[] = $data;
    }

    return $arrayData; // 글 객체가 저장된 배열 반환
  }
  // <<-- 방문자 수를 증가시키는 함수
  function increaseHits($argBoardId) {
    $conn = $this->connectDB();

    $updateQuery = "UPDATE mybulletin SET hits = hits + 1 WHERE board_id = " . $argBoardId['board_id'];

    if (!$result = $conn->query($updateQuery)) {
      echo "쿼리문 실패! " . $conn->error;
      exit(-1);
    }
  }
  // <<-- 로그인 시 입력받은 데이터가 DB에 존재하는지 질의
  function checkUserLogin($argUserID, $argUserPW) {
    $conn = $this->connectDB();

    $querySearchUser = "SELECT * FROM user_info" .
      " WHERE id='{$argUserID}' AND password = '{$argUserPW}';";

    $result = $conn->query($querySearchUser);
    if (!$data = $result->fetch_assoc()) {
      return false;
    } else {
      $_SESSION['name']     = $data['name'];
      $_SESSION['userId']   = $data['id'];
      $_SESSION['password'] = $data['password'];
    }
    return true;
  }
  // <<-- 글 DB 저장 함수
  function insertIntoDB($argArticleData, $argIsComment, $password) {
    $boardPid = $argIsComment != 0 ? $argIsComment : 0;

    if ($boardPid != 0) {
      $argArticleData['title'] = "";
    }

    $conn = $this->connectDB();
    $insertQuery = "INSERT INTO mybulletin " .
      "VALUES(0, " .
      $boardPid . ",'" .
      $_SESSION['userId'] . "','" .
      $password . "','" .
      $argArticleData['title'] . "','" .
      $argArticleData['contents'] . "'," .
      "0, now());";

    if (!$result = $conn->query($insertQuery)) {
      echo "쿼리문 실패! " . $conn->error;
      exit(-1);
    }
  }
  // <<-- 페이지네이션 함수
  function getPaginationData($argArraySearchedData) {
    $conn = $this->connectDB();

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
    $currentPage     = array_key_exists('current_page', $_POST) ? $_POST['current_page'] : $currentPage  = 1;  // 현재 페이지
    $currentBlock    = array_key_exists('current_block', $_POST) ? $_POST['current_block'] : $currentBlock = 1;  // 현재 블록


    $startQueryPoint = ($currentPage * PaginationData::numMaxPost) - PaginationData::numMaxPost;  // 쿼리 시작 지점 (현재 페이지 * 페이지당 포스트 수)  

    // 현재 블록 위치는 1 보다 작을 수 없다.
    if ($currentBlock <= 1) {
      $currentBlock = 1;
    }

    // 페이지네이션 관련 변수 객체 생성
    $paginationObj = new PaginationData($NUM_ROWS, $NUM_PAGES, $NUM_BLOCKS, $currentPage, $currentBlock, $startQueryPoint);

    // 페이지네이션 시작 페이지와 이전 페이지 정보 생성
    $startPage = ($paginationObj->currentBlock - 1) * (PaginationData::numMaxPage - 1) + $paginationObj->currentBlock; // 현 블록에서 첫 페이지 숫자
    $beforePage = $startPage - PaginationData::numMaxPage;
    // 전으로 돌아갈 수 있는 페이지는 1 미만일 수 없다.
    if ($beforePage < 1) $beforePage = 1;

    $paginationObj->setPageInfo($startPage, $beforePage);

    return $paginationObj;
  }
  // <<-- 게시글 혹은 덧글을 지우는 함수
  function deletePost($argPostObj) {
    $conn = $this->connectDB();
    $deleteQuery = "DELETE FROM mybulletin WHERE board_id=";
    // 전달받은 값이 게시글의 id 값인지? 아니면, 덧글의 값인지 ?
    // BOARD_PID 값이 공백이라면, BOARD_ID 를 문자열로 추가한다.
    $deleteQuery .= $argPostObj['board_pid'] != "" ? $argPostObj['board_pid'] : $_SESSION['board_id'];

    if (!$result = $conn->query($deleteQuery)) {
      echo "쿼리문 실패! " . $conn->error;
      exit(-1);
    }
  }
  // <<-- 로그인한 유저와 글을 작성한 유저가 일치하는지 확인
  function checkUserValid($board_id) {
    $conn = $this->connectDB();
    // board_id 로 글을 찾고,
    $querySearchUser = "SELECT * FROM mybulletin" .
      " WHERE board_id='{$board_id}';";

    // 그 글의 작성자 아이디를 가져와서
    $result = $conn->query($querySearchUser);
    if ($data = $result->fetch_assoc()) {
      // session 에 저장된 아이디와 비교 후
      // 일치하면 true
      // 불일치하면 false
      if ($_SESSION['userId'] == $data['user_name'])
        return true;
      else
        return false;
    }
  }
  // <<-- 수정된 내용을 DB에 반영하는 함수
  function updatePostDB($argPostObj) {
    $conn = $this->connectDB();
    $updateQuery = "UPDATE mybulletin SET " .
      "title = '" . $argPostObj['title'] . "', " .
      "contents = '" . $argPostObj['contents'] . "', " .
      "reg_date = now() " . "WHERE board_id =" . $argPostObj['board_id'];

    if (!$result = $conn->query($updateQuery)) {
      echo "쿼리문 실패! " . $conn->error;
      exit(-1);
    }
  }
}
