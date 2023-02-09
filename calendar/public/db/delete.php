<?php
    // include "db.php";
    require "db.php";

    try {
        //get함수로 해당 글 인덱스 가져오기
        $no = $_GET['id'];
    
        //삭제 쿼리
        query("delete from board where id='".$no."'");
        
    } catch (exception $e) {
        
    }   
?>