<?php
require_once('../Config/board_conf.php');
require_once('../Config/board_util.php');
require_once('../Model/db_info.php');
require_once('../Model/db_query.php');
require_once('../Controller/modify_process.php');

$postData = getPostOnDB($_POST[nameOfPostData::BOARD_ID]); // 게시글에 대한 정보를 가지고 있는 객체입니다.
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MODIFY</title>
  <link rel="stylesheet" href="https://spoqa.github.io/spoqa-han-sans/css/SpoqaHanSans-kr.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="./style/styles.css" />
</head>

<body>
  <fieldset style="border: 1 solid">
    <legend>
      <h1 style="display: inline">수정하기</h1>
    </legend>
    <p style="text-align: right;">글번호 - <?php echo $postData->board_id ?></p>

    <!-- modify_process.php 를 진행합니다 <글 수정 기능> -->
    <form action="<?php echo boardAddrInfo::FILENAME_MODIFY_PROCESS ?>" method="POST">
      <label for="title">제목</label>
      <input type="text" id="title" name="<?php echo nameOfPostData::BOARD_TITLE ?>" placeholder="제목을 입력해주세요" value="<?php echo $postData->title ?>">
      <label for="userId">작성자</label>
      <input type="text" id="userId" name="<?php echo nameOfPostData::USER_ID ?>" placeholder="작성자 이름을 입력해주세요" value="<?php echo $postData->user_name ?>">
      <label for="userPw">비밀번호</label>
      <input type="password" id="userPw" name="<?php echo nameOfPostData::USER_PW ?>" placeholder="비밀번호를 입력해주세요" value="">
      <label for="text">본문</label>
      <textarea id="text" name="<?php echo nameOfPostData::BOARD_CONTENTS ?>"><?php echo $postData->contents ?></textarea>

      <!-- 수정될 게시글을 지정하기위해 board_id 를 전달합니다. -->
      <input type="hidden" name="<?php echo nameOfPostData::BOARD_ID ?>" value="<?php echo $postData->board_id ?>">
      <input type="submit" id="Submit" value="수정완료" style="background-color:#d3dce6; color:#4e5152">
    </form>

    <!-- view.php 를 진행합니다 <게시글 보기 기능> -->
    <form action="<?php echo boardAddrInfo::FILENAME_VIEW ?>" method="POST">
      <input type="submit" id="Submit" value="이전" style="background-color:#d3dce6; color:#4e5152">
      <input type="hidden" name="<?php echo nameOfPostData::BOARD_ID ?>" value="<?php echo $postData->board_id ?>">
    </form>
  </fieldset>
</body>

</html>