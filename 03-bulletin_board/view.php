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
    $postData = new PostData($data['board_id'], $data['user_name'], $data['title'], $data['hits'], $data['reg_date'], $data['contents']);
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
  <link rel="stylesheet" href="/JavaScript/Kimbug/CSS/styles.css" />
  <style>
    textarea:focus,
    textarea:hover,
    textarea:active {
      border-color: #1fb6ff;
      outline: none;
      box-shadow: none;
    }

    textarea {
      display: block;
      width: 360px;
      height: 200px;
      padding: 0 12px;
      border-radius: 7px;
      margin-bottom: 12px;
      font-size: 16px;
      border: 1px solid #d3dce6;
      transition: border-color 200ms ease-in-out;
    }
  </style>
</head>

<body>

  <fieldset style="border: 1 solid">
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
  </fieldset>
</body>

</html>