<?php 
    include "db/db.php";

    //잠금 이미지
    $lockimg = "<img src='/img/lockimg.png' alt='lock' width='15' height='15' />";

    // ---------- 페이징처리 ----------
    if(isset($_GET['page'])){
        $page = $_GET['page'];
    } else {
        $page = 1;
    }

    $sql = query("select * from board");
    $row_num = mysqli_num_rows($sql);   //게시판 총 레코드 수
    $list = 10; //한 페이지에 보여줄 개수
    $block = 5; //블록당 보여줄 페이지 개수

        // $this_block_num = ceil($page/$block); //현재 페이지 블록 구하기
        // $this_block_start = (($this_block_num - 1) * $block) + 1;  //블록의 시작 번호
    $this_block_num = ceil($page/$block) - 1; //현재 페이지 블록 구하기
    $this_block_start = ($this_block_num * $block) + 1;  //블록의 시작 번호
    $this_block_end = $this_block_start + $block - 1; //블록의 마지막 번호

    $total_page = ceil($row_num / $list);   //페이징한 페이지 수 구하기

        //만약 블록의 마지막 번호가 페이지 수보다 많다면
    if ($this_block_end > $total_page) { 
        $this_block_end = $total_page;  //마지막 번호는 페이지 수
    }

    $start_num = ($page - 1) * $list;   //시작번호 (page - 1)에서  $list를 곱한다.

        //글 리스트 불러오기
    $sql2 = query("select * from board order by id desc limit $start_num, $list");

        //글번호 초기화 (총 레코드 수 가져와서 페이지와 연계. 거꾸로)
    $num = $row_num - ($page-1)*10;
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <!-- <link rel="stylesheet" type="text/css" href="style.css?after" /> -->
    <link rel="stylesheet" href="./bootstrap-4.0.0/css/bootstrap.min.css">
    <script src="./jquery-3.6.3.min.js"></script>
    <script src="./bootstrap-4.0.0/js/bootstrap.bundle.min.js"></script>
    <title>게시판 리스트</title>
</head>

<body> 
    <div class="jumbotron text-center mb-0">
        <h1 class="display-4 font-weight-bold">☆────〃비밀 방명록〃────☆</h1>
    </div>
    <table class="table table-hover text-center">
        <thead class="table-primary">
            <tr>
                <!-- <th width="70">글번호</th>
                <th width="500">제목</th>
                <th width="120">작성자</th>
                <th width="200">작성일</th>
                <th width="200">수정일</th> -->
                <th scope="col1" width="70">글번호</th>
                <th scope="col1" width="400">제목</th>
                <th scope="col1" width="200">작성자</th>
                <th scope="col1" width="200">작성일</th>
                <th scope="col1" width="200">수정일</th>
            </tr>
        </thead>

        <?php 
            //한 페이지에 글을 10개씩만 출력
            while($board = $sql2 -> fetch_array()) {
                $title = $board['title']; 
        ?>

        <tbody>                
            <tr>
                <th scope="row" width="70"><?php echo $num; ?></th>

                <!-- 제목 -->
                <td width="500"><a href="board_read.php?id=<?=$board['id']?>"><?=$title?></td>
                
                <!-- 작성자 (비밀번호 조건문) -->
                <td width="120">
                    <?php echo $board['name'];
                        if($board['password']=="" || $board['password']==null) {} 
                        else {echo $lockimg;}
                    ?>
                </td>
                <td width="200"><?=$board['ct']?></td>
                <td width="200"><?=$board['ut']?></td>  
            </tr>
        </tbody>
        
        <?php 
            //글번호 초기화
            $num--;
            } 
        ?>
    </table>
    
    <!-- 글 쓰기 버튼 -->
    <button class="btn btn-primary float-right" onclick="location.href='board_write.php'">글쓰기</button>

    <!-- 페이징 넘버 -->
    <div class="row text-center">
        <ul class="pagination" style="margin: auto;">
            <?php
                //처음으로
                if($page <= 1){ //현재 페이지가 1보다 작거나 같다면 빈값
                    echo "<li class='page-item disabled font-weight-bold'><a class='page-link' href='?page=$first'>First</a></li>";
                } else {
                    $first = 1;    //현재 블록 시작에서 5페이지 전
                    echo "<li class='page-item font-weight-bold'><a class='page-link' href='?page=$first'>First</a></li>";  //이전 글자에 pre변수를 링크
                }

                //이전
                if($page <= 1){ //현재 페이지가 1보다 작거나 같다면 빈값
                    echo "<li class='page-item disabled'><a class='page-link' href='?page=$pre'>prev</a></li>";
                } else if($this_block_end <= 5) {   //1~5페이지 일 때
                    $pre = $first;    //현재 블록 시작에서 5페이지 전
                    echo "<li class='page-item'><a class='page-link' href='?page=$pre'>prev</a></li>";  //이전 글자에 pre변수를 링크
                } else {
                    $pre = $this_block_start - 3;    //현재 블록 시작에서 5페이지 전
                    echo "<li class='page-item'><a class='page-link' href='?page=$pre'>prev</a></li>";  //이전 글자에 pre변수를 링크
                }

                //페이지들 및 현재 페이지
                for($i=$this_block_start; $i<=$this_block_end; $i++){ //초기값을 블록의 시작 번호를 조건으로 블록 시작번호가 마지막 블록보다 작거나 같을 때까지 $i를 반복시킨다
                    if($page == $i) {
                        echo "<li class='page-item active'><a class='page-link'>$i</li>";
                    } else {
                        echo "<li class='page-item'><a class='page-link' href='?page=$i'>$i</a></li>";
                    }
                }

                //다음
                if($page >= $total_page){  //만약 현재 블록이 블록 총개수보다 크거나 같다면 빈값 
                    echo "<li class='page-item disabled'><a class='page-link' href='?page=$next'>next</a></li>";
                } else if( $total_page-$this_block_start < 10) { //마지막 전 블록
                    $next = $total_page;
                    echo "<li class='page-item'><a class='page-link' href='?page=$next'>next</a></li>";
                } else {
                    $next = $this_block_start + 7;  //현재 블록 시작에서 5페이지 후
                    echo "<li class='page-item'><a class='page-link' href='?page=$next'>next</a></li>";
                }

                //마지막으로
                if($page >= $total_page){  //만약 현재 블록이 블록 총개수보다 크거나 같다면 빈값 
                    echo "<li class='page-item disabled font-weight-bold'><a class='page-link' href='?page=$last'>Last</a></li>";
                } else {
                    $last = $total_page;  //마지막 페이지
                    echo "<li class='page-item font-weight-bold'><a class='page-link' href='?page=$last'>Last</a></li>";
                }
            ?>
        </ul>
    </div>
</body>
</html>