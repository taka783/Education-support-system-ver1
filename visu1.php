<?php

//urlのid受け取り処理
if(isset($_GET['user'])){
$get_id = $_GET['user'];  
$username = $get_id;
}


//次の画面へid引き渡し
//<a href="main_m.php?user='.$get_id.'"></a>

require "mysql.php";

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>学習支援システム</title>
<link rel="stylesheet" href="css/style.css">
</head>

<body>
<!-- BootstrapのCSS読み込み -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<!-- jQuery読み込み -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.0.js"></script>
<!-- BootstrapのJS読み込み -->
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>

<div id="container">
<header>
<h1 id="logo"><a href="main.php?user=<?php echo $username;?>"><img src="images/logo.png" alt="学習支援システム"></a></h1>
</header>
<div id="contents">

<section>

<h2>これまでの学習の振り返り</h2>

<style type="text/css">
#navi {
    border:1px solid #CCC;
    }
#navi h4 {
    padding:2px 5px;margin:2px;
    background:#F8F8F8;
    border:1px solid #CCC;
    text-shadow:1px 3px 2px #CCC;   /* ボタンテキストの影 */
    box-shadow:#666 3px 3px 7px;    /* 枠の影 */ 
    -moz-box-shadow:#999 3px 3px 7px;   /* Firefox */ 
    -webkit-box-shadow:#666 3px 3px 7px;    /* Safari,Google Chrome */
}
#navi h4:hover {
    position:relative;left:1px;top:1px;
    }
</style>


 
<script><!--
$(document).ready(function(){
  $('#navi > h4').next().hide();
  $('#navi > h4').click(function(){
    // 引数には開閉する速度を指定します
    $(this).next().slideToggle('slow');
  });
});
//--></script>


<div id="navi">
 
<h4>▼可視化グラフ</h4>
<ul class="sub">
<?php
//urlのid受け取り処理
if(isset($_GET['user'])){
$get_id = $_GET['user'];  
$username = $get_id;
}


date_default_timezone_set('Asia/Tokyo');
$now = date('Y-m-d H:i:s');

//次の画面へid引き渡し
//<a href="main_m.php?user='.$get_id.'"></a>

require "mysql.php";


$journal = mysqli_query($con, "SELECT * FROM journal1 WHERE user_id ='" . $username . "' ORDER BY j_day ASC");
$jou = mysqli_query($con, "SELECT COUNT(*) FROM journal1 WHERE user_id ='" . $username . "'");
$Ijou = mysqli_fetch_assoc($jou);
$ijou = $Ijou['COUNT(*)'];
$j_row = $Ijou['COUNT(*)'];

$total_time = 0;
foreach ($journal as $row) {
  $total_time = $total_time + $row['mathA'] + $row['mathB'] + $row['mathC'] + $row['eng'] + $row['inf'] + $row['jap'];

}

//日付取得
date_default_timezone_set ('Asia/Tokyo');
//本日の日付
$today = date('Y-m-d');
//データを取得する最初の日付
$first_day = new DateTime('2019-08-02');
$next_day = $first_day->format('Y-m-d');

//配列用変数
$i = 0;
//空の配列
$achieve = array();
//達成度平均のデータ取得
while ($next_day < $today) {
  //データ取得からの変換
  $ave = mysqli_query($con, "SELECT AVG(achievement) FROM journal1 WHERE j_day = '".$next_day."' ORDER BY j_day ASC");
  $journal_Ave = mysqli_fetch_assoc($ave);
  $j_ave = $journal_Ave['AVG(achievement)'];
  if($j_ave == NULL){
    break;
  }
  //データを配列に格納
  array_push($achieve , $j_ave);
  //次のデータ
  $i++;
  $timestamp = strtotime('+1 week ' . $next_day);
  $next_day = date("Y-m-d", $timestamp);
}


//配列用変数
$i = 0;
$first_day = new DateTime('2019-08-02');
$next_day = $first_day->format('Y-m-d');
//空の配列
$total = array();
//学習時間のデータ取得
while ($next_day < $today) {
  //データ取得からの変換
  $sum = mysqli_query($con, "SELECT AVG(total) FROM journal1 WHERE j_day = '".$next_day."' ORDER BY j_day ASC");
  $journal_Sum = mysqli_fetch_assoc($sum);
  $j_sum = $journal_Sum['AVG(total)'];
  if($j_sum == NULL){
    break;
  }
  if($i != 0){
  $next_value = $total[$i - 1] + $j_sum;
  array_push($total , $next_value);
  }else{
  //データを配列に格納
  array_push($total , $j_sum);
  }
  //次のデータ
  $i++;
  $timestamp = strtotime('+1 week ' . $next_day);
  $next_day = date("Y-m-d", $timestamp);
}

  $my_total = array();
  $no = 0;
  foreach ($journal as $value) {
  if($no == 0){
  array_push($my_total , $value["total"]);
  }else{
  $iii = $no - 1;
  $sum = $my_total[$iii] + $value["total"];
  array_push($my_total , $sum);
  }
  $no++;
}


if ($_SERVER['REQUEST_METHOD'] == "POST"){
  //下のフォームの「変更」が実行された時
  if (array_key_exists("Registration", $_POST)) {
  //下のフォームで入力された値でデータベースを更新
  $result = mysqli_query($con, "INSERT contract SET user_id = '". $username ."', flag = 1, url = 'image/". $username .".jpg'");
  }
}

