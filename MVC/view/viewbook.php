<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <table>
    <?php
    echo "<tr><td>Title</td><td>" . $book->title . "</td></tr>";
    echo "<tr><td>Author</td><td>" . $book->author . "</td></tr>";
    echo "<tr><td>Description</td><td>" . $book->description . "</td></tr>";
    ?>
  </table>
</body>

</html>