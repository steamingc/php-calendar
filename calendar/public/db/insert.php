<?php 
    // include "db.php";
    require "db.php";

    try {
        //post함수로 입력값 가져오기
        $title = $_POST['title'];
        $name = $_POST['name'];
        $content = $_POST['content'];
        date_default_timezone_set('Asia/Seoul');    //서울 기준 현재 서버시간 설정
        $ct = date("Y-m-d H:i:s");  //글 작성 시간

        if ($_POST['password']=="" || $_POST['password']=="null") {
            //db삽입
            $sql = query("insert into board (title, name, content, ct) values('".$title."', '".$name."', '".$content."', '".$ct."')");
        } else {
            $password = $_POST['password'];
            $sql = query("insert into board (title, name, content, ct, password) values('".$title."', '".$name."', '".$content."', '".$ct."', '".$password."')");
        }
        $result['no'] = mysqli_insert_id($conn);
    } catch (exception $e) {

    } finally {
        echo json_encode($result);
    }
?>