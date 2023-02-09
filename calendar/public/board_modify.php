<?php
    // include "db/db.php";
    require "db/db.php";

    //직접입력url 차단
    if($_SERVER['HTTP_REFERER'] == '') exit("<script>alert('잘못된 접근입니다.'); history.back();</script>");

    $no = $_GET['id'];
    // $sql = query("select * from board where id='".$no."'");
    // $board = $sql->fetch_array();

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
    <title>글 수정하기</title>
    <script>
        function modifychk() {
            if (modifyfrm.title.value==="") {
                alert('제목을 입력하세요');
                modifyfrm.title.focus();
                return false;
            } else if (modifyfrm.name.value==="") {
                    alert('작성자를 입력하세요');
                    modifyfrm.name.focus();  
                    return false;   
            } else if (modifyfrm.content.value==="") {
                    alert('내용을 입력하세요');
                    modifyfrm.content.focus();  
                    return false;   
            } else { 
                $.ajax({
                    url: "/db/modify.php?id=<?=$no?>",
                    type: "POST",
                    data: $('#modifyfrm').serialize(),
                    dataType : "json",
                    success: function(result) {
                        alert('글을 수정하였습니다!');
                        location.href = `./board_read.php?id=${result.no}`; 
                    }
                });
            }
        }
    </script>
</head>

<body>
    <form id="modifyfrm" name="modifyfrm" onsubmit="return modifychk();" method="post">
    <main class="pt-2">
        <div class="container-fluid px-4">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="my-1">
                            <div class="text-center py-2">
                                <h1>☆────〃방명록 글 수정〃────☆</h1>
                            </div>
                            <hr />

                            <div class="row">
                                <h5 class="col-2 text-center">제목</h5>
                                <h5 class="col-10">
                                    <input class="container-fluid" id="title" type="text" name="title" value="<?=$board['title']?>">
                                </h5>
                            </div>
                            <hr />

                            <div class="row">
                                <h5 class="col-2 text-center">작성자</h5>
                                <h5 class="col-10">
                                    <input class="container-fluid" id="name" type="text" name="name" value="<?=$board['name']?>">
                                </h5>
                            </div>
                            <hr />

                            <div class="mt-4 mb-5">
                                <div class="row">
                                    <h5 class="col-2 text-center">내용</h5>
                                    <h5 class="col-10"><textarea class="mt-2 container-fluid" rows="10" id="content" name="content"><?=$board['content']?></textarea></h5>
                                </div>
                            </div>
                            <hr />
                            
                            <?php
                                if(!($board['password']==""||$board['password']==null)){
                                    echo "<div class='row'>
                                    <h5 class='col-2 text-center'>비밀번호</h5>
                                    <h5 class='col-10'>
                                        <input class='container-fluid' id='password' type='text' name='password' value='".$board['password']."'>
                                    </h5>
                                </div>
                                <hr />";
                                }
                            ?>


                        <div>
                            <div class="float-left">
                                <button type="button" class="btn btn-sm btn-primary" id="a-btn" onclick="location.href='board_list.php?page=<?=$page?>'">목록</button>
                            </div>
                            <div class="float-right">
                                <button type="submit" class="btn btn-sm btn-primary" id="rgt-btn">수정</button>
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