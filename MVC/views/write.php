<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WRITE</title>
  <link rel="stylesheet" href="http://localhost/MVC/views/style/styles.css" />
</head>

<body>

  <fieldset style="border: 1 solid">
    <legend>
      <h1 style="display: inline">글 작성하기</h1>
    </legend>
    <form action="#" method="POST">
      <label for="title">제목</label>
      <input type="text" id="title" name="title" placeholder="제목을 입력해주세요">
      <label for="userId">작성자</label>
      <input type="text" id="userId" name="write" value="<?php echo $_SESSION['userId'] ?>" readonly>
      <label for="text">본문</label>
      <textarea id="text" name="contents"></textarea>
      <!-- write_process.php 로 이동합니다. <게시글 작성> -->
      <input type="submit" id="submit" value="글쓰기" formaction="./list">
      <!-- list.php 로 이동합니다. <게시글 리스트> -->
      <input type="submit" id="submit" value="목록으로" formaction="./list">
    </form>
  </fieldset>
</body>

</html>