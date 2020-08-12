<?php

////////////////////////////////////////////////////
// <-- DB 정보 클래스
class db_info {
    const DB_URL = "127.0.0.1";
    const USER_ID = "root";
    const PASSWD = "Kyanite1!";
    const DB_NAME = "ycj_test";
}

const listPageCount = 5;    // 한 페이지에 보여질 학생의 수
const listBlockCount = 5;   // 블록 당 보여질 페이지의 갯수

$conn = new mysqli(
    db_info::DB_URL,
    db_info::USER_ID,
    db_info::PASSWD,
    db_info::DB_NAME
);
// -->> DB 정보 클래스
////////////////////////////////////////////////
if ($conn->connect_errno) {
    echo "DB 연결 실패";
    exit(-1);
} else {

    // mode 값이 없을 경우 DB에 저장된 순서를 반환합니다.
    echo $controlMode = empty($_POST['mode']) ? null : $_POST['mode'];

    ////////////////////////////////////////////
    // <<-- 입력 버튼 선택시 DB에 해당 학생 정보 INSERT
    if ($controlMode == 'insert') {
        $name = $_POST['name'];
        $kor = $_POST['kor'];
        $eng = $_POST['eng'];
        $math = $_POST['math'];
        $sum = $kor + $eng + $math;
        $avg = $sum / 3;

        $query = "INSERT INTO student(name, kor, eng, math, sum, avg) 
                            VALUES('{$name}', {$kor}, {$eng}, {$math}, {$sum}, {$avg})";

        if (!$conn->query($query))
            echo "쿼리문 실패";
    }
    // -->> 입력 버튼 선택시 DB에 해당 학생 정보 INSERT
    ////////////////////////////////////////////
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Title</title>
        <style>
            ul {
                list-style-type: none;
                margin: 0;
                padding: 0;
                overflow: hidden;
                background-color: #333333;
                text-align: center;
            }

            li {
                display: inline-block;
                margin-left: auto;
                margin-right: auto;
            }

            li a {
                display: block;
                color: white;
                text-align: center;
                padding: 16px;
                text-decoration: none;
            }

            li a:hover {
                background-color: #111111;
            }
        </style>
    </head>

    <body>
        <!-- 입력 Table 시작 -->
        <table style="border:solid 1px black;" style="width: 1500px;">
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <td bgcolor=white>
                    이름 : <input type="text" name="name">
                    국어 : <input type="text" name="kor">
                    영어 : <input type="text" name="eng">
                    수학 : <input type="text" name="math">
                    <input type="submit" value="입력">
                    <input type="hidden" name="mode" value="insert">
                </td>
            </form>

            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <td bgcolor=white>
                    <input type="submit" value="성적 정렬(오름차순)">
                    <input type="hidden" name="mode" value="ascend">
                </td>
            </form>

            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <td bgcolor=white>
                    <input type="submit" value="성적 정렬(내림차순)">
                    <input type="hidden" name="mode" value="descend">
                </td>
            </form>
        </table>
        <!-- 입력 Table 끝 -->

        <!-- 학생 명단 출력 Table 시작-->
        <table style="border:solid 1px black;width:1000px;">
            <tr>
                <td>번호</td>
                <td>이름</td>
                <td>국어</td>
                <td>영어</td>
                <td>수학</td>
                <td>합계</td>
                <td>평균</td>
                <td></td>
            </tr>
        <?php
        // <<-- 사용자가 선택한 버튼에 따라 해당 쿼리문을 출력하는 함수.
        function selectedQuery($controlMode, $conn) {
            switch ($controlMode) {
                    // 테이블 저장 순서대로 출력
                case "insert":
                    $query = "SELECT * FROM student";
                    break;
                    // 성적 오름차순 출력
                case 'ascend':
                    $query = "SELECT * FROM student ORDER BY sum";
                    break;
                    // 성적 내림차순 출력
                case 'descend':
                    $query = "SELECT * FROM student ORDER BY sum DESC";
                    break;
                    // 선택된 학생 삭제
                case 'delete':
                    $query = "DELETE FROM student WHERE num = {$_POST['num']}";
                    $conn->query($query);

                    // <<-- 삭제 후 이전 정렬 상태에 따라 재출력을 위한 쿼리문
                    if ($_POST['selectedModeBefore'] == 'insert')
                        $query = "SELECT * FROM student";
                    else if ($_POST['selectedModeBefore'] == 'ascend')
                        $query = "SELECT * FROM student ORDER BY sum";
                    else if ($_POST['selectedModeBefore'] == 'descend')
                        $query = "SELECT * FROM student ORDER BY sum DESC";
                    else if ($_POST['selectedModeBefore'] == 'delete')
                        $query = "SELECT * FROM student";
                    // -->>
                    break;
            }
            // 유저가 선택한 버튼에 따른 쿼리문을 반환한다.
            // 만약 유저가 page를 선택한다면, 기본 쿼리문을 반환한다.
            return empty($query) ? "SELECT * FROM student" : $query;
        }

        // -->>

        // 유저가 선택한 페이지를 받아온다.
        $page = !empty($_GET['page']) ? $_GET['page'] : 1;
        // 현재 DB에 존재하는 학생의 수를 구한다.
        $result = $conn->query("SELECT * FROM student");
        $numRows = $result->num_rows;


        $blockPointNow = ceil($page / listBlockCount);            // 현재 페이지 블록
        $blockStartPoint = (($blockPointNow - 1) * listBlockCount + 1); // 블록의 시작 번호
        $blockEndPoint = $blockStartPoint + listBlockCount - 1;         // 블록의 끝 번호

        $totalPage = ceil($numRows / listPageCount);              // 전체 페이지 수
        // 블록의 마지막 번호보다 전체 페이지수가 적을 경우
        if ($blockEndPoint > $totalPage) $blockEndPoint = $totalPage;
        $totalBlock = ceil($totalPage / listBlockCount);          // 블럭 총 개수
        $startPoint = ($page - 1) * listPageCount;     // 현재 페이지에 따른 쿼리해야 할 번호의 시작


        //        echo "유저가 선택한 페이지 : ". $page. "<br>";
        //        echo "총 학생 수 : " .$numRows ."<br>";
        //        echo "보여질 학생 수 : " . $listPageCount. "<br>";
        //        echo "보여질 블록 수 : " . $listBlockCount . "<br>";
        //
        //        echo "현재 페이지 블록 : " . $blockPointNow ."<br>";
        //        echo "블록의 시작 번호 : ". $blockStartPoint ."<br>";
        //        echo "블록의 끝 번호 : " . $blockEndPoint. "<br>";
        //
        //        echo "전체 페이지 수 : " . $totalPage. "<br>";
        //        echo "블럭의 총 개수 : " . $totalBlock. "<br>";
        //        echo "쿼리할 시작 번호 : " . $startPoint. "<br>";


        // 사용자가 선택한 버튼에 따른 쿼리문을 반환합니다.
        echo $resultQuery = selectedQuery($controlMode, $conn);
        $result = $conn->query($resultQuery . " limit " . $startPoint . ", " . listPageCount . ";");


        //******** 삭제 했을 때 페이지 뷰가 안된다. *************//


        // <<-- 학생 데이터 출력
        $count = 1;
        while ($row = $result->fetch_array()) {
            echo ("<tr>");
            echo ("<td>{$count}</td>");
            echo ("<td>{$row['name']}</td>");
            echo ("<td>{$row['kor']}</td>");
            echo ("<td>{$row['math']}</td>");
            echo ("<td>{$row['eng']}</td>");
            echo ("<td>{$row['sum']}</td>");
            echo ("<td>{$row['avg']}</td>");
            echo ("<td>
                    <form action={$_SERVER['PHP_SELF']} method='post' >
                        <input type=submit value=\"삭제\">
                        <input type=hidden name=mode value='delete'>
                        <input type=hidden name=num value={$row['num']}>
                        <input type=hidden name=selectedModeBefore value={$controlMode}>
                    </form>
                    </td>");
            echo ("</tr>");

            $count++;
        } // <<--
    }
        ?>
        </table>
        <!-- 학생 명단 출력 Table 끝 -->
        <!-- 페이지네이션 구현 Table 시작-->
        <table>
            <div id="page_num" style="width:1000px; float:left; margin:0 auto; text-align:center;">
                <ul style="display: table; margin: auto; padding:0px;">
                    <?php
                    for ($i = 1; $i <= $totalPage; $i++) {
                        echo "<li><a href='?page={$i}'>[$i]</a></li>";
                    }
                    ?>
                </ul>

            </div>
        </table>
        <!-- 페이지네이션 구현 Table -->
    </body>

    </html>