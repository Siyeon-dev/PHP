<?php
require_once('../db_info.php');
require_once('./boardConfig.php');


// <<-- DB 로부터 저장되어있는 글 정보를 가져오는 함수
function getPostOnDB() {
  $conn = connectDB();
  $getPostQuery = "SELECT * FROM mybulletin WHERE board_id = {$_GET['board_id']}";

  if (!$result = $conn->query($getPostQuery)) {
    echo "쿼리문 실패! ";
    exit(-1);
  }

  // DB에서 가져온 row 를 postData 객체로 생성 후 배열에 저장
  while ($data = $result->fetch_assoc()) {
    $postData = new PostData($data['board_id'], $data['board_pid'], $data['user_name'], $data['title'], $data['hits'], $data['reg_date'], $data['contents']);
  }

  return $postData;
}
// -->> DB 로부터 저장되어있는 글 정보를 가져오는 함수

// <<-- 방문자 수를 증가시키는 함수
function increaseHits() {
  $conn = connectDB();
  $getPostQuery = "UPDATE mybulletin SET hits = hits + 1 WHERE board_id = {$_GET['board_id']}";

  if (!$result = $conn->query($getPostQuery)) {
    echo "쿼리문 실패! ";
    exit(-1);
  }
}
// -->> 방문자 수를 증가시키는 함수

