<?php
    include "db.php";

    $no = $_GET['id'];
    $title = $_POST['title'];
    $name = $_POST['name'];
    $content = $_POST['content'];
    date_default_timezone_set('Asia/Seoul');    //서울 기준 현재 서버시간 설정
    $ut = date("Y-m-d H:i:s");  //업데이트 타임

    $sql = query("update board set title='".$title."', name='".$name."', content='".$content."', ut='".$ut."' where id='".$no."'");

    echo "<script>
            alert('글을 수정하였습니다!!');
            location.href ='../board_read.php?id=".$no."';
          </script>";

?>