<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://spoqa.github.io/spoqa-han-sans/css/SpoqaHanSans-kr.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="/JavaScript/Kimbug/CSS/styles.css" />
  <style>
    textarea:focus,
    textarea:hover,
    textarea:active {
      border-color: #1fb6ff;
      outline: none;
      box-shadow: none;
    }

    textarea {
      display: block;
      width: 360px;
      height: 200px;
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

  <fieldset style="border: 1 solid">
    <legend>
      <h1 style="display: inline">글 작성하기</h1>
    </legend>
    <form action="write_process.php" method="POST">
      <label for="title">제목</label>
      <input type="text" id="title" name="title" placeholder="제목을 입력해주세요">
      <label for="userId">작성자</label>
      <input type="text" id="userId" name="userId" placeholder="작성자 이름을 입력해주세요">
      <label for="userPw">비밀번호</label>
      <input type="password" id="userPw" name="userPw" placeholder="비밀번호를 입력해주세요">
      <br>
      <label for="text">본문</label>
      <textarea name="text" id="text" cols="48" rows="10" style="resize: none"></textarea>
      <input type="submit" id="Submit" value="글쓰기" style="background-color:#d3dce6; color:#4e5152">
    </form>
    <form action="list.php" method="GET">
      <input type="submit" id="Submit" value="목록으로" style="background-color:#d3dce6; color:#4e5152">
    </form>
  </fieldset>
</body>

</html>