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

$postData = getPostOnDB();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://spoqa.github.io/spoqa-han-sans/css/SpoqaHanSans-kr.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="./style/styles.css" />
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
      <h1 style="display: inline">수정하기</h1>
    </legend>
    <p style="text-align: right;">글번호 - <?php echo $postData->board_id ?></p>
    <form action="modify_process.php" method="POST">
      <input type="hidden" name="board_id" value="<?php echo $postData->board_id ?>">
      <label for="title">제목</label>
      <input type="text" id="title" name="title" placeholder="제목을 입력해주세요" value="<?php echo $postData->title ?>">
      <label for="userId">작성자</label>
      <input type="text" id="userId" name="userId" placeholder="작성자 이름을 입력해주세요" value="<?php echo $postData->user_name ?>">
      <label for="userPw">비밀번호</label>
      <input type="password" id="userPw" name="userPw" placeholder="비밀번호를 입력해주세요" value="">
      <br>
      <label for="text">본문</label>
      <textarea name="text" id="text" cols="48" rows="10" style="resize: none"><?php echo $postData->contents ?></textarea>
      <input type="submit" id="Submit" value="수정완료" style="background-color:#d3dce6; color:#4e5152">
    </form>
    <form action="view.php" method="GET">
      <input type="submit" id="Submit" value="이전" style="background-color:#d3dce6; color:#4e5152">
      <input type="hidden" name="board_id" value="<?php echo $postData->board_id ?>">
    </form>
  </fieldset>
</body>

</html>