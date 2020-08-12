<?php
class Book {
  public $title;
  public $author;
  public $description;

  public function __construct($argTitle, $argAuthor, $argDescription) {
    $this->title = $argTitle;
    $this->author = $argAuthor;
    $this->description = $argDescription;
  }
}
