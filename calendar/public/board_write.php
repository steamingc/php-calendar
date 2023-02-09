<?php
    // include "db/db.php";
    require "db/db.php";

    //직접입력url 차단
    if($_SERVER['HTTP_REFERER'] == '')
    exit("<script>alert('잘못된 접근입니다.'); history.back();</script>");

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
    <title>글 쓰기</title>
    <script>
        function insertchk() {
            if (writefrm.title.value==="") {
                alert('제목을 입력하세요');
                writefrm.title.focus();  //커서 깜빡임
                return false;           //false반환하면 이후 코드 아무것도 진행x
            } else if (writefrm.name.value==="") {
                alert('작성자를 입력하세요');
                writefrm.name.focus();  
                return false;   
            } else if (writefrm.content.value==="") {
                alert('내용을 입력하세요');
                writefrm.content.focus();  
                return false;   
            } else {
                //ajax시작
                $.ajax({
                    url: "/db/insert.php",
                    type: "POST",
                    data: $('#writefrm').serialize(),
                    dataType : "json",
                    success: function(result) {
                        alert('글을 등록하였습니다!');
                        location.href = `./board_read.php?id=${result.no}`;
                        }
                    });
                }
            } 
    </script>
</head>

<body>
    <form id="writefrm" name="writefrm" onsubmit="return insertchk()" method="POST">
    <main class="pt-2">
        <div class="container-fluid px-4">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="my-1">
                            <div class="text-center py-2">
                                <h1>☆────〃방명록 글 쓰기〃────☆</h1>
                            </div>
                            <hr />

                            <div class="row">
                                <h5 class="col-2 text-center">제목</h5>
                                <h5 class="col-10">
                                    <input class="container-fluid" id="title" type="text" name="title" placeholder="제목을 입력하세요" onfocus="this.placeholder =''" onblur="this.placeholder='제목을 입력하세요'">
                                </h5>
                            </div>
                            <hr />

                            <div class="row">
                                <h5 class="col-2 text-center">작성자</h5>
                                <h5 class="col-10">
                                    <input class="container-fluid" id="name" type="text" name="name" placeholder="작성자명을 입력하세요" onfocus="this.placeholder =''" onblur="this.placeholder='작성자명을 입력하세요'">
                                </h5>
                            </div>
                            <hr />

                            <div class="mt-4 mb-5">
                                <div class="row">
                                    <h5 class="col-2 text-center">내용</h5>
                                    <h5 class="col-10"><textarea class="mt-2 container-fluid" rows="10" id="content" name="content"></textarea></h5>
                                </div>
                            </div>
                            <hr />  
                            
                            <div class="row">
                                <h5 class="col-2 text-center">비밀번호</h5>
                                <h5 class="col-10">
                                    <input class="container-fluid" id="password" type="text" name="password">
                                </h5>
                            </div>
                            <hr />

                        <div>
                            <div class="float-left">
                                <button type="button" class="btn btn-sm btn-primary" id="a-btn" onclick="history.back()">목록</button>
                            </div>
                            <div class="float-right">
                                <button type="submit" class="btn btn-sm btn-primary" id="rgt-btn">등록</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    </form>
</body>
</html>