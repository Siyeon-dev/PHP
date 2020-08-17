<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    /* styles.css */
    @import url(https://spoqa.github.io/spoqa-han-sans/css/SpoqaHanSans-kr.css);

    table {
      border: 1px solid #000;
      border-collapse: collapse;
    }

    td,
    th {
      white-space: nowrap;
      vertical-align: center;
      text-align: center;
      font-size: 13px;
    }

    th {
      padding: 4px 12px;
    }

    td {
      padding: 12px 24px;
      font-size: 12px;
    }

    thead {
      background-color: #000;
      color: #fff;
    }

    tbody th {
      background-color: #1f2d3d;
      color: #fff;
    }

    tbody th[colspan="6"] {
      padding: 10px;
      padding-left: 55px;
      background-color: #f9fafc;
      color: #1f2d3d;
    }

    * {
      margin: 0;
      box-sizing: border-box;
      font-family: "Spoqa Han Sans", sans-serif;
    }

    html {
      font-size: 16px;
      font-family: "Spoqa Han Sans", sans-serif;
      letter-spacing: -0.03em;
      color: #212529;
    }

    body {
      width: 100%;
      height: 1000;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      align-content: center;
    }

    a:link,
    a:visited,
    a:hover,
    a:active {
      color: black;
      text-decoration: none;
    }
  </style>
</head>

<body>
  <!-- 로그인 창 -->
  <?php
  if ($_SESSION['name'] == false) : ?>
    <form action="" method="POST">
      <table>
        <tr>
          <td><label for="userId">ID :</label></td>
          <td><input type="text" name="userId"></td>
          <td><label for="userPw">PW :</label></td>
          <td><input type="password" name="userPw"></td>
          <td><input type="submit" value="Login"></td>
        </tr>
      </table>
    </form>
  <?php else : ?>
    <form action='' method='POST'>
      <table>
        <tr>
          <td><label for='userId'>ID : <?php echo $_SESSION['userId'] ?></label></td>
          <td></td>
          <td><input type='submit' name='logout' value='Logout'></td>
        </tr>
      </table>
    </form>
  <?php endif; ?>

  <table style="width:100% bord; text-align:center;" border="1">
    <thead>
      <tr>
        <th width="50">번호</th>
        <th width="500">제목</th>
        <th width="50">작성자</th>
        <th>조회수</th>
        <th>날짜</th>
      </tr>
    </thead>
    <tbody>
      <!-- 리스트 출력 -->
      <?php
      foreach ($list as $array) {
        echo '<tr align=center>';
        echo "<td>{$array[0]}</td>";
        echo "<td>";
      ?>
        <form action="./view" method="POST">
          <input type="submit" value="<?php echo $array[4] ?>" style="border: none; background: none; ">
          <input type="hidden" name="board_id" value="<?php echo $array[0] ?>">
          <input type="hidden" name="search_type" value="<?php echo $search[0] ?>">
          <input type="hidden" name="search_text" value="<?php echo $search[1] ?>">
          <input type="hidden" name="current_page" value="<?php echo $pagination->currentPage ?>">
          <input type="hidden" name="current_block" value="<?php echo $pagination->currentBlock ?>">
        </form>
      <?php
        echo "</td>";
        echo "<td>{$array[2]}</td>";
        echo "<td>{$array[6]}</td>";
        echo "<td>" . date_format(date_create($array[7]), "Y년 m월 d일") . "</td>";
        echo "</tr>";
      }
      ?>
      <!-- 검색 기능 -->
      <tr>
        <td colspan="5">
          <form method="POST">
            <select name="search_type" id="search">
              <option value="title">제목</option>
              <option value="user_name">작성자</option>
              <option value="contents">내용</option>
              <option value="CONCAT(title,contents)">제목 + 내용</option>
            </select>
            <input type="text" name="search_text">
            <button type="submit">
              검색
            </button>
          </form>
        </td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <!-- 페이지네이션 출력 -->
        <td colspan="5" class="pagination">
          <?php
          // 해당 포스트 값에 따라서 페이지네이션 적용
          // [<<][<] 출력 구문
          // 총 블럭 값과 현재 위치한 블럭 값이 같을 경우
          if ($pagination->currentBlock != 1) {
          ?>
            <form action="" method="POST" style="display: inline">
              <input type="submit" value="<<">
              <input type="hidden">
              <input type="hidden" name="search_type" value="<?= $search[0] ?>">
              <input type="hidden" name="search_text" value="<?= $search[1] ?>">
              <input type="hidden" name="current_page" value="1">
            </form>

            <form action="" method="POST" style="display: inline">
              <input type="submit" value="<">
              <input type="hidden" name="search_type" value="<?= $search[0] ?>">
              <input type="hidden" name="search_text" value="<?= $search[1] ?>">
              <input type="hidden" name="current_page" value="<?= $pagination->currentPage - 1 ?>">
              <input type="hidden" name="current_block" value="<?= $pagination->beforePage ?>">
            </form>
          <?php
          } else {
          ?>
            <form action="" method="POST" style="display: inline">
              <input type="submit" value="<<">
              <input type="hidden" name="search_type" value="<?= $search[0] ?>">
              <input type="hidden" name="search_text" value="<?= $search[1] ?>">
              <input type="hidden" name="current_page" value="1">
            </form>
            <?php
          }
          // 페이지 넘버링 출력 <a href>
          for ($i = $pagination->startPage; $i < $pagination->startPage + PaginationData::numMaxPage; $i++) {
            // 출력되는 페이지는 총 페이지 수를 넘지 않는다.
            if ($i <= $pagination->numPages) {
              // 현재 보고 있는 페이지와 출력되는 페이지가 같을 경우 "빨간색" 으로 표시한다
              if ($pagination->currentPage != $i) { ?>
                <form method='POST' style='display: inline'>
                  <input type='submit' value='<?= $i ?>'>
                  <input type='hidden' name='search_type' value='<?= $search[0] ?>'>
                  <input type='hidden' name='search_text' value='<?= $search[1] ?>'>
                  <input type='hidden' name='current_page' value='<?= $i ?>'>
                  <input type='hidden' name='current_block' value='<?= $pagination->currentBlock ?>'>
                </form>";
              <?php } else { ?>
                <form method='POST' style='display: inline'>
                  <input type='submit' value='<?= $i ?>' style=color:red>
                  <input type='hidden' name='search_type' value='<?= $search[0] ?>'>
                  <input type='hidden' name='search_text' value='<?= $search[1] ?>'>
                  <input type='hidden' name='current_page' value='<?= $i ?>'>
                  <input type='hidden' name='current_block' value='<?= $pagination->currentBlock ?>'>
                </form>
            <?php }
            }
          }
          // [>>][>] 출력 구문
          if ($pagination->numBlocks > $pagination->currentBlock) {
            ?>
            <form action="" method="POST" style="display: inline">
              <input type="submit" value=">">
              <input type="hidden" name="search_type" value="<?= $search[0] ?>">
              <input type="hidden" name="search_text" value="<?= $search[1] ?>">
              <input type="hidden" name="current_page" value="<?= $pagination->startPage + PaginationData::numMaxPage ?>">
              <input type="hidden" name="current_block" value="<?= $pagination->currentBlock + 1 ?>">
            </form>

            <form action="" method="POST" style="display: inline">
              <input type="submit" value=">>">
              <input type="hidden" name="search_type" value="<?= $search[0] ?>">
              <input type="hidden" name="search_text" value="<?= $search[1] ?>">
              <input type="hidden" name="current_page" value="<?= $pagination->numPages ?>">
              <input type="hidden" name="current_block" value="<?= $pagination->numBlocks ?>">
            </form>
          <?php
          } else {
          ?>
            <form action="" method="POST" style="display: inline">
              <input type="submit" value=">>">
              <input type="hidden" name="search_type" value="<?= $search[0] ?>">
              <input type="hidden" name="search_text" value="<?= $search[1] ?>">
              <input type="hidden" name="current_page" value="<?= $pagination->numPages ?>">
              <input type="hidden" name="current_block" value="<?= $pagination->numBlocks ?>">
            </form>
          <?php
          }
          ?>
        </td>
      </tr>
      <tr>
        <td>
          <form action="#" method="POST">
            <!-- 초기 글목록 이동 -->
            <input type="submit" id="submit" formaction="" value="글목록" />
            <!-- 글쓰기 실행 -->
            <?php if ($_SESSION['name'] != false) : ?>
              <input type="submit" id="submit" formaction="./write" value="글쓰기" />
            <?php endif; ?>
          </form>
        </td>
      </tr>
    </tfoot>
    </form>
  </table>
</body>

</html>