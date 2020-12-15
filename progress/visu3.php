<?php

//urlのid受け取り処理
if(isset($_GET['user'])){
$get_id = $_GET['user'];  
$username = $get_id;
}

if(isset($_GET['flag'])){
$flag = $_GET['flag'];  
}


//次の画面へid引き渡し
//<a href="main_m.php?user='.$get_id.'"></a>

require "../mysql.php";

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>学習支援システム</title>
<link rel="stylesheet" href="../css/style.css">
</head>

<body>
<!-- BootstrapのCSS読み込み -->
<link href="../css/bootstrap.min.css" rel="stylesheet">
<!-- jQuery読み込み -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.0.js"></script>
<!-- BootstrapのJS読み込み -->
<script src="../js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>

<div id="container">
<header>
<h1 id="logo"><a href="main.php?user=<?php echo $username;?>"><img src="../images/logo.png" alt="学習支援システム"></a></h1>
</header>
<div id="contents">

<section>

<?php
if($flag == 1){
?>

<h2>ToDo進捗の詳細</h2>

<div class="container-fluid">
<!--row開始-->
<div class="row">
      <div class="col-sm-12 border border-dark"><canvas id="myLineChart"></canvas></div>
  </div>
</div>


<?php
$achieve = mysqli_query($con, "SELECT * FROM achievement WHERE user_id ='" . $username . "' ORDER BY log_day ASC");
$jou = mysqli_query($con, "SELECT COUNT(*) FROM achievement WHERE user_id ='" . $username . "'");
$Ijou = mysqli_fetch_assoc($jou);
$j_row = $Ijou['COUNT(*)'];
?>

<script>
  var ctx3 = document.getElementById("myLineChart");
  var myLineChart = new Chart(ctx3, {
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
}else if($flag == 2){
?>

<h2>学習時間の詳細</h2>

<?php
//合計学習時間取得
$sum = mysqli_query($con, "SELECT SUM(math) FROM journal2 WHERE user_id='". $username . "'");
$time_Sum = mysqli_fetch_assoc($sum);
$t_sumM = $time_Sum['SUM(math)'];

$sum = mysqli_query($con, "SELECT SUM(eng) FROM journal2 WHERE user_id='". $username . "'");
$time_Sum = mysqli_fetch_assoc($sum);
$t_sumE = $time_Sum['SUM(eng)'];

$sum = mysqli_query($con, "SELECT SUM(inf) FROM journal1 WHERE user_id='". $username . "'");
$time_Sum = mysqli_fetch_assoc($sum);
$t_sumI = $time_Sum['SUM(inf)'];

$sum = mysqli_query($con, "SELECT SUM(jap) FROM journal1 WHERE user_id='". $username . "'");
$time_Sum = mysqli_fetch_assoc($sum);
$t_sumJ = $time_Sum['SUM(jap)'];
?>

<div class="container-fluid">
<!--row開始-->
<div class="row">
      <div class="col-sm-12 border c border-dark"><canvas id="canvas"></canvas></div>
  </div>
</div>

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
                fontSize: 17,                  //フォントサイズ
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
                        fontSize: 17,             //フォントサイズ
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
                    left: 0,
                    right: 0,
                    top: 0,
                    bottom: 0
                }
            }
        }
    });
    </script>

<?php
}
?>

</div>
</section>
<br><br>

<p class="c">
<?php
echo '<a href="' . $_SERVER['HTTP_REFERER'] . '" class="btn-gradient-simple">戻る</a>';
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
