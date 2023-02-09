<?php
    // include "db/db.php";
    require "db/db.php";

    //직접입력url 차단
    //$_SERVER['HTTP_REFERER'] : 현재 페이지로 오기 전 이전페이지 주소 값이 담겨 있는 환경변수. 같은 도메인 안에서 진행하더라도 a링크 혹은 form태그 액션 외에는 onclick과 같은 이벤트성 전달방식으로는 리페러가 전달되지 않는다.
    if($_SERVER['HTTP_REFERER'] == '') exit("<script>alert('잘못된 접근입니다.'); history.back();</script>");

    $no = $_GET['id']; //get 함수로 글 정보 가져오기
    
    //list에서 해당 글 페이지로 가기
    $sql2 = query("select * from board");
    $row_num = mysqli_num_rows($sql2);  //전체 레코드 개수
    if($no > $row_num){
        $page = 1;
    }
    else {
        $page = ceil(( $row_num - $no + 1 ) / 10);
    }

    $sql = query("select * from board where id = '".$no."'");
    $board = $sql -> fetch_array();

    //password 가져오기
    $password = $board['password'];
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" type="text/css" href="style.css" /> -->
    <link rel="stylesheet" href="./bootstrap-4.0.0/css/bootstrap.min.css">
    <script src="./jquery-3.6.3.min.js"></script>
    <script src="./bootstrap-4.0.0/js/bootstrap.bundle.min.js"></script>
    <title>상세 글 보기</title>
    <script>
        let password = "<?=$password?>";

        //수정
        function modifychk(){
            if(password==="") {
                location.href='board_modify.php?id=<?=$no?>'
            } else {
                let input = prompt("비밀번호를 입력하세요");
                if(input === password) {
                    location.href='board_modify.php?id=<?=$no?>'
                } else if(input !== null){
                    alert('잘못 입력하셨습니다.');
                } else {
                }
            }
        }
                
        //삭제
        function deletechk(){
            //글 삭제 경고
            let isDel = confirm("정말 삭제하시겠습니까?");
            if (isDel) {
                //글 삭제 - 비번x
                if (password==="") {
                    //ajax 시작
                    $.ajax({
                        url: "db/delete.php?id=<?=$no?>",
                        type: "GET",
                        success: function() {
                            alert('글을 삭제하였습니다!');
                            location.href='board_list.php?page=<?=$page?>'; 
                            }
                    });
                    
                //글 삭제 - 비번 확인
                } else {
                    let input = prompt("비밀번호를 입력하세요");
                    if(input === password) {
                        //ajax 시작
                        $.ajax ({
                        url: "db/delete.php?id=<?=$no?>",
                        type: "GET",
                        success: function() {
                            alert('글을 삭제하였습니다!');
                            location.href='board_list.php?page=<?=$page?>'; 
                        }
                        });
                    } else if(input !== null) {
                        alert('잘못 입력하셨습니다.');
                    } else {

                    }                        
                }
            }
        }
    </script>
</head>

<body>
    <!-- 상세글 화면 -->
    <main class="pt-2">
        <div class="container-fluid px-4">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="my-1">

                        <div class="header">
                            <div class="row">
                                <h5 class="col-1 board-title">제목</h5>
                                <h5 class="col-8"><?=$board['title']?></h5>
                                <p class="col-3"><?="작성 시간 : ".$board['ct']?></p>
                            </div>

                            <?php if($board['ut']) { 
                                echo "<div class='row'>
                                        <h5 class='col-1'></h5>
                                        <p class='col-8'></p>
                                        <p class='col-3'>수정 시간 : ".$board['ut'].
                                        "</p></div>";
                                    }   
                                ?>

                            <hr />
                            <div class="row">
                                <h5 class="col-1 board-title">작성자</h5>
                                <h5 class="col-8"><?=$board['name']?></h5>
                                <p class="col-3"></p>
                            </div>

                        </div>
                        <hr />

                        <div class="mt-4 mb-5">
                            <div class="row">
                                <h5 class="col-1">내용</h5>
                                <h5 class="col-10">
                                    <pre><?=$board['content']?></pre>
                                </h5>
                            </div>
                            
                        </div>
                        <hr />            

                        <div>
                            <div class="float-left">
                                <button type="button" class="btn btn-sm btn-primary" onclick="location.href='board_list.php?page=<?=$page?>'">목록</button>
                            </div>
                            <div class="float-right">
                                <button type="button" class="btn btn-sm btn-primary" id="modifybtn" onclick="modifychk();">수정</button>
                                <button type="button" class="btn btn-sm btn-danger"  id="deletebtn" onclick="deletechk();">삭제</button>
                            <div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>
</html>