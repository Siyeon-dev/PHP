<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://spoqa.github.io/spoqa-han-sans/css/SpoqaHanSans-kr.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="./style/styles.css" />
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
      <h1 style="display: inline">글삭제</h1>
    </legend>
    <form action="delete_process.php" method="POST">
      <label for="userPw">비밀번호</label>
      <input type="password" id="userPw" name="userPw" placeholder="비밀번호를 입력해주세요">
      <input type="submit" id="Submit" value="삭제" style="background-color:#d3dce6; color:#4e5152">
      <!-- delete_process.php 를 진행하기 위해서 board_id 를 전달합니다. -->
      <input type="hidden" name="board_id" value="<?php echo $_POST['board_id'] ?>">
      <input type="hidden" name="board_pid" value="<?php echo $_POST['board_pid'] ?>">
    </form>
    <form action="view.php" method="GET">
      <input type="submit" id="Submit" value="이전" style="background-color:#d3dce6; color:#4e5152">
      <!-- view.php 를 진행하기 위해서 board_id 를 전달합니다. -->
      <input type="hidden" name="board_id" value="<?php echo $_POST['board_id'] ?>">
    </form>
  </fieldset>
</body>

</html>