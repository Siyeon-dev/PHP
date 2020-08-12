<?php

session_start();



if (!isset($_SESSION['name'])) {
  $_SESSION['name'] = "Siyeon Park";
  $_SESSION['age'] = 24;
  $_SESSION['univ'] = "Yeungjin Univ";
} else {
  echo $_SESSION['name'] . "<br>";
  echo $_SESSION['age'] . "<br>";
  echo $_SESSION['univ'] . "<br>";
  session_destroy();
}

echo session_id();
