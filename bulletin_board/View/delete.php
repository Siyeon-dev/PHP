<?php
require_once('../Config/board_conf.php');
require_once('../Controller/delete_process.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DELETE</title>
  <link rel="stylesheet" href="https://spoqa.github.io/spoqa-han-sans/css/SpoqaHanSans-kr.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="./style/styles.css" />
</head>

<body>
  <fieldset style="border: 1 solid">
    <legend>
      <h1 style="display: inline">글삭제</h1>
    </legend>
    <!-- delete_process.php 를 진행합니다 <글, 덧글 삭제 기능> -->
    <form action="#" method="POST">
      <label for="userPw">비밀번호</label>
      <input type="password" id="userPw" name="<?php echo nameOfPostData::USER_PW ?>" placeholder="비밀번호를 입력해주세요">
      <!-- 게시글 혹은 덧글을 지우기 위해서 board_id와 board_pid를 함께 전달합니다. -->
      <input type="hidden" name="<?php echo nameOfPostData::BOARD_ID ?>" value="<?php echo $_SESSION[nameOfPostData::BOARD_ID] ?>">
      <input type="hidden" name="<?php echo nameOfPostData::BOARD_PID ?>" value="<?php echo $_POST[nameOfPostData::BOARD_PID] ?>">
      <input type="submit" id="submit" formaction="<?php echo boardAddrInfo::FILENAME_DELETE ?>" value="삭제">
      <!-- view.php 를 진행합니다 <게시글 보기 기능> -->
      <!-- 기존에 보고있던 게시글로 돌아가기 위해서 board_id 를 전달합니다. -->
      <input type="hidden" name="<?php echo nameOfPostData::BOARD_ID ?>" value="<?php echo $_SESSION[nameOfPostData::BOARD_ID] ?>">
      <input type="submit" id="submit" formaction="<?php echo boardAddrInfo::FILENAME_VIEW ?>" value="이전">
    </form>
  </fieldset>
</body>

</html>