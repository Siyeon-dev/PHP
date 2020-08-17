<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MODIFY</title>
  <link rel="stylesheet" href="http://localhost/MVC/views/style/styles.css" />
</head>

<body>
  <fieldset style="border: 1 solid">
    <legend>
      <h1 style="display: inline">수정하기</h1>
    </legend>
    <p style="text-align: right;">글번호 - <?php echo $article[0]['board_id'] ?></p>
    <form action="" method="POST">
      <label for="title">제목</label>
      <input type="text" id="title" name="title" value="<?php echo $article[0]['title'] ?>">
      <label for="text">본문</label>
      <textarea id="text" name="contents"><?php echo $article[0]['contents'] ?></textarea>
      <!-- 수정될 게시글을 지정하기위해 board_id 를 전달합니다. -->
      <input type="submit" id="submit" value="수정완료" formaction="./view">
      <input type="hidden" name="board_id" value="<?php echo $article[0]['board_id'] ?>">
      <input type="hidden" name="view_options" value="modify">
      <!-- view.php 를 진행합니다 <게시글 보기 기능> -->
    </form>
    <!-- 글보기로 이동 -->
    <form action="" method="POST">
      <input type="submit" id="submit" value="이전" formaction="./view">
    </form>

  </fieldset>
</body>

</html>