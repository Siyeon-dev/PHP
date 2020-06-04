

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Text and password inputs</title>
    <style>
        body {
            font: 100% arial, helvetica, sans-serif;
        }

        fieldset {
            padding: 0 1em 1em 1em;
        }

        legend {
            padding: 1em;
        }
        /* iframe을 숨기기 위한 css*/
        #if{
            width: 0px;
            height: 0px;
            border: 0px;
        }
    </style>
</head>
<body>

<form action="data_process.php" method="POST">
    <fieldset>
        <legend> 정수 <?php echo $_POST['numOfData']?>개를 입력 하세요!</legend>

        <?php for($i =0; $i < $_POST['numOfData']; $i++): ?>
            <label for="value">입력 값<?php$i + 1?></label>
            <input type="text" id="value" value="" name="value<?php echo $i?>">
            <br>
        <?php endfor; ?>
        <input type="hidden" value="<?php echo $_POST['numOfData']?>"name="numOfData">
        <input type="submit" value="입력하기">
    </fieldset>
</form>


</body>
</html>