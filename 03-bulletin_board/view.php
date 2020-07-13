<?php
require_once('../../db_info.php');
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
</head>

<body>
  <fieldset style="width:400px">
    <legend style="background-color:aquamarine">
      글보기 글 번호 <?php echo $postData->board_id ?>
    </legend>
    <span>제목 </span><span name="title" style="margin-left:43px"><?php echo $postData->title ?></span><br>
    <span>작성자 </span><span name="title" style="margin-left:30px"><?php echo $postData->user_name ?></span><br>
    <span>작성시간 </span><span name="title" style="margin-left:16px"><?php echo $postData->reg_date ?></span><br>
    <span>조회수 </span><span name="title" style="margin-left:30px"><?php echo $postData->hits ?></span><br>
    <br>
    <div style="border: 1px solid; width: 380px; height: 300px; padding: 10px; margin-bottom: 15px;"><?php echo $postData->contents ?></div>


    <form action="list.php" method="POST" style="display: inline;">
      <input type="submit" id="" value="글목록" />
    </form>
    <form action="list.php" method="POST" style="display: inline;">
      <input type="submit" id="" value="글삭제" />
    </form>
    <form action="list.php" method="POST" style="display: inline;">
      <input type="submit" id="" value="글수정" />
    </form>

  </fieldset>

</body>

</html>