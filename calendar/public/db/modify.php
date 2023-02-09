<?php
    // include "db.php";
    require "db.php";

    try {
      $no = $_GET['id'];
      $title = $_POST['title'];
      $name = $_POST['name'];
      $content = $_POST['content'];
      date_default_timezone_set('Asia/Seoul');    //서울 기준 현재 서버시간 설정
      $ut = date("Y-m-d H:i:s");  //업데이트 타임
  
      if ($_POST['password']=="" || $_POST['password']=="null") {
        //db삽입
        $sql = query("update board set title='".$title."', name='".$name."', content='".$content."', ut='".$ut."' where id='".$no."'");
      } else {
        $password = $_POST['password'];
        $sql = query("update board set title='".$title."', name='".$name."', content='".$content."', ut='".$ut."', password='".$password."' where id='".$no."'");
      }
      $result['no'] = $no;
    } catch(exception $e) {

    } finally {
      echo json_encode($result);
    }

?>