<?php
//---- 오늘 날짜
$thisyear = date('Y'); // 4자리 연도
$thismonth = date('n'); // 0을 포함하지 않는 월
$today = date('j'); // 0을 포함하지 않는 일

//---- $year, $month 값이 없으면 현재 날짜
$year = isset($_GET['year']) ? $_GET['year'] : $thisyear;
$month = isset($_GET['month']) ? $_GET['month'] : $thismonth;
$day = isset($_GET['day']) ? $_GET['day'] : $today;

//---- 지난 달, 다음 달, 작년, 내년
$prev_month = $month - 1;
$next_month = $month + 1;
$prev_year = $next_year = $year;

//---- 해당 달이 1월 혹은 12월이면 월, 연도 변경해줌
if ($month == 1) {
    $prev_month = 12;
    $prev_year = $year - 1;
} else if ($month == 12) {
    $next_month = 1;
    $next_year = $year + 1;
}

//---- 작년, 내년 버튼
$preyear = $year - 1;
$nextyear = $year + 1;

//---- 어제, 내일 버튼
$predate = date("Y-m-d", mktime(0, 0, 0, $month - 1, 1, $year));
$nextdate = date("Y-m-d", mktime(0, 0, 0, $month + 1, 1, $year));

// 1. 총일수 구하기
$max_day = date('t', mktime(0, 0, 0, $month, 1, $year)); // 해당월의 마지막 날짜
//echo '총요일수'.$max_day.'<br />';

// 2. 시작요일 구하기
$start_week = date("w", mktime(0, 0, 0, $month, 1, $year)); // 일요일 0, 토요일 6

// 3. 총 몇 주인지 구하기
$total_week = ceil(($max_day + $start_week) / 7);

// 4. 마지막 요일 구하기
$last_week = date('w', mktime(0, 0, 0, $month, $max_day, $year));
?>

<!DOCTYPE html>
<html lang="ko">

    <head>
        <meta charset="utf-8">
        <title>12월 달력 만들기</title>

        <!-- style 태그의 type 속성은 style 요소의 미디어 타입을 명시함. text/css 속성값은 콘텐츠가 css임을 나타낸다 -->
        <!-- css : 스타일, 레이아웃 등 사용자에게 문서를 표시하는 방법을 지정하는 언어 -->
        <style type="text/css">
            /* 전체 div태그 */
            .row {
                width: 720px;
                /* 디브 태그 간의 높이를 같게 한다 (폭도 같이 하고 싶으면 flex:1 추가하기) */
                display: inline-flex; 
            }

            /* 캘린더 테이블 속성 */
            .cal_table {
                border: 1px solid white;
                width: 560px; 
                background-color: #DBBE9F;
                border-collapse: collapse;
                text-align: center;
                color: white;
            }

            /* 캘린더 옆 컨트롤용 테이블 */
            .info {
                width: 160px;
                background-color: #DBBE9F;
                color: #6A8DAB;
                border-collapse: collapse;
            }

            /* 컨트롤러 */
            td.control {
                height: 140px;
                border: 1px solid white;
                text-align: center;
                vertical-align: middle;
            }

            /* 캘린더 내부 기본 td, th */
            th, 
            td {
                border: 1px solid white;
                width: 80px;
                height: 80px;
                vertical-align: middle;
            }

            /* a태그 속성 수정 */
            a {
                text-decoration:none;   /*클릭시 언더라인 효과 삭제*/
                color: #6A8DAB;         /*클릭시 보라색으로 색상 변경되는 것 수정 */
            }

            /* 요일별 속성들 */
            .sunday {
                color: #B75F5F;
                text-align: center;
            }

            .saturday {
                color: #6A8DAB;
                text-align: center;
            }

            .white {
                color: white;
                text-align: center;
            }

            .today {
                color: #353535;
                text-align: center;
                text-decoration: underline;
            }

            h1.thismonth {
                margin-top: 0em;
            }

            h3.thisyear {
                margin-bottom: 0em;
                text-decoration: underline;
            }

        </style>
    </head>

    <body>

        <div class="row">
            <table class="info">
                <tr>
                    <td class="control">
                        <h3 class="thisyear">&nbsp&nbsp&nbsp<?php echo $year ?>&nbsp&nbsp&nbsp</h3>
                        <h1 class="thismonth"><?php echo $month ?></h1>
                    </td>
                </tr>

                <tr>
                    <td class="control">
                        <h2>Month<br>
                            <a href=<?php echo 'index.php?year='.$prev_year.'&month='.$prev_month.'&day=1'; ?>>◀ </a>
                            <a href=<?php echo 'index.php?year='.$next_year.'&month='.$next_month.'&day=1'; ?>> ▶</a>
                        </h2>
                    </td>
                </tr>

                <tr>
                    <td class="control">
                        <h2>Year<br>
                        <a href=<?php echo 'index.php?year='.$preyear.'&month='.$month.'&day=1'; ?>>◀◀ </a>
                        <a href=<?php echo 'index.php?year='.$nextyear.'&month='.$month.'&day=1'; ?>> ▶▶</a>
                        </h2>
                    </td>
                </tr>

                <tr>
                    <td class="control">
                        <h2>
                            <a
                                href=<?php echo 'index.php?year='.$thisyear.'&month='.$thismonth.'&day='.$today; ?>>
                                TODAY</a>
                        </h2>
                    </td>
                </tr>

            </table>
            
            <table class="cal_table">
                <tr>
                    <th class="sunday">
                        <h1>S</h1>
                    </th>
                    <th>
                        <h1>M</h1>
                    </th>
                    <th>
                        <h1>T</h1>
                    </th>
                    <th>
                        <h1>W</h1>
                    </th>
                    <th>
                        <h1>T</h1>
                    </th>
                    <th>
                        <h1>F</h1>
                    </th>
                    <th class="saturday">
                        <h1>S</h1>
                    </th>
                </tr>

            <?php
            $day=1; //화면의 초기값을 1로 설정

            //달력 줄 수만큼 반복
            for ($i=1; $i<=$total_week; $i++) { 
            ?>

            <tr>

            <?php
            //총 가로칸 만들기. 요일만큼 반복
            for ($j=0; $j<7; $j++) {
                echo '<td><h1>';

                //첫번째 주인데 시작 요일보다 $j가 작거나 마지막주인데 $j가 마지막 요일보다 크면 표시하지 않음
                if(!(($i==1 && $j<$start_week) || ($i==$total_week && $j>$last_week))){
                        //오늘이면 검은 색
                    if($year==$thisyear && $month==$thismonth && $day==date("j")){
                        $style = "today";
                    } else if($j==0) {      //일요일
                        $style = "sunday";
                    } else if($j==6){       //토요일
                        $style = "saturday";   
                    } else {                //오늘이 아닌 다른 평일
                        $style = "white";
                    }

                //날짜 출력
                echo '<font class='.$style.'>';
                echo $day;
                echo '</font></h1>';

                $day++;
                }
                echo "</td>";
            }
            echo "</tr>";
            }
            echo "</table></div>";
        ?>
    </body>
</html>