$con1 = mysqli_query($con, "SELECT COUNT(*) FROM contract WHERE user_id='". $username . "' AND flag=1");
$Icon = mysqli_fetch_assoc($con1);
$Ic = $Icon['COUNT(*)'];

//感情グラフ用データ
$e0 = mysqli_query($con, "SELECT COUNT(*) FROM journal1 WHERE user_id='". $username . "' AND emotion=0");
$ee0 = mysqli_fetch_assoc($e0);
$ie0 = $ee0['COUNT(*)'];
$e1 = mysqli_query($con, "SELECT COUNT(*) FROM journal1 WHERE user_id='". $username . "' AND emotion=1");
$ee1 = mysqli_fetch_assoc($e1);
$ie1 = $ee1['COUNT(*)'];
$e2 = mysqli_query($con, "SELECT COUNT(*) FROM journal1 WHERE user_id='". $username . "' AND emotion=2");
$ee2 = mysqli_fetch_assoc($e2);
$ie2 = $ee2['COUNT(*)'];
$e3 = mysqli_query($con, "SELECT COUNT(*) FROM journal1 WHERE user_id='". $username . "' AND emotion=3");
$ee3 = mysqli_fetch_assoc($e3);
$ie3 = $ee3['COUNT(*)'];


//通知機能
$cc1 = mysqli_query($con, "SELECT COUNT(*) FROM notification WHERE user_id='". $username . "' AND flag=1");
$ccc1 = mysqli_fetch_assoc($cc1);
$icc1 = $ccc1['COUNT(*)'];
if($Ic > 0 && $icc1 == 0){
  $In_con = mysqli_query($con, "INSERT notification SET user_id = '". $username ."', log_day = '". $now ."', content = '学習契約書の登録が完了しました！', flag = 1, flag_2 = 100");
}

$progress = mysqli_query($con, "SELECT COUNT(*) FROM goal_list WHERE user_id='". $username . "' AND c_flag = 1 AND subject='". $s_id . "'");
$pro = mysqli_fetch_assoc($progress);
$pro_INT = $pro['COUNT(*)'];
$All_goal = mysqli_query($con, "SELECT COUNT(*) FROM goal_list WHERE user_id='". $username . "' AND subject='". $s_id . "'");
$All = mysqli_fetch_assoc($All_goal);
$All_INT = $All['COUNT(*)'];

$level = $pro_INT / $All_INT * 100;
$le = round($level, 1);


$ave = mysqli_query($con, "SELECT AVG(achievement) FROM journal1 WHERE user_id='". $username . "'");
$time_Ave = mysqli_fetch_assoc($ave);
$t_ave = $time_Ave['AVG(achievement)'];
$t_ave = floor($t_ave);
$sum = mysqli_query($con, "SELECT SUM(total) FROM journal1 WHERE user_id='". $username . "'");
$time_Sum = mysqli_fetch_assoc($sum);
$t_sum = $time_Sum['SUM(total)'];

$jou = mysqli_query($con, "SELECT COUNT(*) FROM achievement WHERE user_id ='" . $username . "'");
$Ijou = mysqli_fetch_assoc($jou);
$j_row = $Ijou['COUNT(*)'];

?>

  <div class="container-fluid">
  <!--row開始-->
  <div class="row">
    <div class="col-sm-12 border border-dark bg-light">あなたの達成度の平均:<?php echo $t_ave;?>%</div>
        <div class="col-sm-12 border border-dark"><canvas id="myLineChart"></canvas></div>
    </div>
    <div class="row">
              <div class="col-sm-12 border border-dark bg-light">あなたの学習時間の累計:<?php echo $t_sum;?>時間</div>
        <div class="col-sm-12 border border-dark"><canvas id="myLineChart2"></canvas></div> 
    </div>
    <div class="row">
      <div class="col-sm-12 border border-dark bg-light">あなたの感情グラフ</div>
      <div class="col-sm-12 border border-dark"><canvas id="myPieChart"></canvas></div>
    </div>
    <?php
    if($j_row != 0){
    ?>
    <div class="row">
      <div class="col-sm-12 border border-dark bg-light">あなたのToDo進捗</div>
      <div class="col-sm-12 border border-dark"><canvas id="myLineChart3"></canvas></div>
    </div>
    <?php
  }
    ?>
    <div class="row">
      <div class="col-sm-12 border border-dark bg-light">あなたの科目ごとの学習時間</div>
      <div class="col-sm-12 border border-dark"><canvas id="canvas"></canvas></div>
    </div>
</div>
</ul>

