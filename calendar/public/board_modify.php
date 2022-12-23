<?php
    include "db/db.php";

    //직접입력url 차단
    if($_SERVER['HTTP_REFERER'] == '') exit("<script>alert('잘못된 접근입니다.'); history.back();</script>");

    $no = $_GET['id'];
    // $sql = query("select * from board where id='".$no."'");
    // $board = $sql->fetch_array();

    //list에서 해당 글 페이지로 가기
    $sql2 = query("select * from board");
    $row_num = mysqli_num_rows($sql2);  //전체 레코드 개수
    $page = ceil(( $row_num - $no + 1 ) / 10);

    //해당 id 글 가져오기
    if ($no <= $row_num) {
        $sql = query("select * from board where id = '".$no."'");
        $board = $sql -> fetch_array();
    } else {    //db에 없는 글 접속시
        echo "<script>alert('잘못된 접근입니다.');
                history.back();
            </script>";
    }
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>글 수정하기</title>

    <script type="text/javascript">
        function modifychk() {
            if (modifyfrm.title.value=="" || modifyfrm.title.value=="null") {
                alert("제목을 입력하세요.");
                modifyfrm.title.focus();  //커서 깜빡임
                return false;   //false반환하면 이후 코드 아무것도 진행x
            }

            // if ((modifyfrm.title.value).match("or")) { //정규식 추가
            //     alert("제목이 올바르지 않습니다");
            //     modifyfrm.title.focus();
            //     return false;
            // }
            
            if (modifyfrm.name.value=="" || modifyfrm.name.value=="null") {
                    alert("작성자를 입력하세요.");
                    modifyfrm.name.focus();  
                    return false;   
            }
            
            if (modifyfrm.content.value=="" || modifyfrm.content.value=="null") {
                    alert("내용을 입력하세요.");
                    modifyfrm.content.focus();  
                    return false;   
            } else {
                document.modifyfrm.submit();
            }
        }
    </script>
</head>

<body>
    <form id="modifyfrm" name="modifyfrm" action="/db/modify.php?id=<?=$no?>" method="post">
    <div class="main">
        <div id="main_main">
            <table id="write_table">
                <tr>
                    <td colspan="2"><h3 class="board-title">자유게시판 글 수정</h3></td>
                </tr>
                
                <tr>
                    <td class="col1">제목</td>
                    <td class="col2"><input id="title" type="text" name="title" value="<?=$board['title']?>"></td>
                </tr>
                <tr>
                    <td class="col1">작성자</td>
                    <td class="col2"><input id="name" type="text" name="name" value="<?=$board['name']?>"></td>
                </tr>
                <tr>
                    <td class="col1" rowspan="2">내용</td>
                    <td class="col2" style="border:none;"><textarea id="content" name="content"><?=$board['content']?></textarea></td>
                </tr>
                <!-- <tr>
                    <td class="col2" style="border:none;">
                        <input class="upload_file" value="첨부파일" placeholder="첨부파일"></input>
                        <label for="select_file">파일 찾기</label>
                        <input type="file" id="select_file"></input>
                    </td>
                </tr> -->
            </table>
        <div>
        
        <div class="buttons">
            <button type="button" id="a-btn" onclick="location.href='board_list.php?page=<?=$page?>'">목록</button>
            <button type="button" id="rgt-btn" onclick="modifychk();">수정</button>
        </div>
    </div>
    </form>
</body>
</html>