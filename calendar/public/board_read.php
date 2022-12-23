<?php
    include "db/db.php";

    //직접입력url 차단
    if($_SERVER['HTTP_REFERER'] == '') exit("<script>alert('잘못된 접근입니다.'); history.back();</script>");

    $no = $_GET['id']; //get 함수로 글 정보 가져오기
    
    //list에서 해당 글 페이지로 가기
    $sql2 = query("select * from board");
    $row_num = mysqli_num_rows($sql2);  //전체 레코드 개수
    $page = ceil(( $row_num - $no + 1 ) / 10);

    //해당 id 글 가져오기
    if ($no <= $row_num) {
        $sql = query("select * from board where id = '".$no."'");
        $board = $sql -> fetch_array();
    } else {    //db에 없는 글 번호
        echo "<script>alert('잘못된 접근입니다.');
                history.back();
              </script>";
    }

    //password 가져오기
    $password = $board['password'];
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>상세 글 보기</title>
    <script type="text/javascript">
            //수정
        function pwchkmdf() {
            let password = "<?=$password?>";
            // console.log(password);
            
            if(password=="" || password==null) {
                location.href='board_modify.php?id=<?=$no?>'
            } else {
                let input = prompt("비밀번호를 입력하세요");

                if(input == password) {
                    location.href='board_modify.php?id=<?=$no?>'
                } else {
                    alert('잘못 입력하셨습니다.');
                } 
            }
        }
            //삭제
        function pwchkdel() {
            let password = "<?=$password?>";
            // console.log(password);

            if(password=="" || password==null) {
                location.href='db/delete.php?id=<?=$no?>'
            } else {
                let input = prompt("비밀번호를 입력하세요");

                if(input == password) {
                    location.href='db/delete.php?id=<?=$no?>'
                } else {
                    alert('잘못 입력하셨습니다.');
                } 
            }
        }
    </script>
</head>

<body>
    <!-- 상세글 화면 -->
    <div id="board_read">
        <h2><?=$board['title']?></h2>

        <div id="user_info">
            <label id="ui_left"><h4><?="작성자 : ".$board['name']?></h4></label>
            <label id="ui_right"><h4><?="작성 시간 : ".$board['ct']?></h4></label>
            <?php 
                if($board['ut']) { 
                    echo '<label id="ui_right"><h4>';
                    echo "수정 시간 : ".$board['ut'];
                    echo '</h4></label>';
                }   
            ?>
        </div>
        <div id="line"></div>
        
        <div id="read_content">
            <pre><?=$board['content']?></pre>
        </div>

        <div id="line"></div>
        <div id="menu">
            <ul>
                <!-- (기존) a href ="/" 뜻 : 디폴트 문서로 이동 (주로 index) -->
                <!-- <li><button type="button" onclick="location.href='/'">목록</button></li> -->
                <li><button type="button" onclick="location.href='board_list.php?page=<?=$page?>'">목록</button></li>
                <li><button type="button" onclick="pwchkmdf();">수정</button></li>
                <li><button type="button" onclick="pwchkdel();">삭제</button></li>
            </ul>
        </div>
    </div>
</body>
</html>