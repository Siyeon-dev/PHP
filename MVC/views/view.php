<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VIEW</title>
  <link rel="stylesheet" href="https://spoqa.github.io/spoqa-han-sans/css/SpoqaHanSans-kr.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="http://localhost/MVC/views/style/styles.css" />
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
    <p style="text-align: right;">글번호 - <?= $article[0]['board_id'] ?></p>
    <!-- 게시글 보기 -->
    <form action="#" method="POST">
      <label for="title">제목</label>
      <input type="text" id="title" name="title" value="<?= $article[0]['title'] ?>" disabled>
      <label for="userId">작성자</label>
      <input type="text" id="userId" name="userId" value="<?= $article[0]['user_name'] ?>" disabled>
      <label for="reg_data">작성일</label>
      <input type="text" id="reg_zdata" name="reg_date" value="<?= date_format(date_create($article[0]['reg_date']), "Y년 m월 d일") ?>" disabled>
      <label for="text">본문</label>
      <textarea id="text" name="contents" style="resize: none" placeholder="<?= $article[0]['contents'] ?>" disabled></textarea>

      <!-- 글목록으로 돌아가기 위한 데이터 전송부 /페이지네이션 유지/  -->
      <input type="hidden" name="current_page" value="<?= $_SESSION['current_page'] ?>">
      <input type="hidden" name="current_block" value="<?= $_SESSION['current_block'] ?>">
      <input type="hidden" name="search_type" value="<?= $_SESSION['search_type'] ?>">
      <input type="hidden" name="search_text" value="<?= $_SESSION['search_text'] ?>">

      <input type="hidden" name="board_id" value="<?= $article[0]['board_id'] ?>">
      <!-- 글목록 -->
      <input type="submit" id="submit" value="글목록" formaction="./list">
    </form>
    <?php if ($resultUserValid == true) : ?>
      <form action="" method="POST">
        <!-- 글수정 -->
        <input type="submit" id="submit" value="글수정" formaction="./modify">
        <input type="hidden" name="view_options" value="modify">
      </form>
      <form action="" method="POST">
        <!-- 글삭제 -->
        <input type="submit" id="submit" value="글삭제" formaction="./view">
        <input type="hidden" name="view_options" value="delete">
      </form>
    <?php endif; ?>

    <br>
    <hr>
    <br>
    <strong>
      <p style="text-align: center;">Comment</p>
    </strong>
    <br>
    <!-- Comment 입력부 -->
    <?php if ($_SESSION['name'] != false) : ?>
      <form action="" method="POST">
        <label for="comment-contents">덧글 내용</label>
        <textarea id="comment-contents" name="contents" style="height: 50px;"></textarea>
        <input type="hidden" name="board_pid" value="true">
        <input type="hidden" name="board_title" value="----This is comment----">
        <input type="hidden" name="board_id" value="<?= $article[0]['board_id'] ?>">
        <input type="hidden" name="view_options" value="comment">
        <input type="submit" id="submit" value="등록">
      </form>
    <?php endif; ?>
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
        if (isset($comment)) {
          foreach ($comment as $key) {
            echo '<tr align=center>';
            echo "<td>{$key['user_name']}</td>";
            echo "<td>{$key['contents']}</td>";
            echo "<td>" . date_format(date_create($key['reg_date']), "Y/m/d") . "</td>";
            if ($resultUserValid == true) {
              echo "<td><form action='./view'method='POST'><button>삭제</button>";
              echo "<input type='hidden' name='board_id' value='" . $_SESSION['board_id'] . "'>";
              echo "<input type='hidden' name='board_pid' value='" . $key['board_id'] . "'>";
              echo "<input type='hidden' name='view_options' value='delete'></form></td>";
            } else {
              echo "<td></td>";
            }
            echo "</tr>";
          }
        }
        ?>
      </tbody>
    </table>
  </fieldset>
</body>

</html>