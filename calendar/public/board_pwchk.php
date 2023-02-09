<?php
    require "db/db.php";

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
    <link rel="stylesheet" href="./bootstrap-4.0.0/css/bootstrap.min.css">
    <script src="./jquery-3.6.3.min.js"></script>
    <script src="./bootstrap-4.0.0/js/bootstrap.bundle.min.js"></script>
    <title>비밀번호 확인</title>
    <script>
        let password = "<?=$password?>";

        function modifychk(){
            // console.log(password);
            // alert(password);
            let input = document.getElementById("pw_chk").value;
            // console.log(input);
            // alert(input);

            if(input === password) {
                location.href='board_read.php?id=<?=$no?>';
            } else if(input !== null){
                alert('잘못 입력하셨습니다.');
            } else {
            }
        }

        function enterkey() {
            if(window.event.keyCode == 13) {
                let input = document.getElementById("pw_chk").value;
                if(input === password) {
                    location.href='board_read.php?id=<?=$no?>';
                } else if(input !== null){
                    alert('잘못 입력하셨습니다.');
                } else {
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
                    <div>
                        <h2>비밀글 입니다</h2>
                    </div>
                    <hr />
                    <div class="py-2">
                            <label>비밀번호</label>&nbsp;<input type="password" onkeyup="enterkey();" id="pw_chk"/>&nbsp;<button class="btn btn-sm btn-primary" onclick="modifychk();">확인</button>

                    </div>
                    <hr />
                    <div>
                        <div class="float-left">
                            <button type="button" class="btn btn-sm btn-primary" onclick="location.href='board_list.php?page=<?=$page?>'">돌아가기</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

</body>
</html>