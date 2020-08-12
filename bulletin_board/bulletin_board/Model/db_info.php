<?php

class db_info {
  const USER_NAME = "root";
  const SERVER_URL = "127.0.0.1";
  const DB_PASSWD = "Kyanite1!";
  const DB_NAME = "ycj_test";
}

// <<-- DB 연결 함수 connectDB
function connectDB() {
  $conn = new mysqli(db_info::SERVER_URL, db_info::USER_NAME, db_info::DB_PASSWD, db_info::DB_NAME);

  if ($conn->connect_errno) {
    echo "error" . $conn->errno;
    exit(-1);
  }

  return $conn;
}
// --> DB 연결 함수 connectDB
