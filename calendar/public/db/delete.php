<?php
    include "db.php";

    //get함수로 해당 글 인덱스 가져오기
    $no = $_GET['id'];

    //삭제 쿼리
    query("delete from board where id='".$no."'");

    //삭제 후 인덱스 재정렬
    query("SET @cnt = 0");
    query("UPDATE board SET id = @cnt:= @cnt + 1");
    query("ALTER TABLE board AUTO_INCREMENT = 1");
?>

<script>
alert('글을 삭제하였습니다!!');
location.href ='../board_list.php';
</script>"

