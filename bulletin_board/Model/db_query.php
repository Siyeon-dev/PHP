<?php
require_once('../Config/board_conf.php');
require_once('../Model/db_info.php');
session_start();

// Data Manipulation Language
// 1. INSERT
// <<-- 게시글 DB 저장 함수
function insertIntoDB($argArticleData, $argIsComment) {
  $boardPid = $argIsComment != 0 ? $argIsComment : 0;

  $conn = connectDB();
  $insertQuery = "INSERT INTO mybulletin " .
    "VALUES(0, " .
    $boardPid . ",'" .
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
  $updateQuery = "UPDATE mybulletin SET " .
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
// <<-- 게시글 혹은 덧글을 지우는 함수
function deletePost($argPostObj) {
  $conn = connectDB();
  $deleteQuery = "DELETE FROM mybulletin WHERE board_id=";
  // 전달받은 값이 게시글의 id 값인지? 아니면, 덧글의 값인지 ?
  // BOARD_PID 값이 공백이라면, BOARD_ID 를 문자열로 추가한다.
  $deleteQuery .= $argPostObj[nameOfPostData::BOARD_PID] != "" ? $argPostObj[nameOfPostData::BOARD_PID] : $argPostObj[nameOfPostData::BOARD_ID];

  if (boardSettings::IS_DEBUG_MODE) {
    echo "delectQuery : " . $deleteQuery . "<br>";
  }

  if (!$result = $conn->query($deleteQuery)) {
    echo "쿼리문 실패! " . $conn->error;
    exit(-1);
  }
}
// -->> 글을 지우는 함수

// Non-Data Manipulation Language
// 1. SELECT <게시글>
// 2. SELECT <덧글>
// 3. SELECT <검색>
function getSelectedOnDB($argBoardType, $argBoardValue) {
  $conn = connectDB();

  $arrayData = []; // 쿼리 후 생성된 객체를 저장할 배열
  $postData = 0;

  $selectQuery = "SELECT * FROM mybulletin WHERE " .
    $argBoardType . " = " . $argBoardValue;



  if (!$result = $conn->query($selectQuery)) {
    echo "쿼리문 실패! " . $conn->error;
    exit(-1);
  }

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

    $arrayData[] = $postData;
  }

  if (boardSettings::IS_DEBUG_MODE) {
    echo "selectQuery : " . $selectQuery . "<br>";
    print_r($arrayData);
  }

  return [$arrayData, $postData]; // 글 객체가 저장된 배열 반환
}
