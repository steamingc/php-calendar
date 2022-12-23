<?php
    //한글 깨짐 방지를 위한 utf-8 인코딩
    header('Content-Type: text/html; charset=utf-8');

    $host = 'localhost';
    $user = 'root';
    $pw = "1234";
    $dbName = 'notice';

    $conn = new mysqli($host, $user, $pw, $dbName);

    function query($query) {
        global $conn;       //global : 외부에서 선언된 $query를 함수 내에서 쓸 수 있도록 해준다
        return $conn->query($query);
    }

    $conn = mysqli_connect($host, $user, $pw, $dbName);
    $conn->set_charset("utf8"); //한글 인코딩
?>