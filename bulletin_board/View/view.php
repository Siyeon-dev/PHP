<?php
require_once('../Controller/view_process.php');

$postData = getPostOnDB(); // 게시글에 대한 정보를 가지고 있는 객체입니다.
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VIEW</title>
  <link rel="stylesheet" href="https://spoqa.github.io/spoqa-han-sans/css/SpoqaHanSans-kr.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="./Style/styles.css" />
</head>

<body>

  <fieldset style="border: 1 solid; width:370px;">
    <legend>
      <h1 style="display: inline">글 보기</h1>
    </legend>
    <p style="text-align: right;">글번호 - <?php echo $postData->board_id ?></p>
    <!-- 게시글 보기 -->
    <form action="<?php echo boardAddrInfo::FILENAME_LIST ?>" method="POST">
      <label for="title">제목</label>
      <input type="text" id="title" name="<?php echo nameOfPostData::BOARD_TITLE ?>" placeholder="제목을 입력해주세요" value="<?php echo $postData->title ?>" disabled readonly>
      <label for="userId">작성자</label>
      <input type="text" id="userId" name="<?php echo nameOfPostData::USER_ID ?>" placeholder="작성자 이름을 입력해주세요" value="<?php echo $postData->user_name ?>" disabled readonly>
      <label for="userPw">작성일</label>
      <input type="text" id="userPw" name="<?php echo nameOfPostData::USER_PW ?>" placeholder="비밀번호를 입력해주세요" value="<?php echo date_format(date_create($postData->reg_date), "Y년 m월 d일") ?>" disabled readonly>
      <label for="text">본문</label>
      <textarea id="text" name="<?php echo nameOfPostData::BOARD_CONTENTS ?>" cols="48" rows="10" style="resize: none" placeholder="<?php echo $postData->contents ?>" disabled readonly></textarea>

      <!-- 글목록으로 돌아가기 위한 데이터 전송부 -->
      <input type="hidden" name="<?php echo nameOfPostData::PAGINATION_PAGE ?>" value="<?php echo $_SESSION[nameOfPostData::PAGINATION_PAGE] ?>">
      <input type="hidden" name="<?php echo nameOfPostData::PAGINATION_BLOCK ?>" value="<?php echo $_SESSION[nameOfPostData::PAGINATION_BLOCK] ?>">
      <input type="hidden" name="<?php echo nameOfPostData::SEARCH_TYPE ?>" value="<?php echo $_SESSION[nameOfPostData::SEARCH_TYPE] ?>">
      <input type="hidden" name="<?php echo nameOfPostData::SEARCH_TEXT ?>" value="<?php echo $_SESSION[nameOfPostData::SEARCH_TEXT] ?>">
      <input type="submit" id="Submit" value="글목록" style="background-color:#d3dce6; color:#4e5152">
    </form>

    <!-- 글수정 -->
    <form action="<?php echo boardAddrInfo::FILENAME_MODIFY ?>" method="POST">
      <input type="submit" id="Submit" value="글수정" style="background-color:#d3dce6; color:#4e5152">
      <input type="hidden" id="Submit" name="<?php echo nameOfPostData::BOARD_ID ?>" value="<?php echo $postData->board_id ?>">
    </form>

    <!-- 글삭제 -->
    <form action="<?php echo boardAddrInfo::FILENAME_DELETE ?>" method="POST">
      <input type="submit" id="Submit" value="글삭제" style="background-color:#d3dce6; color:#4e5152">
      <input type="hidden" id="Submit" name="<?php echo nameOfPostData::BOARD_ID ?>" value="<?php echo $postData->board_id ?>">
    </form>
    <br>
    <hr>
    <br>
    <strong>
      <p style="text-align: center;">Comment</p>
    </strong>
    <br>

    <!-- Comment 입력부 -->
    <form action="<?php echo boardAddrInfo::FILENAME_WRITE_PROCESS ?>" method="POST">
      <label for="comment-contents">덧글 내용</label>
      <textarea id="comment-contents" name="<?php echo nameOfPostData::COMMENT_CONTENTS ?>"></textarea>
      <label for=" comment-user-name">작성자</label>
      <input type="text" id="comment-user-name" name="<?php echo nameOfPostData::USER_ID ?>">
      <label for="comment-user-passwd">비밀번호</label>
      <input type="password" id="comment-user-passwd" name="<?php echo nameOfPostData::USER_PW ?>">
      <input type="hidden" name="<?php echo nameOfPostData::BOARD_ID ?>" value="<?php echo $postData->board_id ?>">
      <input type="submit" value="등록">
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
        getCommentOnDB($postData);
        ?>
      </tbody>
    </table>
  </fieldset>
</body>

</html>