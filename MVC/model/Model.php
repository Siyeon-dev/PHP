<?php
include_once 'model/Book.php';

class Model {
  private $books;

  public function __construct() {
    $this->books = array(
      "A" => new Book("Book-A", "A", "Description of Book-A"),
      "B" => new Book("Book-B", "B", "Description of Book-B"),
      "C" => new Book("Book-C", "C", "Description of Book-C")
    );
  }

  public function getBookList() {
    return $this->books;
  }

  public function getBook($argTitle) {
    return $this->books[$argTitle];
  }
}
