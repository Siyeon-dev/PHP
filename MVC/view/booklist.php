<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <table>
    <tr>
      <th scope="col">Title</th>
      <th scope="col">Author</th>
      <th scope="col">Description</th>
    </tr>
    <?php
    foreach ($books as $book) {
      echo '<tr><td><a href="index.php?book=' .
        $book->author . '">' . $book->title . '</a></td>';
      echo '<td>' . $book->author . '</td>';
      echo '<td>' . $book->description . '</td>';
    }
    ?>
  </table>
</body>

</html>