<script>
  var ctx3 = document.getElementById("myLineChart");
  var myLineChart = new Chart(ctx3, {
    type: 'line',
    data: {
      labels: [
      <?php
      $no = 0;
      foreach ($journal as $value) {
          echo "'".$value["j_day"]."'";
          $no++;
          if ($no !== $j_row) {
          echo ",";
          }
        }
      ?>
      ],
      datasets: [
        {
          label: 'あなた',
          data: [

      <?php
      $no = 0;
      foreach ($journal as $value) {
          echo floor($value["achievement"]);
          $no++;
          if ($no !== $j_row) {
          echo ",";
          }
        }
      ?>
          ],
          borderColor: "rgba(255,0,0,1)",
          backgroundColor: "rgba(0,0,0,0)"
        },
        {
          label: 'みんなの平均',
          data: [
        <?php
      $no = 0;
      for ($ii=0; $ii<$j_row; $ii++) {
          echo floor($achieve[$no]);
          $no++;
          if ($no !== $j_row) {
          echo ",";
          }
        }
      ?>
          ],
          borderColor: "rgba(0,0,255,1)",
          backgroundColor: "rgba(0,0,0,0)"
        }
      ],
    },
    options: {
      title: {
        display: true,
        text: '達成度の推移'
      },
      scales: {
        yAxes: [{
          ticks: {
            suggestedMax: 40,
            suggestedMin: 0,
            stepSize: 10,
            callback: function(value, index, values){
              return  value +  '%'
            }
          }
        }]
      },
    }
  });

    var ctx4 = document.getElementById("myLineChart2");
  var myLineChart2 = new Chart(ctx4, {
    type: 'line',
    data: {
      labels: [
      <?php
      $no = 0;
      foreach ($journal as $value) {
          echo "'".$value["j_day"]."'";
          $no++;
          if ($no !== $j_row) {
          echo ",";
          }
        }
      ?>
      ],
      datasets: [
        {
          label: 'あなた',
          data: [
        <?php
      $no = 0;
      for ($ii=0; $ii<$j_row; $ii++) {
          echo floor($my_total[$no]);
          $no++;
          if ($no !== $j_row) {
          echo ",";
          }
        }
      ?>
      ],
          borderColor: "rgba(255,0,0,1)",
          backgroundColor: "rgba(0,0,0,0)"
        },
        {
          label: 'みんなの平均',
          data: [
        <?php
      $no = 0;
      for ($ii=0; $ii<$j_row; $ii++) {
          echo floor($total[$no]);
          $no++;
          if ($no !== $j_row) {
          echo ",";
          }
        }
      ?>
      ],
          borderColor: "rgba(0,0,255,1)",
          backgroundColor: "rgba(0,0,0,0)"
        }
      ],
    },
    options: {
      title: {
        display: true,
        text: '学習時間の累計'
      },
      scales: {
        yAxes: [{
          ticks: {
            suggestedMax: 40,
            suggestedMin: 0,
            stepSize: 10,
            callback: function(value, index, values){
              return  value +  '時間'
            }
          }
        }]
      },
    }
  });


  var ctx5 = document.getElementById("myPieChart");
  var myPieChart = new Chart(ctx5, {
    type: 'pie',
    data: {
      labels: ["やるきがあった", "イライラしていた", "集中していた", "心配だった"],
      datasets: [{
          backgroundColor: [
              "#BB5179",
              "#FAFF67",
              "#58A27C",
              "#3C00FF"
          ],
          data: [<?php echo $ie0; ?>, <?php echo $ie1; ?>, <?php echo $ie2; ?>, <?php echo $ie3; ?>]
      }]
    },
    options: {
      title: {
        display: true,
        text: '感情グラフ'
      }
    }
  });
  </script>

  <?php
$achieve = mysqli_query($con, "SELECT * FROM achievement WHERE user_id ='" . $username . "' ORDER BY log_day ASC");
$jou = mysqli_query($con, "SELECT COUNT(*) FROM achievement WHERE user_id ='" . $username . "'");
$Ijou = mysqli_fetch_assoc($jou);
$j_row = $Ijou['COUNT(*)'];
?>

<script>
  var ctx6 = document.getElementById("myLineChart3");
  var myLineChart3 = new Chart(ctx6, {
    type: 'line',
    data: {
      labels: [
      <?php
      $no = 0;
      foreach ($achieve as $value) {
          echo "'".date('Y-m-d', strtotime($value['log_day']))."'";
          $no++;
          if ($no !== $j_row) {
          echo ",";
          }
        }
      ?>
      ],
      datasets: [
        {
          label: 'あなた',
          data: [

      <?php
      $no = 0;
      foreach ($achieve as $value) {
          echo floor($value["a_point"]);
          $no++;
          if ($no !== $j_row) {
          echo ",";
          }
        }
      ?>
          ],
          borderColor: "rgba(255,0,0,1)",
          backgroundColor: "rgba(0,0,0,0)"
        }
      ],
    },
    options: {
      title: {
        display: true,
        text: 'ToDo進捗の変動'
      },
      scales: {
        yAxes: [{
          ticks: {
            suggestedMax: 40,
            suggestedMin: 0,
            stepSize: 10,
            callback: function(value, index, values){
              return  value +  '%'
            }
          }
        }]
      },
    }
  });

</script>



  <?php
//合計学習時間取得
$sum = mysqli_query($con, "SELECT SUM(math) FROM journal1 WHERE user_id='". $username . "'");
$time_Sum = mysqli_fetch_assoc($sum);
$t_sumM = $time_Sum['SUM(math)'];

$sum = mysqli_query($con, "SELECT SUM(eng) FROM journal1 WHERE user_id='". $username . "'");
$time_Sum = mysqli_fetch_assoc($sum);
$t_sumE = $time_Sum['SUM(eng)'];

