<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <fieldset style="width:200px">
    <legend style="background-color:aquamarine">
      글쓰기
    </legend>
    <form action="write_process.php" method="POST">
      <label for="title">제목</label>
      <input type="text" id="title" name="title">
      <br>
      <label for="userId">작성자</label>
      <input type="text" id="userId" name="userId">
      <br>
      <label for="userPw">비밀번호</label>
      <input type="password" id="userPw" name="userPw">
      <br>
      <textarea name="text" id="text" cols="30" rows="10"></textarea>
      <br>
      <input type="submit" value="글쓰기">
    </form>
  </fieldset>
</body>

</html>