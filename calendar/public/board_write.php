<?php
    include "db/db.php";

    //직접입력url 차단
    if($_SERVER['HTTP_REFERER'] == '') exit("<script>alert('잘못된 접근입니다.'); history.back();</script>");

?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>글 쓰기</title>

    <script type="text/javascript">
        function insertchk() {
            if (writefrm.title.value=="" || writefrm.title.value=="null") {
                alert("제목을 입력하세요.");
                writefrm.title.focus();  //커서 깜빡임
                return false;   //false반환하면 이후 코드 아무것도 진행x
            }

            // if ((writefrm.title.value).match("or")) { //정규식 추가
            //     alert("제목이 올바르지 않습니다");
            //     writefrm.title.focus();
            //     return false;
            // }
            
            if (writefrm.name.value=="" || writefrm.name.value=="null") {
                    alert("작성자를 입력하세요.");
                    writefrm.name.focus();  
                    return false;   
            }
            
            if (writefrm.content.value=="" || writefrm.content.value=="null") {
                    alert("내용을 입력하세요.");
                    writefrm.content.focus();  
                    return false;   
            } else {
                document.writefrm.submit();
            }
        }
    </script>

</head>

<body>
    <form id="writefrm" name="writefrm" action="/db/insert.php" method="post">
    <div class="main">
        <div id="main_main">
            <table id="write_table">
                <tr>
                    <td colspan="2"><h3 class="board-title">자유게시판 글 작성</h3></td>
                </tr>
                
                <tr>
                    <td class="col1">제목</td>
                    <td class="col2"><input id="title" type="text" name="title" placeholder="제목을 입력하세요" onfocus="this.placeholder =''" onblur="this.placeholder='제목을 입력하세요'"></td>
                </tr>
                <tr>
                    <td class="col1">작성자</td>
                    <td class="col2"><input id="name" type="text" name="name" placeholder="작성자명을 입력하세요" onfocus="this.placeholder =''" onblur="this.placeholder='작성자명을 입력하세요'"></td>
                </tr>
                <tr>
                    <td class="col1">내용</td>
                    <!-- <td class="col1" rowspan="2">내용</td> // 첨부파일 추가 했을 때-->
                    <td class="col2"><textarea id="content" name="content"></textarea></td>
                </tr>

                <!-- <tr>
                    <td class="col2" style="border:none;">
                        <input class="upload_file" value="첨부파일" placeholder="첨부파일"></input>
                        <label for="select_file">파일 찾기</label>
                        <input type="file" id="select_file"></input>
                    </td>
                </tr> -->

                <tr>
                    <td class="col1">비밀번호</td>
                    <td class="col2"><input id="password" type="text" name="password"></td>
                </tr>
                
            </table>
        <div>
        
        <div class="buttons">
            <button type="button" id="a-btn" onclick="history.back()">목록</button>
            <button type="button" id="rgt-btn" onclick="insertchk();">등록</button>
        </div>
    </div>
    </form>
</body>
</html>