$sum = mysqli_query($con, "SELECT SUM(inf) FROM journal1 WHERE user_id='". $username . "'");
$time_Sum = mysqli_fetch_assoc($sum);
$t_sumI = $time_Sum['SUM(inf)'];

$sum = mysqli_query($con, "SELECT SUM(jap) FROM journal1 WHERE user_id='". $username . "'");
$time_Sum = mysqli_fetch_assoc($sum);
$t_sumJ = $time_Sum['SUM(jap)'];
?>

    <script>
    var ctx = document.getElementById("canvas").getContext("2d");
    var myBar = new Chart(ctx, {
        type: 'bar',                           //◆棒グラフ
        data: {                                //◆データ
            labels: ['数学','英語','情報','国語'],     //ラベル名
            datasets: [{                       //データ設定
                data: [<?php echo $t_sumM; ?>,<?php echo $t_sumE; ?>,<?php echo $t_sumI; ?>,<?php echo $t_sumJ; ?>],          //データ内容
                backgroundColor: ['#FF4444', '#4444FF', '#44BB44', '#FFFF44', '#FF44FF']   //背景色
            }]
        },
        options: {                             //◆オプション
            responsive: true,                  //グラフ自動設定
            legend: {                          //凡例設定
                display: false                 //表示設定
           },
            title: {                           //タイトル設定
                display: true,                 //表示設定
                fontSize: 18,                  //フォントサイズ
                text: '教科ごとの学習時間合計'                //ラベル
            },
            scales: {                          //軸設定
                yAxes: [{                      //y軸設定
                    display: true,             //表示設定
                    scaleLabel: {              //軸ラベル設定
                       display: true,          //表示設定
                       labelString: '学習時間',  //ラベル
                       fontSize: 18               //フォントサイズ
                    },
                    ticks: {                      //最大値最小値設定
                        min: 0,                   //最小値
                        fontSize: 18,             //フォントサイズ
                        stepSize: 5               //軸間隔
                    },
                }],
                xAxes: [{                         //x軸設定
                    display: true,                //表示設定
                    barPercentage: 0.7,           //棒グラフ幅
                    categoryPercentage: 0.7,      //棒グラフ幅
                    scaleLabel: {                 //軸ラベル設定
                       display: true,             //表示設定
                       labelString: '科目',  //ラベル
                       fontSize: 18               //フォントサイズ
                    },
                    ticks: {
                        fontSize: 18             //フォントサイズ
                    },
                }],
            },
            layout: {                             //レイアウト
                padding: {                          //余白設定
                    left: 50,
                    right: 50,
                    top: 0,
                    bottom: 0
                }
            }
        }
    });
    </script>
 
<h4>▼学習日誌</h4>
<ul class="sub">
<?php
$goodbad = array();
$goal = array();
$jo = mysqli_query($con, "SELECT * FROM journal1 WHERE user_id='". $username . "'");
$ijo = mysqli_query($con, "SELECT COUNT(*) FROM journal1 WHERE user_id='". $username . "'");
$iijo = mysqli_fetch_assoc($ijo);
$Ijj = $iijo['COUNT(*)'];
foreach ($jo as $value) {
array_push($goodbad , $value["goodbad"]);
}

$goal_jo = mysqli_query($con,"SELECT * FROM journal1 WHERE user_id='". $username . "' and total > 0");
$ijg = mysqli_query($con, "SELECT COUNT(*) FROM journal1 WHERE user_id='". $username . "' and total > 0");
$iijg = mysqli_fetch_assoc($ijg);
$Ijjg = $iijg['COUNT(*)'];
foreach ($goal_jo as $value) {
array_push($goal , $value["nextgoal"]);
}

?>


<script type="text/javascript">
function random() {
 var array = <?php echo json_encode($goodbad); ?>;

for(i = array.length - 1; i > 0; i--) {
    var j = Math.floor(Math.random() * (i + 1));
    var tmp = array[i];
    array[i] = array[j];
    array[j] = tmp;
}

var num = array[0]; //乱数の取得
document.getElementById("ransuu").innerHTML = num; //乱数の出力
}

function random1() {
 var array1 = <?php echo json_encode($goal); ?>;

for(i = array1.length - 1; i > 0; i--) {
    var j = Math.floor(Math.random() * (i + 1));
    var tmp = array1[i];
    array1[i] = array1[j];
    array1[j] = tmp;
}
var num1 = array1[0]; //乱数の取得
document.getElementById("ransuu1").innerHTML = num1; //乱数の出力
}
</script>

<?php
$achieve = mysqli_query($con, "SELECT * FROM achievement WHERE user_id ='" . $username . "' ORDER BY log_day ASC");
$jou = mysqli_query($con, "SELECT COUNT(*) FROM achievement WHERE user_id ='" . $username . "'");
$Ijou = mysqli_fetch_assoc($jou);
$j_row = $Ijou['COUNT(*)'];
?>


<form><input type="button" value="表示" onClick="random()"></form>
<table class='ta1'>
<tr><th colspan='2' class='tamidashi'>過去の良かったこと＆悪かったこと</th></tr><tr>
    <th><span id="ransuu"></span></th></tr>
</table>

<form><input type="button" value="表示" onClick="random1()"></form>
<table class='ta1'>
<tr><th colspan='2' class='tamidashi'>過去に定めた目標</th></tr><tr>
    <th><span id="ransuu1"></span></th></tr>