increaseHits();
$postData = getPostOnDB();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://spoqa.github.io/spoqa-han-sans/css/SpoqaHanSans-kr.css" rel="stylesheet" type="text/css" />
  <!-- <link rel="stylesheet" href="/JavaScript/Kimbug/CSS/styles.css" /> -->
  <style>
    /* styles.css */
    @import url(https://spoqa.github.io/spoqa-han-sans/css/SpoqaHanSans-kr.css);

    table {
      border: 1px solid #000;
      border-collapse: collapse;
    }

    td,
    th {
      vertical-align: center;
      text-align: center;
      font-size: 13px;
    }

    th {
      padding: 6px 6px;
    }

    td {
      padding: 6px 12px;
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

    tbody th[colspan="6"] {
      padding: 0px;
      padding-left: 55px;
      background-color: #f9fafc;
      color: #1f2d3d;
    }

    * {
      margin: 0;
      box-sizing: border-box;
      font-family: "Spoqa Han Sans", sans-serif;
    }

    html {
      font-size: 16px;
      font-family: "Spoqa Han Sans", sans-serif;
      letter-spacing: -0.03em;
      color: #212529;
    }

    body {
      width: 100%;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      align-content: center;
    }

    h1 {
      width: 4500px;
      font-weight: 100;
      font-size: 32px;
      line-height: 1.5;
      margin-bottom: 1em;
      color: #101010;
      letter-spacing: -0.05em;
    }

    textarea:focus,
    textarea:hover,
    textarea:active {
      border-color: #1fb6ff;
      outline: none;
      box-shadow: none;
    }

    textarea {
      display: block;
      width: 450px;
      height: 200px;
      padding: 0 12px;
      border-radius: 7px;
      margin-bottom: 12px;
      font-size: 16px;
      border: 1px solid #d3dce6;
      transition: border-color 200ms ease-in-out;
    }

    label {
      display: block;
      width: 100%;
      font-size: 12px;
      line-height: 16px;
    }

    input {
      display: block;
      width: 450px;
      height: 44px;
      padding: 0 12px;
      border-radius: 7px;
      margin-bottom: 12px;
      font-size: 16px;
      border: 1px solid #d3dce6;
      transition: border-color 200ms ease-in-out;
    }

    input:focus,
    input:hover,
    input:active {
      outline: none;
      box-shadow: none;
      border-color: #1fb6ff;
    }

    input[type="file"] {
      padding-top: 10px;
    }

    textarea:focus,
    textarea:hover,
    textarea:active {
      border-color: #1fb6ff;
      outline: none;
      box-shadow: none;
    }
  </style>
</head>

<body>

  <fieldset style="border: 1 solid; width:370px;">
    <legend>
      <h1 style="display: inline">글 보기</h1>
    </legend>

    <p style="text-align: right;">글번호 - <?php echo $postData->board_id ?></p>
    <form action="list.php" method="POST">
      <label for="title">제목</label>
      <input type="text" id="title" name="title" placeholder="제목을 입력해주세요" value="<?php echo $postData->title ?>" disabled readonly>
      <label for="userId">작성자</label>
      <input type="text" id="userId" name="userId" placeholder="작성자 이름을 입력해주세요" value="<?php echo $postData->user_name ?>" disabled readonly>
      <label for="userPw">작성일</label>
      <input type="text" id="userPw" name="userPw" placeholder="비밀번호를 입력해주세요" value="<?php echo date_format(date_create($postData->reg_date), "Y년 m월 d일") ?>" disabled readonly>
      <br>
      <label for="text">본문</label>
      <textarea name="text" id="text" cols="48" rows="10" style="resize: none" placeholder="<?php echo $postData->contents ?>" disabled readonly></textarea>
      <input type="submit" id="Submit" value="글목록" style="background-color:#d3dce6; color:#4e5152">
    </form>
    <form action="modify.php">
      <input type="submit" id="Submit" value="글수정" style="background-color:#d3dce6; color:#4e5152">
      <input type="hidden" id="Submit" name="board_id" value="<?php echo $postData->board_id ?>">
    </form>
    <form action="delete.php" method="POST">
      <input type="submit" id="Submit" value="글삭제" style="background-color:#d3dce6; color:#4e5152">
      <input type="hidden" id="Submit" name="board_id" value="<?php echo $postData->board_id ?>">
    </form>
    <br>
    <hr>
    <br>
    <strong>
      <p style="text-align: center;">Comment</p>
    </strong>
    <!-- <p style="text-align:center">덧글</p> -->
    <br>
    <form action="comment_write.php" method="POST">
      <label for="comment-contents">덧글 내용</label>
      <textarea name="comment-contents" id="comment-contents" cols="48" rows="1" style="resize: none; height: 50px;"></textarea>

      <label for="comment-user-name">작성자</label>
      <input type="text" name="comment-name" id="comment-user-name" style="width: 450px; height: 30px;">

      <label for="comment-user-passwd">비밀번호</label>
      <input type="password" name="comment-passwd" id="comment-user-passwd" style="width: 450px; height: 30px;">

      <input type="hidden" name="board_id" value="<?php echo $postData->board_id ?>">
      <input type="submit" value="등록" style="height: 30px;">
    </form>

    <table style="width:450px; text-align:center;" border=" 1">
      <thead>

        <tr>
          <th style="width: 70px">작성자</th>
          <th style="width: 140px">내용</th>
          <th style="width: 30px">날짜</th>
          <th style="width: 10px">삭제</th>
        </tr>
      </thead>
      <tbody>
        <br>
        <?php
        $commentList = [];
        getCommentOnDB($commentList, $postData);
        ?>
      </tbody>
    </table>
  </fieldset>
</body>

</html>

<?php

// <<-- DB 로부터 저장되어있는 글 정보를 가져오는 함수
function getCommentOnDB($argCommentList, $postData) {
  $board_id = $postData->board_id;

  $conn = connectDB();
  $getPostQuery = "SELECT * FROM mybulletin WHERE board_pid = {$_GET['board_id']}";
  $commentData = [];
  if (!$result = $conn->query($getPostQuery)) {
    echo "쿼리문 실패! ";
    exit(-1);
  }

  // DB에서 가져온 row 를 postData 객체로 생성 후 배열에 저장
  while ($data = $result->fetch_assoc()) {
    $commentData = new PostData($data['board_id'], $data['board_pid'], $data['user_name'], $data['title'], $data['hits'], $data['reg_date'], $data['contents']);
    $argCommentList[] = $commentData;
  }

  prtPostData($argCommentList, $board_id); // DB로부터 가져온 글 출력하기
}

// <<-- DB 로부터 가져온 글 목록 Table 에 출력하는 함수
function prtPostData($argPostList, $post_board_id) {

  foreach ($argPostList as $key) {
    echo '<tr align=center>';
    echo "<td>{$key->user_name}</td>";
    echo "<td>{$key->contents}</td>";
    echo "<td>" . date_format(date_create($key->reg_date), "Y/m/d") . "</td>";
    echo "<td><form action='delete.php' method='POST'><button>삭제</button>";
    echo "<input type='hidden' name='board_id' value='" . $post_board_id . "'>";
    echo "<input type='hidden' name='board_pid' value='" . $key->board_id . "'></form></td>";
    echo "</tr>";
  }
}
// -->> DB 로부터 가져온 글 목록 Table 에 출력하는 함수
?>