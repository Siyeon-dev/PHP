<?php
require_once('../Config/board_conf.php');
require_once('../Model/db_info.php');

// Data Manipulation Language
// 1. INSERT
// <<-- 게시글 DB 저장 함수
function insertIntoDB($argArticleData) {
  $conn = connectDB();
  ///////////// 덧글을 추가하는 것에 있어서 분기를 만들어줘야한다. 현재는 게시글 추가에 대한 부분만 고려되어 있음 ///////////////
  $insertQuery = "INSERT INTO mybulletin " .
    "VALUES(0, 0, '" .
    $argArticleData[nameOfPostData::USER_ID] . "','" .
    $argArticleData[nameOfPostData::USER_PW] . "','" .
    $argArticleData[nameOfPostData::BOARD_TITLE] . "','" .
    $argArticleData[nameOfPostData::BOARD_CONTENTS] . "'," .
    "0, now());";

  if (!$result = $conn->query($insertQuery)) {
    echo "쿼리문 실패! " . $conn->error;
    exit(-1);
  }
}
// -->> 게시글 DB 저장 함수

// 2. UPDATE
// <<-- 방문자 수를 증가시키는 함수
function increaseHits($argBoardId) {
  $conn = connectDB();

  $updateQuery = "UPDATE mybulletin SET hits = hits + 1 WHERE board_id = " . $argBoardId[nameOfPostData::BOARD_ID];

  if (!$result = $conn->query($updateQuery)) {
    echo "쿼리문 실패! " . $conn->error;
    exit(-1);
  }
}
// -->> 방문자 수를 증가시키는 함수

// <<-- 수정된 내용을 DB에 반영하는 함수
function updatePostDB($argPostObj) {
  $conn = connectDB();
  echo $updateQuery = "UPDATE mybulletin SET " .
    "title = '" . $argPostObj[nameOfPostData::BOARD_TITLE] . "', " .
    "user_name = '" . $argPostObj[nameOfPostData::USER_ID] . "', " .
    "contents = '" . $argPostObj[nameOfPostData::BOARD_CONTENTS] . "', " .
    "reg_date = now() " . "WHERE board_id =" . $argPostObj[nameOfPostData::BOARD_ID];

  if (!$result = $conn->query($updateQuery)) {
    echo "쿼리문 실패! " . $conn->error;
    exit(-1);
  }
}
// -->> 수정된 내용을 DB에 반영하는 함수


// 3. DELETE







// Non-Data Manipulation Language
// 1. SELECT <게시글>
// 2. SELECT <덧글>
// 3. SELECT <검색>
function getSelectedOnDB($argBoardType, $argBoardValue) {
  $conn = connectDB();

  $arrayData = []; // 쿼리 후 생성된 객체를 저장할 배열

  $selectQuery = "SELECT * FROM mybulletin WHERE " .
    $argBoardType . " = " . $argBoardValue;

  if (!$result = $conn->query($selectQuery)) {
    echo "쿼리문 실패! " . $conn->error;
    exit(-1);
  }

  // DB에서 가져온 row 를 postData 객체로 생성 후 배열에 저장
  while ($data = $result->fetch_assoc()) {
    $arrayData = new PostData($data['board_id'], $data['board_pid'], $data['user_name'], $data['user_passwd'], $data['title'], $data['hits'], $data['reg_date'], $data['contents']);
  }

  return $arrayData; // 글 객체가 저장된 배열 반환
}