</table>

<a href="journal3.php?user=<?php echo $username;?>&id=0" target="_blank">▶︎過去の良かったこと＆悪かったこと一覧へ</a><br>
<a href="journal3.php?user=<?php echo $username;?>&id=1" target="_blank">▶︎過去の次回の目標一覧へ</a><br>
</ul>


<h4>▼学習スタイル</h4>
<ul class="sub">
<section>
<?php
$s1 = mysqli_query($con, "SELECT COUNT(*) FROM View WHERE user_id='". $username . "'");
$ss1 = mysqli_fetch_assoc($s1);
$is1 = $ss1['COUNT(*)'];
$s2 = mysqli_query($con, "SELECT COUNT(*) FROM Motive WHERE user_id='". $username . "'");
$ss2 = mysqli_fetch_assoc($s2);
$is2 = $ss2['COUNT(*)'];
$s3 = mysqli_query($con, "SELECT COUNT(*) FROM VAKT WHERE user_id='". $username . "'");
$ss3 = mysqli_fetch_assoc($s3);
$is3 = $ss3['COUNT(*)'];


$stmt1 = mysqli_query($con, "SELECT * FROM View where user_id='". $username . "'");
foreach ($stmt1 as $row) {
    $failure = $row['failure'];
    $thinking = $row['thinking'];
    $strategy = $row['strategy'];
    $meaning = $row['meaning'];
}

$stmt2 = mysqli_query($con, "SELECT * FROM Motive where user_id='". $username . "'");
foreach ($stmt2 as $row) {
    $fullness = $row['fullness'];
    $training = $row['training'];
    $practical = $row['practical'];
    $relationship = $row['relationship'];
    $self_esteem = $row['self_esteem'];
    $reward = $row['reward'];
}

$M1 = $fullness + $training + $practical;
$M2 = $relationship + $self_esteem + $reward;

$stmt3 = mysqli_query($con, "SELECT * FROM VAKT where user_id='". $username . "'");
foreach ($stmt3 as $row) {
    $vision = $row['vision'];
    $audibility = $row['audibility'];
    $tactile = $row['tactile'];
}

function array_count_by_motive ($arr) {
  $results = [];
  foreach ($arr as $it) {
    $key = (string)$it['point'];
    if (!isset($results[$key])) $results[$key] = [];
    $results[$key][] = $it;
  }
  return $results;
}


$array1 = array(
    array(
        'id'        => 0,
        'point'     => $fullness,
        'title'     => '充実志向',
    ),
    array(
        'id'        => 1,
        'point'     => $training,
        'title'     => '訓練志向',
    ),
    array(
        'id'        => 2,
        'point'     => $practical,
        'title'     => '実用志向',
    ),
    array(
        'id'        => 3,
        'point'     => $relationship,
        'title'     => '関係志向',
    ),
    array(
        'id'        => 4,
        'point'     => $self_esteem,
        'title'     => '自尊志向',
    ),
    array(
        'id'        => 5,
        'point'     => $reward,
        'title'     => '報酬志向',
    ),
);

foreach ((array) $array1 as $key => $value) {
    $sort[$key] = $value['point'];
}

array_multisort($sort, SORT_DESC, $array1);

usort($array1, function ($a, $b) {
  $a2 = $a['point'];
  $b2 = $b['point'];
  if ($a2 == $b2) return 0;
  return ($a2 < $b2) ? 1 : -1;
});

$rank = 1;
$count = 0;
foreach (array_count_by_motive($array1) as $point => $users) {
  foreach ($users as $user) {
    if($rank == 1){
      $motive1 = $user['title'];
      $count++;
      if($count == 2){
        $motive2 = $user['title'];
      }
      if($count == 3){
        $motive3 = $user['title'];
      }
    }
  }
  $rank += count($users);
}


//
function array_count_by_VAT ($arr) {
  $results = [];
  foreach ($arr as $it) {
    $key = (string)$it['point'];
    if (!isset($results[$key])) $results[$key] = [];
    $results[$key][] = $it;
  }
  return $results;
}


$array2 = array(
    array(
        'id'        => 0,
        'point'     => $vision,
        'title'     => '視覚',
    ),
    array(
        'id'        => 1,
        'point'     => $audibility,
        'title'     => '聴覚',
    ),
    array(
        'id'        => 2,
        'point'     => $tactile,
        'title'     => '触覚',
    ),
);

foreach ((array) $array2 as $key => $value) {
    $sort[$key] = $value['point'];
}

array_multisort($sort, SORT_DESC, $array2);

usort($array2, function ($a, $b) {
  $a2 = $a['point'];
  $b2 = $b['point'];
  if ($a2 == $b2) return 0;
  return ($a2 < $b2) ? 1 : -1;
});

$rank = 1;
$count = 0;
foreach (array_count_by_motive($array2) as $point => $users) {
  foreach ($users as $user) {
    if($rank == 1){
      $VAT1 = $user['title'];
      $count++;
      if($count == 2){
        $VAT2 = $user['title'];
      }
      if($count == 3){
        $VAT3 = $user['title'];
      }
    }
  }
  $rank += count($users);
}

?>

