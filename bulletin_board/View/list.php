<?php
require_once('../Controller/list_process.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://spoqa.github.io/spoqa-han-sans/css/SpoqaHanSans-kr.css" rel="stylesheet" type="text/css" />
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
      <?php
      getPostListOnDB($postList, $paginationObj, $arraySearchedData); // DB로부터 글 가져오고, 출력하기
      ?>
      <tr>
        <td colspan="5">
          <form method="GET">
            <select name="<?php echo nameOfPostData::SEARCH_TYPE ?>" id="search">
              <option value="title">제목</option>
              <option value="user_name">작성자</option>
              <option value="contents">내용</option>
              <option value="CONCAT(title,contents)">제목 + 내용</option>
            </select>
            <input type="text" name="<?php echo nameOfPostData::SEARCH_TEXT ?>">
            <button type="submit">
              검색
            </button>
          </form>
        </td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="5"><?php prtPaginationData($paginationObj, $arrayPureSearch) ?></td>
      </tr>
      <tr>
        <td>
          <form action="#" method="POST">
            <!-- 글쓰기 실행 -->
            <input type="submit" id="submit" formaction="<?php echo boardAddrInfo::FILENAME_WRITE ?>" value="글쓰기" />
            <!-- 초기 글목록 이동 -->
            <input type="submit" id="submit" formaction="<?php echo boardAddrInfo::FILENAME_LIST ?>" value="글목록" />
          </form>
        </td>
      </tr>
    </tfoot>
    </form>
  </table>
</body>

</html>