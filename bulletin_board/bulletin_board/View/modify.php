<?php
require_once('../Config/board_conf.php');
require_once('../Config/board_util.php');
require_once('../Model/db_info.php');
require_once('../Model/db_query.php');
require_once('../Controller/modify_process.php');

if (!array_key_exists('name', $_SESSION)) {
  isNOTuser();
}

$postData = getPostOnDB(nameOfPostData::BOARD_ID, $_SESSION[nameOfPostData::BOARD_ID]); // 게시글에 대한 정보를 가지고 있는 객체입니다.

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
    <p style="text-align: right;">글번호 - <?php echo $postData[1]->board_id ?></p>
    <form action="#" method="POST">
      <label for="title">제목</label>
      <input type="text" id="title" name="<?php echo nameOfPostData::BOARD_TITLE ?>" value="<?php echo $postData[1]->title ?>">
      <label for="text">본문</label>
      <textarea id="text" name="<?php echo nameOfPostData::BOARD_CONTENTS ?>"><?php echo $postData[1]->contents ?></textarea>
      <!-- modify_process.php 를 진행합니다 <글 수정 기능> -->
      <!-- 수정될 게시글을 지정하기위해 board_id 를 전달합니다. -->
      <input type="submit" id="submit" value="수정완료" formaction="<?php echo boardAddrInfo::FILENAME_MODIFY_PROCESS ?>">
      <input type="hidden" name="<?php echo nameOfPostData::BOARD_ID ?>" value="<?php echo $postData[1]->board_id ?>">
      <!-- view.php 를 진행합니다 <게시글 보기 기능> -->
      <input type="submit" id="submit" value="이전" formaction="<?php echo boardAddrInfo::FILENAME_VIEW ?>">
    </form>

  </fieldset>
</body>

</html>