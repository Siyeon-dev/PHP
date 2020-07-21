<?php
require_once('../Config/board_conf.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WRITE</title>
  <link rel="stylesheet" href="https://spoqa.github.io/spoqa-han-sans/css/SpoqaHanSans-kr.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="./Style/styles.css" />
</head>

<body>

  <fieldset style="border: 1 solid">

    <legend>
      <h1 style="display: inline">글 작성하기</h1>
    </legend>

    <!-- write_process.php 를 진행합니다. <게시글 작성> -->
    <form action="<?php echo boardAddrInfo::FILENAME_WRITE_PROCESS ?>" method="POST">
      <label for="title">제목</label>
      <input type="text" id="title" name="<?php echo nameOfPostData::BOARD_TITLE ?>" placeholder="제목을 입력해주세요">
      <label for="userId">작성자</label>
      <input type="text" id="userId" name="<?php echo nameOfPostData::USER_ID ?>" placeholder="작성자 이름을 입력해주세요">
      <label for="userPw">비밀번호</label>
      <input type="password" id="userPw" name="<?php echo nameOfPostData::USER_PW ?>" placeholder="비밀번호를 입력해주세요"><br>
      <label for="text">본문</label>
      <textarea id="text" name="<?php echo nameOfPostData::BOARD_CONTENTS ?>"></textarea>

      <input type="submit" id="Submit" value="글쓰기" style="background-color:#d3dce6; color:#4e5152">
    </form>

    <!-- list.php 를 진행합니다. <게시글 확인> -->
    <form action="<?php echo boardAddrInfo::FILENAME_LIST ?>" method="POST">
      <input type="submit" id="Submit" value="목록으로" style="background-color:#d3dce6; color:#4e5152">
    </form>
  </fieldset>
</body>

</html>