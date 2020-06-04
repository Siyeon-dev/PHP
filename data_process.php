<?php
require_once ('data_process_util.php');

$array = [];
for($i = 0; $i < $_POST['numOfData']; $i++) {
    $array[$i] = $_POST['value'.$i];
}
?>
<table class="a">
    <tr>
        <th><?php echo "입력 값 : ";?></th>
        <th><?php foreach ($array as $value)
                echo $value." "; ?> </th>
    </tr>
    <tr>
        <th><?php  echo "<br>총합 : "; ?></th>
        <th><?php echo sum($array);?></th>
    </tr>
    <tr>
        <th><?php echo "<br>소팅 후 : ";?></th>
        <th><?php sort_bubble($array, true);
            foreach ($array as $value)
                echo $value." ";?></th>
    </tr>
    <tr>
        <th><?php echo "<br>중간 값 : ";?> </th>
        <th><?php  echo  median($array);?></th>
    </tr>
</table>
