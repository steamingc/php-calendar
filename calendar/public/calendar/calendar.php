<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset = "utf-8">
    <title>12월 달력 만들기</title>

    <!-- style 태그의 type 속성은 style 요소의 미디어 타입을 명시함. text/css 속성값은 콘텐츠가 css임을 나타낸다 -->
    <!-- css : 스타일, 레이아웃 등 사용자에게 문서를 표시하는 방법을 지정하는 언어 -->
    <style type="text/css">
        .table1 { 
            border:1px solid white; 
            width:720px; 
            background-color:#DBBE9F; 
            border-collapse:collapse; 
            text-align:center; 
            color:white;
        }
        
        tr, th, td {
            border:1px solid white;
            width:80px;
            height:80px;
        }

        .sunday {
            width:80px; 
            height:80px;
            color:#6A8DAB;
        }

        /* .bg {
            width:720px;
            background-color:#DBBE9F;
        } */

        .info {
            background-color:#DBBE9F;
            width:160px;
        }

    </style>
</head>

<body>
    <?php 
        if( !isset($today) ) { $today = date("Y-m-d"); }  //today가 초기화 되어 있지 않으면 오늘 날짜로 설정 (date함수)
        // echo "$today"."<br>";   //날짜 확인
        // echo var_dump($today);  //변수 타입 확인

        //함수 생성
        function cal($today) {

            $today_arr = explode("-", $today);    //오늘 날짜의 연,월,일을 분리하여 저장
            $today_arr_y = $today_arr[0];   //연
            $today_arr_m = $today_arr[1];   //월
            $today_arr_d = $today_arr[2];   //일

            $this_month_tday = date("t", mktime(0,0,0,$today_arr_m, $today_arr_d, $today_arr_y)); //이번 달 월의 일수
            $this_month_first = date("N", mktime(0,0,0,$today_arr_m, 1, $today_arr_y)); //첫날 요일 (N이 요일의 숫자 표현1~7)
            $start_point = $this_month_first % 7;   //이번 달 1일이 언제 시작하는지 (1일 전 공백 숫자)

            //달력 줄 개수
            $line = ($this_month_tday + $start_point) / 7; //달력 모든 칸의 개수/7
            $line = ceil($line);    //올림
            $line = $line - 1;

            echo ("
                <table class=\"table1\">
                    <tr>
                        <th class=\"info\" rowspan=\"2\"><h1>".$today_arr_y."년 </h1></th>
                        <th class=\"sunday\"><h1>S</h1></th>
                        <th><h1>M</h1></th>
                        <th><h1>T</h1></th>
                        <th><h1>W</h1></th>
                        <th><h1>T</h1></th>
                        <th><h1>F</h1></th>
                        <th><h1>S</h1></th>
                    </tr>
            ");
            
            for ($i=0; $i<=$line; $i++) {   //달력 줄 수만큼 반복
                echo "<tr>"; 

                for ($j=1; $j<=7; $j++) {   //요일만큼 반복

                        /* 칸에 번호를 매겨줌. 1일이 되기 전 공백들부터 마이너스 값으로 채움 */
                        $iv = 7 * $i + $j;
                        $iu = $iv - $line;  

                        if($j==1&&$i%2==1) { //일요일 날짜 색상 다르게
                            echo "<td class=\"sunday\" rowspan=\"2\"><h1>";
                        } else echo "<td><h1>";

                        if($iu <= 0 || $iu > $this_month_tday) { 
                            echo "&nbsp";
                        } else {
                            $today = date("Y-m-d", mktime(0,0,0,$today_arr_y, $iu, $today_arr_d));  //현재 칸의 날짜
                            echo "$iu";
                        }
                        echo "</h1></td>";
                    }
                    echo "</tr>";
            }
            echo "</table>";
        }
    ?>

    <?php
        // echo "
        // <div style=\"float:left;\">
        //     <table class=\"info\">
        //         <tr></tr>
        //         <tr></tr>
        //         <tr></tr>
            
        //     </table>
        // </div>";

        // echo "<div style=\"float:left;\">";
        cal($today);
        // echo "</div>";
    ?>

</body>
</html>