<?php
if($is1 == 0 || $is2 == 0 || $is3 == 0){
?>
<br>
<p class="c">
<a href="questionnaire1.php?user=<?php echo $username;?>" class="btn-gradient-simple">学習スタイル診断を始める</a><br>
</p>
<br>
<h2>学習スタイル診断について</h2>
学習スタイル診断では用意された質問項目に回答してもらうことであなたの学習傾向を可視化することができます。<br>
あなたの学び方について知ることができる機会ですので、入学前教育を本格的に始める前に回答してみましょう。<br>
回答にかかる時間は10分程度です。<br>
<br>

<?php
}else{
?>

<h3>学習動機の強さ</h3>
<div class="container-fluid">
<div class="row">
<div class="center-block col-xs-2 col-sm-2 col-md-2 col-lg-2">
</div>
<div class="center-block col-xs-4 col-sm-4 col-md-4 col-lg-4 text-center">
<table class="ta1">
  <tr>
    <th bgcolor="25b1d9" style="color:white;">
      自己充実的達成動機
    </th>
  </tr>
  <tr>
    <td>
      <?php
      if($M1 >= 210){
        echo "強";
      }else if($M1 < 210 || $M1 >= 120){
        echo "中";
      }else if($M1 < 120){
        echo "弱";
      }
      ?>
    </td>
  </tr>
</table>
</div>
<div class="center-block col-xs-4 col-sm-4 col-md-4 col-lg-4 text-center">
<table class="ta1">
  <tr>
    <th bgcolor="25b1d9" style="color:white;">
      競争的達成動機
    </th>
  </tr>
  <tr>
    <td>
      <?php
      if($M2 >= 210){
        echo "強";
      }else if($M2 < 210 || $M2 >= 120){
        echo "中";
      }else if($M2 < 120){
        echo "弱";
      }
      ?>
    </td>
  </tr>
</table>
</div>
<div class="center-block col-xs-2 col-sm-2 col-md-2 col-lg-2">
</div>
</div>
</div>
<br>

<h3>あなたの学習タイプ</h3>
<div class="container-fluid">
<div class="row">
<div class="center-block col-sm-2 text-center align-middle border border-dark" style="background: #25b1d9;">
<font color="white">
あなたの<br>学習動機
</font>
</div>
<div class="center-block col-sm-10 bg-white border border-dark">

<?php
if($motive1 == '充実志向' || $motive2 == '充実志向' || $motive3 == '充実志向'){
?>
<div class="row">
<div class="center-block col-sm-3 text-center border border-dark" style="background: orange;">
充実志向
</div>
<div class="center-block col-sm-9 bg-white border border-dark">
勉強すること自体が楽しいと感じられるタイプの人です。充実志向タイプの人のオススメの学習手法として、興味のある本や教材を読んでみたり、学習に費やす時間を増やしてみると良いでしょう。
</div>
</div>
<?php
}
?>

<?php
if($motive1 == '訓練志向' || $motive2 == '訓練志向' || $motive3 == '訓練志向'){
?>
<div class="row">
<div class="center-block col-sm-3 text-center border border-dark" style="background: lightskyblue;">
訓練志向
</div>
<div class="center-block col-sm-9 bg-white border border-dark">
自己鍛錬のために学習を続けるタイプの人です。訓練志向タイプの人のオススメの学習手法として、能力が上がったことを数値化して記録してみたり、段階的に難しい問題に挑戦してみると良いでしょう。
</div>
</div>
<?php
}
?>

<?php
if($motive1 == '実用志向' || $motive2 == '実用志向' || $motive3 == '実用志向'){
?>
<div class="row">
<div class="center-block col-sm-3 text-center border border-dark" style="background: greenyellow;">
実用志向
</div>
<div class="center-block col-sm-9 bg-white border border-dark">
実務や生活等で役立てるために学習をしようと思うタイプの人です。実用志向タイプの人のオススメの学習手法として、これから取り組む学習の有用性を確認してみたり、具体的な仕事や生活への活用事例を提示してみるとよいでしょう。
</div>
</div>
<?php
}
?>

<?php
if($motive1 == '関係志向' || $motive2 == '関係志向' || $motive3 == '関係志向'){
?>
<div class="row">
<div class="center-block col-sm-3 text-center border border-dark" style="background: mistyrose;">
関係志向
</div>
<div class="center-block col-sm-9 bg-white border border-dark">
強い動機はなく、他の人がやっているからと学習をするタイプの人です。関係志向タイプの人のオススメの学習手法として、学習意欲の高い友達と一緒に勉強を進めたり、学習動画を見たりすると良いでしょう。
</div>
</div>
<?php
}
?>

<?php
if($motive1 == '自尊志向' || $motive2 == '自尊志向' || $motive3 == '自尊志向'){
?>
<div class="row">
<div class="center-block col-sm-3 text-center border border-dark" style="background: tomato;">
自尊志向
</div>
<div class="center-block col-sm-9 bg-white border border-dark">
周りに負けたくないからという競争心から学習をしようとするタイプの人です。自尊志向タイプの人のオススメの学習手法として、周りの人よりワンランク上の目標を立ててみると良いでしょう。
</div>
</div>
<?php
}
?>

<?php
if($motive1 == '報酬志向' || $motive2 == '報酬志向' || $motive3 == '報酬志向'){
?>
<div class="row">
<div class="center-block col-sm-3 text-center border border-dark" style="background: lightpink;">
報酬志向
</div>
<div class="center-block col-sm-9 bg-white border border-dark">
外発的報酬を得ることを目的に学習をしようとするタイプの人です。報酬志向タイプの人のオススメの学習手法として、自分へ何か報酬を用意しておくと良いでしょう。
</div>
</div>
<?php
}
?>

</div>
</div>
</div>

<br>


<div class="container-fluid">
<div class="row">
<div class="center-block col-sm-2 text-center align-middle border border-dark" style="background: #25b1d9;">
<font color="white">
あなたの<br>学習スタイル
</font>
</div>
<div class="center-block col-sm-10 bg-white border border-dark">
<?php
if($VAT1 == '視覚' || $VAT2 == '視覚' || $VAT3 == '視覚'){
?>
<div class="row">
<div class="center-block col-sm-3 text-center border border-dark" style="background: skyblue;">
視覚型
</div>
<div class="center-block col-sm-9 bg-white border border-dark">
あなたにはノートや図表などの視覚情報に最も効果的に馴染みます。筆記による伝達や記号操作の能力が高いです。そのため、重要部分にはマーカーを引いたり、図や絵にして整理することでより理解が進むでしょう。
</div>
</div>
<?php
}
?>

<?php
if($VAT1 == '聴覚' || $VAT2 == '聴覚' || $VAT3 == '聴覚'){
?>
<div class="row">
<div class="center-block col-sm-3 text-center border border-dark" style="background: greenyellow;">
聴覚型
</div>
<div class="center-block col-sm-9 bg-white border border-dark">
あなたには話を聞いたり音として聞くことで効果的に学習することができます。ノートや配布資料を声に出して読んで復唱してみたり、音声教材を聞くと良いでしょう。
</div>
</div>
<?php
}
?>

<?php
if($VAT1 == '体感覚' || $VAT2 == '体感覚' || $VAT3 == '体感覚'){
?>
<div class="row">
<div class="center-block col-sm-3 text-center border border-dark" style="background: gold;">
体感覚型
</div>
<div class="center-block col-sm-9 bg-white border border-dark">
あなたは体感覚をうまく使うことで集中力を高められる傾向があります。体を動かして動作パターンを覚えたり、手で書いてみることで理解が進むでしょう。
</div>
</div>
<?php
}
?>

</div>
</div>
</div>

<br>

<h3>診断結果の詳細</h3>

<!-- グラフのライブラリの読み込み -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>
<div class="container-fluid">
<div class="row">
<div class="center-block col-xs-12 col-sm-4 col-md-4 col-lg-4 bg-white border border-dark text-center">
あなたの学習観
<hr>
  <canvas id="graph-radar" width=“30” height=“30”></canvas>
</div>
<div class="center-block col-xs-12 col-sm-4 col-md-4 col-lg-4 bg-white border border-dark text-center">
あなたの各学習動機傾向
<hr>
  <canvas id="graph-radar2" width=“30” height=“30”></canvas>
</div>
<div class="center-block col-xs-12 col-sm-4 col-md-4 col-lg-4 bg-white border border-dark text-center">
VAK診断
<hr>
  <canvas id="graph-radar3" width=“30” height=“30”></canvas>
</div>
</div>
</div>


<!-- レーダーチャートの読み込み -->
<script>

var colorSet = {
  red: 'rgba(255,99,132,1)',
  yellow: 'rgb(255, 205, 86)',
  green: 'rgba(75, 192, 192, 1)',
  grey: 'rgb(201, 203, 207)',
    black: 'rgb(0, 0, 0)'
};

var color = Chart.helpers.color;



var ctx = document.getElementById("graph-radar").getContext('2d');
ctx.canvas.width = 180;
var myChart = new Chart(ctx, {
    type: 'radar',
    data: {
        labels: ['失敗に対する柔軟性', '思考過程の重視', '方略志向','意味理解志向'],
        datasets: [{
      label: "あなたの結果",
      backgroundColor: color(colorSet.red).alpha(0).rgbString(),
      borderColor: colorSet.red,
      pointBackgroundColor: colorSet.red,
      data: [<?php echo $failure;?>,<?php echo $thinking;?>,<?php echo $strategy;?>,<?php echo $meaning;?>]    }]
    },
    options: {
        legend: {
            position: 'bottom'
        },
        scale: {
      display: true,
            // ラベルの設定
      pointLabels: {
        fontSize: 10,
        fontColor: colorSet.black
      },
            // 目盛りの設定
      ticks: {
        display: true,
        fontSize: 15,
        fontColor: colorSet.grey,
        min: 0,
        max: 100,
        beginAtZero: true
      },
            // チャートのラインの設定
      gridLines: {
        display: true,
        color: color(colorSet.grey).alpha(0.3).rgbString()
      },
            // レーダーチャートの余白の調整
            beforeFit: function (scale) {
                if (scale.chart.config.data.labels.length === 3) {
                    var pointLabelFontSize = Chart.helpers.getValueOrDefault(scale.options.pointLabels.fontSize, Chart.defaults.global.defaultFontSize);
                    scale.height *= (2 / 1.5)
                    scale.height -= pointLabelFontSize;
                }
            },
            afterFit: function (scale) {
                if (scale.chart.config.data.labels.length === 3) {
                    var pointLabelFontSize = Chart.helpers.getValueOrDefault(scale.options.pointLabels.fontSize, Chart.defaults.global.defaultFontSize);
                    scale.height += pointLabelFontSize;
                    scale.height /= (2 / 1.5);
                }
            }
    }
    }
});
var ctx2 = document.getElementById("graph-radar2").getContext('2d');
ctx2.canvas.width = 180;
var myChart2 = new Chart(ctx2, {
    type: 'radar',
    data: {
        labels: ['訓練志向', '実用志向','関係志向','自尊志向','報酬志向','充実志向',],
        datasets: [{
            label: "あなたの結果",
      backgroundColor: color(colorSet.yellow).alpha(0).rgbString(),
      borderColor: colorSet.yellow,
      pointBackgroundColor: colorSet.yellow,
      data: [<?php echo $training;?>,<?php echo $practical;?>,<?php echo $relationship;?>,<?php echo $self_esteem;?>,<?php echo $reward;?>,<?php echo $fullness;?>]        }]
    },
    options: {
        legend: {
            position: 'bottom'
        },
        scale: {
      display: true,
            // ラベルの設定
      pointLabels: {
        fontSize: 15,
        fontColor: colorSet.black
      },
            // 目盛りの設定
      ticks: {
        display: true,
        fontSize: 15,
        fontColor: colorSet.grey,
        min: 0,
        max: 100,
        beginAtZero: true
      },
            // チャートのラインの設定
      gridLines: {
        display: true,
        color: color(colorSet.grey).alpha(0.3).rgbString()
      },
            // レーダーチャートの余白の調整
            beforeFit: function (scale) {
                if (scale.chart.config.data.labels.length === 3) {
                    var pointLabelFontSize = Chart.helpers.getValueOrDefault(scale.options.pointLabels.fontSize, Chart.defaults.global.defaultFontSize);
                    scale.height *= (2 / 1.5)
                    scale.height -= pointLabelFontSize;
                }
            },
            afterFit: function (scale) {
                if (scale.chart.config.data.labels.length === 3) {
                    var pointLabelFontSize = Chart.helpers.getValueOrDefault(scale.options.pointLabels.fontSize, Chart.defaults.global.defaultFontSize);
                    scale.height += pointLabelFontSize;
                    scale.height /= (2 / 1.5);
                }
            }
      }
    }
});
var ctx3 = document.getElementById("graph-radar3").getContext('2d');
ctx3.canvas.width = 180;
var myChart3 = new Chart(ctx3, {
    type: 'radar',
    data: {
        labels: ['視覚型', '聴覚型','体感覚型'],
        datasets: [{
            label: "あなたの結果",
      backgroundColor: color(colorSet.green).alpha(0).rgbString(),
      borderColor: colorSet.green,
      pointBackgroundColor: colorSet.green,
      data: [<?php echo $vision;?>,<?php echo $audibility;?>,<?php echo $tactile;?>]        }]
    },
    options: {
        legend: {
            position: 'bottom'
        },
        scale: {
      display: true,
            // ラベルの設定
      pointLabels: {
        fontSize: 15,
        fontColor: colorSet.black
      },
            // 目盛りの設定
      ticks: {
        display: true,
        fontSize: 15,
        fontColor: colorSet.grey,
        min: 0,
        max: 100,
        beginAtZero: true
      },
            // チャートのラインの設定
      gridLines: {
        display: true,
        color: color(colorSet.grey).alpha(0.3).rgbString()
      },
            // レーダーチャートの余白の調整
            beforeFit: function (scale) {
                if (scale.chart.config.data.labels.length === 3) {
                    var pointLabelFontSize = Chart.helpers.getValueOrDefault(scale.options.pointLabels.fontSize, Chart.defaults.global.defaultFontSize);
                    scale.height *= (2 / 1.5)
                    scale.height -= pointLabelFontSize;
                }
            },
            afterFit: function (scale) {
                if (scale.chart.config.data.labels.length === 3) {
                    var pointLabelFontSize = Chart.helpers.getValueOrDefault(scale.options.pointLabels.fontSize, Chart.defaults.global.defaultFontSize);
                    scale.height += pointLabelFontSize;
                    scale.height /= (2 / 1.5);
                }
            }
      }
    }
});
</script>
<?php
}
?>
</ul>

</div>


</div>
</section>
<br><br>

<p class="c">
<?php
echo '<a href="' . $_SERVER['HTTP_REFERER'] . '" class="btn-gradient-simple">契約書作成へ戻る</a>';
?>
</p>

</div>
<!--/contents-->

<footer>
<small>Copyright&copy; <a href="main.php?user=<?php echo $username;?>">学習支援システム</a> All Rights Reserved.</small>
<span class="pr">《<a href="http://template-party.com/" target="_blank">Web Design:Template-Party</a>》</span>
</footer>

</div>
<!--/container-->

<p class="nav-fix-pos-pagetop"><a href="#">↑</a></p>

<!--メニュー開閉ボタン-->
<div id="menubar_hdr" class="close"></div>
<!--メニューの開閉処理条件設定　800px以下-->
<script type="text/javascript">
if (OCwindowWidth() <= 800) {
  open_close("menubar_hdr", "menubar-s");
}
</script>
</body>
</html>
