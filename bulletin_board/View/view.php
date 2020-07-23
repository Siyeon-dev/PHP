<?php
require_once('../Controller/view_process.php');
require_once('../Config/board_conf.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VIEW</title>
  <link rel="stylesheet" href="https://spoqa.github.io/spoqa-han-sans/css/SpoqaHanSans-kr.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="./Style/styles.css" />
  <style>
    h1 {
      width: 450px;
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
  </style>
</head>

<body>
  <fieldset style="border: 1 solid; width:370px;">
    <legend>
      <h1 style="display: inline">글 보기</h1>
    </legend>
    <p style="text-align: right;">글번호 - <?= $postData[1]->board_id ?></p>
    <!-- 게시글 보기 -->
    <form action="#" method="GET">
      <label for="title">제목</label>
      <input type="text" id="title" name="<?= nameOfPostData::BOARD_TITLE ?>" value="<?= $postData[1]->title ?>" disabled readonly>
      <label for="userId">작성자</label>
      <input type="text" id="userId" name="<?= nameOfPostData::USER_ID ?>" value="<?= $postData[1]->user_name ?>" disabled readonly>
      <label for="reg_data">작성일</label>
      <input type="text" id="reg_data" name="<?= nameOfPostData::BOARD_REG_DATE ?>" value="<?= date_format(date_create($postData[1]->reg_date), "Y년 m월 d일") ?>" disabled readonly>
      <label for="text">본문</label>
      <textarea id="text" name="<?= nameOfPostData::BOARD_CONTENTS ?>" style="resize: none" placeholder="<?= $postData[1]->contents ?>" disabled readonly></textarea>

      <!-- 글목록으로 돌아가기 위한 데이터 전송부 -->
      <input type="hidden" name="<?= nameOfPostData::PAGINATION_PAGE ?>" value="<?= $_SESSION[nameOfPostData::PAGINATION_PAGE] ?>">
      <input type="hidden" name="<?= nameOfPostData::PAGINATION_BLOCK ?>" value="<?= $_SESSION[nameOfPostData::PAGINATION_BLOCK] ?>">
      <input type="hidden" name="<?= nameOfPostData::SEARCH_TYPE ?>" value="<?= $_SESSION[nameOfPostData::SEARCH_TYPE] ?>">
      <input type="hidden" name="<?= nameOfPostData::SEARCH_TEXT ?>" value="<?= $_SESSION[nameOfPostData::SEARCH_TEXT] ?>">

      <input type="hidden" name="<?= nameOfPostData::BOARD_ID ?>" value="<?= $postData[1]->board_id ?>">
      <!-- 글목록 -->
      <input type="submit" id="submit" value="글목록" formaction="<?= boardAddrInfo::FILENAME_LIST ?>">
      <!-- 글수정 -->
      <input type="submit" id="submit" value="글수정" formaction="<?= boardAddrInfo::FILENAME_MODIFY ?>">
      <!-- 글삭제 -->
      <input type="submit" id="submit" value="글삭제" formaction="<?= boardAddrInfo::FILENAME_DELETE ?>">

    </form>
    <br>
    <hr>
    <br>
    <strong>
      <p style="text-align: center;">Comment</p>
    </strong>
    <br>
    <!-- Comment 입력부 -->
    <form action="<?= boardAddrInfo::FILENAME_WRITE_PROCESS ?>" method="POST">
      <label for="comment-contents">덧글 내용</label>
      <textarea id="comment-contents" name="<?= nameOfPostData::BOARD_CONTENTS ?>" style="height: 50px;"></textarea>
      <label for=" comment-user-name">작성자</label>
      <input type="text" id="comment-user-name" name="<?= nameOfPostData::USER_ID ?>">
      <label for="comment-user-passwd">비밀번호</label>
      <input type="password" id="comment-user-passwd" name="<?= nameOfPostData::USER_PW ?>">
      <input type="hidden" name="<?= nameOfPostData::BOARD_PID ?>" value="true">
      <input type="hidden" name="<?= nameOfPostData::BOARD_TITLE ?>" value="----This is comment----">
      <input type="hidden" name="<?= nameOfPostData::BOARD_ID ?>" value="<?= $postData[1]->board_id ?>">
      <input type="submit" id="submit" value="등록">
    </form>

    <!-- Comment 출력부 -->
    <table style="width:450px; text-align:center;" border=" 1">
      <thead>
        <tr>
          <th style="width: 70px">작성자</th>
          <th style="width: 140px">내용</th>
          <th style="width: 30px">날짜</th>
          <th style="width: 10px">삭제</th>
        </tr>
      </thead>

      <!-- Comment List -->
      <tbody>
        <br>
        <?php
        $commentData = getPostOnDB(nameOfPostData::BOARD_PID, $_SESSION[nameOfPostData::BOARD_ID]);
        prtCommentData($commentData[0]);
        ?>
      </tbody>
    </table>
  </fieldset>
</body>

</html>