<?php
require_once('../Config/board_conf.php');
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
    <form action="<?php echo boardAddrInfo::FILENAME_DELETE_PROCESS ?>" method="POST">
      <label for="userPw">비밀번호</label>
      <input type="password" id="userPw" name="<?php echo nameOfPostData::USER_ID ?>" placeholder="비밀번호를 입력해주세요">

      <!-- 게시글 혹은 덧글을 지우기 위해서 board_id와 board_pid를 함께 전달합니다. -->
      <input type="hidden" name="<?php echo nameOfPostData::BOARD_ID ?>" value="<?php echo $_POST['board_id'] ?>">
      <input type="hidden" name="<?php echo nameOfPostData::BOARD_PID ?>" value="<?php echo $_POST['board_pid'] ?>">
      <input type="submit" id="Submit" value="삭제" style="background-color:#d3dce6; color:#4e5152">
    </form>

    <!-- view.php 를 진행합니다 <게시글 보기 기능> -->
    <form action="<?php echo boardAddrInfo::FILENAME_VIEW ?>" method="POST">
      <!-- 기존에 보고있던 게시글로 돌아가기 위해서 board_id 를 전달합니다. -->
      <input type="hidden" name="<?php echo nameOfPostData::BOARD_ID ?>" value="<?php echo $_POST['board_id'] ?>">
      <input type="submit" id="Submit" value="이전" style="background-color:#d3dce6; color:#4e5152">
    </form>
  </fieldset>
</body>

</html>