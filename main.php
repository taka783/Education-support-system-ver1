<?php

//urlのid受け取り処理
if(isset($_GET['user'])){
$get_id = $_GET['user'];  
$username = $get_id;
}

//教科IDを取得
if(isset($_GET['subject'])){
$s_id = $_GET['subject'];  
}

date_default_timezone_set('Asia/Tokyo');
$now = date('Y-m-d H:i:s');

//次の画面へid引き渡し
//<a href="main_m.php?user='.$get_id.'"></a>



require "mysql.php";

$journal = mysqli_query($con, "SELECT * FROM journal2 WHERE user_id ='" . $username . "' AND total > 0 ORDER BY j_day ASC");
$jou = mysqli_query($con, "SELECT COUNT(*) FROM journal2 WHERE user_id ='" . $username . "' AND total > 0");
$Ijou = mysqli_fetch_assoc($jou);
$ijou = $Ijou['COUNT(*)'];

$total_time = 0;
foreach ($journal as $row) {
  $total_time = $total_time + $row['math'] + $row['eng'] + $row['inf'] + $row['jap'];

}

//日付取得
date_default_timezone_set ('Asia/Tokyo');
//本日の日付
$today = date('Y-m-d');
//データを取得する最初の日付
$first_day = new DateTime('2020-1-24');
$next_day = $first_day->format('Y-m-d');

//配列用変数
$i = 0;
//空の配列
$achieve = array();
//達成度平均のデータ取得
while ($next_day < $today) {
  //データ取得からの変換
  $ave = mysqli_query($con, "SELECT AVG(achievement) FROM journal2 WHERE j_day = '".$next_day."' ORDER BY j_day ASC");
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
$first_day = new DateTime('2020-1-24');
$next_day = $first_day->format('Y-m-d');
//空の配列
$total = array();
//達成度平均のデータ取得
while ($next_day < $today) {
  //データ取得からの変換
  $sum = mysqli_query($con, "SELECT AVG(total) FROM journal2 WHERE j_day = '".$next_day."' ORDER BY j_day ASC");
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


if ($_SERVER['REQUEST_METHOD'] == "POST"){
  //下のフォームの「変更」が実行された時
  if (array_key_exists("Registration", $_POST)) {
  //下のフォームで入力された値でデータベースを更新
  $result = mysqli_query($con, "INSERT contract SET user_id = '". $username ."', flag = 1, url = 'image/". $username .".jpg', Permission = 0");
  }
}

$con1 = mysqli_query($con, "SELECT flag FROM contract WHERE user_id='". $username . "'");
$row = mysqli_fetch_row($con1);
$Ic = $row[0];

$con2 = mysqli_query($con, "SELECT Permission FROM contract WHERE user_id='". $username . "'");
$row = mysqli_fetch_row($con2);
$Ic2 = $row[0];

//感情グラフ用データ
$e0 = mysqli_query($con, "SELECT COUNT(*) FROM journal2 WHERE user_id='". $username . "' AND emotion=0");
$ee0 = mysqli_fetch_assoc($e0);
$ie0 = $ee0['COUNT(*)'];
$e1 = mysqli_query($con, "SELECT COUNT(*) FROM journal2 WHERE user_id='". $username . "' AND emotion=1");
$ee1 = mysqli_fetch_assoc($e1);
$ie1 = $ee1['COUNT(*)'];
$e2 = mysqli_query($con, "SELECT COUNT(*) FROM journal2 WHERE user_id='". $username . "' AND emotion=2");
$ee2 = mysqli_fetch_assoc($e2);
$ie2 = $ee2['COUNT(*)'];
$e3 = mysqli_query($con, "SELECT COUNT(*) FROM journal2 WHERE user_id='". $username . "' AND emotion=3");
$ee3 = mysqli_fetch_assoc($e3);
$ie3 = $ee3['COUNT(*)'];


//通知機能
$cc1 = mysqli_query($con, "SELECT COUNT(*) FROM notification WHERE user_id='". $username . "' AND flag=1");
$ccc1 = mysqli_fetch_assoc($cc1);
$icc1 = $ccc1['COUNT(*)'];
if($Ic > 0 && $icc1 == 0){
  $In_con = mysqli_query($con, "INSERT notification SET user_id = '". $username ."', log_day = '". $now ."', content = '学習契約書の登録が完了しました！', flag = 1");
}

$progress = mysqli_query($con, "SELECT COUNT(*) FROM goal_list WHERE user_id='". $username . "' AND c_flag = 1");
$pro = mysqli_fetch_assoc($progress);
$pro_INT = $pro['COUNT(*)'];
$All_goal = mysqli_query($con, "SELECT COUNT(*) FROM goal_list WHERE user_id='". $username . "'");
$All = mysqli_fetch_assoc($All_goal);
$All_INT = $All['COUNT(*)'];

$level = $pro_INT / $All_INT * 100;
$le = round($level, 1);

//通知機能
if($le < 30){
  $delete_30 = mysqli_query($con, "DELETE FROM notification WHERE user_id='". $username . "' AND flag = 2");
  $delete_50 = mysqli_query($con, "DELETE FROM notification WHERE user_id='". $username . "' AND flag = 3");
  $delete_80 = mysqli_query($con, "DELETE FROM notification WHERE user_id='". $username . "' AND flag = 4");
  $delete_100 = mysqli_query($con, "DELETE FROM notification WHERE user_id='". $username . "' AND flag = 5");
}else if($le >= 30 && $le < 50){
  $not_30 = mysqli_query($con, "SELECT COUNT(*) FROM notification WHERE user_id='". $username . "' AND flag = 2");
  $no_30 = mysqli_fetch_assoc($not_30);
  $INT_30 = $no_30['COUNT(*)'];
  if($INT_30 == 0){
      $In_con = mysqli_query($con, "INSERT notification SET user_id = '". $username ."', log_day = '". $now ."', content = 'あなたのToDoの進捗が30%を達成しました!', content2 = '達成度が30%に到達しました！この調子で学習を計画的に進めていきましょう！', flag = 2");
  }
  $delete_50 = mysqli_query($con, "DELETE FROM notification WHERE user_id='". $username . "' AND flag = 3");
  $delete_80 = mysqli_query($con, "DELETE FROM notification WHERE user_id='". $username . "' AND flag = 4");
  $delete_100 = mysqli_query($con, "DELETE FROM notification WHERE user_id='". $username . "' AND flag = 5");
}else if($le >= 50 && $le < 80){
  $not_50 = mysqli_query($con, "SELECT COUNT(*) FROM notification WHERE user_id='". $username . "' AND flag = 3");
  $no_50 = mysqli_fetch_assoc($not_50);
  $INT_50 = $no_50['COUNT(*)'];
  if($INT_50 == 0){
      $In_con = mysqli_query($con, "INSERT notification SET user_id = '". $username ."', log_day = '". $now ."', content = 'あなたのToDoの進捗が50%を達成しました!', content2 = '達成度が50%に到達しました！この調子で学習を計画的に進めていきましょう！', flag = 3");
  }
  $delete_80 = mysqli_query($con, "DELETE FROM notification WHERE user_id='". $username . "' AND flag = 4");
  $delete_100 = mysqli_query($con, "DELETE FROM notification WHERE user_id='". $username . "' AND flag = 5");
}else if($le >= 80 && $le < 100){
  $not_80 = mysqli_query($con, "SELECT COUNT(*) FROM notification WHERE user_id='". $username . "' AND flag = 4");
  $no_80 = mysqli_fetch_assoc($not_80);
  $INT_80 = $no_80['COUNT(*)'];
  if($INT_80 == 0){
      $In_con = mysqli_query($con, "INSERT notification SET user_id = '". $username ."', log_day = '". $now ."', content = 'あなたのToDoの進捗が80%を達成しました!', content2 = '達成度が80%に到達しました！ゴールまでもう少しです。最後まで気を抜かずに頑張っていきましょう！', flag = 4");
  }
  $delete_100 = mysqli_query($con, "DELETE FROM notification WHERE user_id='". $username . "' AND flag = 5");
}else if($le == 100){
  $not_100 = mysqli_query($con, "SELECT COUNT(*) FROM notification WHERE user_id='". $username . "' AND flag = 5");
  $no_100 = mysqli_fetch_assoc($not_100);
  $INT_100 = $no_100['COUNT(*)'];
  if($INT_100 == 0){
      $In_con = mysqli_query($con, "INSERT notification SET user_id = '". $username ."', log_day = '". $now ."', content = 'あなたのToDoの進捗が100%を達成しました!', content2 = '達成度が100%に到達しました！お疲れ様でした！', flag = 5");
  }
}

$ave = mysqli_query($con, "SELECT AVG(achievement) FROM journal2 WHERE user_id='". $username . "'");
$time_Ave = mysqli_fetch_assoc($ave);
$t_ave = $time_Ave['AVG(achievement)'];
$t_ave = floor($t_ave);
$sum = mysqli_query($con, "SELECT SUM(total) FROM journal2 WHERE user_id='". $username . "'");
$time_Sum = mysqli_fetch_assoc($sum);
$t_sum = $time_Sum['SUM(total)'];

if($t_sum >= 30 && $t_sum < 50){
  $time_30 = mysqli_query($con, "SELECT COUNT(*) FROM notification WHERE user_id='". $username . "' AND flag = 6");
  $ti_30 = mysqli_fetch_assoc($time_30);
  $INT_30 = $ti_30['COUNT(*)'];
  if($INT_30 == 0){
      $In_con = mysqli_query($con, "INSERT notification SET user_id = '". $username ."', log_day = '". $now ."', content = 'あなたの累計学習時間が30時間を超えました!', content2 = 'グラフを見て自分の学習時間の状況を確認してみましょう！', flag = 6");
  }
}else if($t_sum >= 50 && $t_sum < 80){
  $time_50 = mysqli_query($con, "SELECT COUNT(*) FROM notification WHERE user_id='". $username . "' AND flag = 7");
  $ti_50 = mysqli_fetch_assoc($time_50);
  $INT_50 = $ti_50['COUNT(*)'];
  if($INT_50 == 0){
      $In_con = mysqli_query($con, "INSERT notification SET user_id = '". $username ."', log_day = '". $now ."', content = 'あなたの累計学習時間が50時間を超えました!', content2 = 'グラフを見て自分の学習時間の状況を確認してみましょう！', flag = 7");
  }
}else if($t_sum >= 80 && $t_sum < 100){
  $time_80 = mysqli_query($con, "SELECT COUNT(*) FROM notification WHERE user_id='". $username . "' AND flag = 8");
  $ti_80 = mysqli_fetch_assoc($time_80);
  $INT_80 = $ti_80['COUNT(*)'];
  if($INT_80 == 0){
      $In_con = mysqli_query($con, "INSERT notification SET user_id = '". $username ."', log_day = '". $now ."', content = 'あなたの累計学習時間が80時間を超えました!', content2 = 'グラフを見て自分の学習時間の状況を確認してみましょう！', flag = 8");
  }
}else if($t_sum >= 100 && $t_sum < 150){
  $time_100 = mysqli_query($con, "SELECT COUNT(*) FROM notification WHERE user_id='". $username . "' AND flag = 9");
  $ti_100 = mysqli_fetch_assoc($time_100);
  $INT_100 = $ti_100['COUNT(*)'];
  if($INT_100 == 0){
      $In_con = mysqli_query($con, "INSERT notification SET user_id = '". $username ."', log_day = '". $now ."', content = 'あなたの累計学習時間が100時間を超えました!', content2 = 'グラフを見て自分の学習時間の状況を確認してみましょう！', flag = 9");
  }
}else if($t_sum >= 150 && $t_sum < 200 ){
  $time_150 = mysqli_query($con, "SELECT COUNT(*) FROM notification WHERE user_id='". $username . "' AND flag = 10");
  $ti_150 = mysqli_fetch_assoc($time_150);
  $INT_150 = $ti_150['COUNT(*)'];
  if($INT_150 == 0){
      $In_con = mysqli_query($con, "INSERT notification SET user_id = '". $username ."', log_day = '". $now ."', content = 'あなたの累計学習時間が150時間を超えました!', content2 = 'グラフを見て自分の学習時間の状況を確認してみましょう！', flag = 10");
  }
}else if($t_sum >= 200 && $t_sum < 300 ){
  $time_200 = mysqli_query($con, "SELECT COUNT(*) FROM notification WHERE user_id='". $username . "' AND flag = 11");
  $ti_200 = mysqli_fetch_assoc($time_200);
  $INT_200 = $ti_200['COUNT(*)'];
  if($INT_200 == 0){
      $In_con = mysqli_query($con, "INSERT notification SET user_id = '". $username ."', log_day = '". $now ."', content = 'あなたの累計学習時間が200時間を超えました!', content2 = 'グラフを見て自分の学習時間の状況を確認してみましょう！', flag = 11");
  }
}else if($t_sum >= 300 && $t_sum < 500 ){
  $time_300 = mysqli_query($con, "SELECT COUNT(*) FROM notification WHERE user_id='". $username . "' AND flag = 12");
  $ti_300 = mysqli_fetch_assoc($time_300);
  $INT_300 = $ti_300['COUNT(*)'];
  if($INT_300 == 0){
      $In_con = mysqli_query($con, "INSERT notification SET user_id = '". $username ."', log_day = '". $now ."', content = 'あなたの累計学習時間が300時間を超えました!', content2 = 'グラフを見て自分の学習時間の状況を確認してみましょう！', flag = 12");
  }
}else if($t_sum >= 500 && $t_sum < 750 ){
  $time_500 = mysqli_query($con, "SELECT COUNT(*) FROM notification WHERE user_id='". $username . "' AND flag = 13");
  $ti_500 = mysqli_fetch_assoc($time_500);
  $INT_500 = $ti_500['COUNT(*)'];
  if($INT_500 == 0){
      $In_con = mysqli_query($con, "INSERT notification SET user_id = '". $username ."', log_day = '". $now ."', content = 'あなたの累計学習時間が500時間を超えました!', content2 = 'グラフを見て自分の学習時間の状況を確認してみましょう！', flag = 13");
  }
}else if($t_sum >= 750 && $t_sum < 1000 ){
  $time_750 = mysqli_query($con, "SELECT COUNT(*) FROM notification WHERE user_id='". $username . "' AND flag = 14");
  $ti_750 = mysqli_fetch_assoc($time_750);
  $INT_750 = $ti_750['COUNT(*)'];
  if($INT_750 == 0){
      $In_con = mysqli_query($con, "INSERT notification SET user_id = '". $username ."', log_day = '". $now ."', content = 'あなたの累計学習時間が750時間を超えました!', content2 = 'グラフを見て自分の学習時間の状況を確認してみましょう！', flag = 14");
  }
}else if($t_sum >= 1000){
  $time_1000 = mysqli_query($con, "SELECT COUNT(*) FROM notification WHERE user_id='". $username . "' AND flag = 15");
  $ti_1000 = mysqli_fetch_assoc($time_1000);
  $INT_1000 = $ti_1000['COUNT(*)'];
  if($INT_1000 == 0){
      $In_con = mysqli_query($con, "INSERT notification SET user_id = '". $username ."', log_day = '". $now ."', content = 'あなたの累計学習時間が1000時間を超えました!', content2 = 'グラフを見て自分の学習時間の状況を確認してみましょう！', flag = 15");
  }
}

$get_not = mysqli_query($con, "SELECT * FROM notification WHERE user_id='". $username . "' OR user_id='all' ORDER BY log_day DESC");
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>学習支援システム</title>
<link rel="stylesheet" href="css/style.css">
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
<!--小さな端末用（800px以下端末）メニュー-->
<nav id="menubar-s">
<ul>
<li><a href="main.php?user=<?php echo $username;?>">メイン</a></li>
<li><a href="journal1.php?user=<?php echo $username;?>">学習日誌</a></li>
<li><a href="style.php?user=<?php echo $username;?>">学習スタイル</a></li>
<li><a href="progress/todo1.php?user=<?php echo $username;?>">ToDoリスト</a></li>
<?php
if($Ic < 1){
?>
<li><a href="contract_edit0.php?user=<?php echo $username;?>">自己変革プラン</a></li>
<?php
}
?>
<li><a href="help.php?user=<?php echo $username;?>">ヘルプ</a></li>
<li><a href="https://prep.ipusoft-el.jp/">入学前教育サイトへ</a></li>
</ul>
</nav>

<!-- BootstrapのCSS読み込み -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<!-- jQuery読み込み -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.0.js"></script>
<!-- BootstrapのJS読み込み -->
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<!-- メニュー開閉用-->
<script type="text/javascript" src="js/openclose.js"></script>
<script type="text/javascript" src="js/fixmenu_pagetop.js"></script>
<script>
google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart1);

      function drawChart1() {
        var data = google.visualization.arrayToDataTable([
          ['月日', 'みんなの平均', 'あなた'],
          <?php
          $no = 0;
          foreach ($journal as $value) {
          echo '[\''.$value["j_day"].'\', '.floor($achieve[$no]).', '.floor($value["achievement"]).']';
          $no++;
          if ($no !== $j_row) {
          echo ",\n";
          }
        }
        ?>
        ]);
        var options = {
          title: '達成度の推移',
          hAxis: {title: '月日',  format: "####", gridlines:{color:'transparent'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div1'));
        chart.draw(data, options);
      }



google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart2);

      function drawChart2() {
        var data = google.visualization.arrayToDataTable([
          ['月日', 'みんなの平均', 'あなた'],
          <?php
          //空の配列
          $my_total = array();
          $no = 0;
          foreach ($journal as $value) {
          if($no == 0){
          array_push($my_total , $value["total"]);
          echo '[\''.$value["j_day"].'\', '.floor($total[$no]).', '.floor($value["total"]).']';
          }else{
          $i = $no - 1;
          $sum = $my_total[$i] + $value["total"];
          array_push($my_total , $sum);
          echo '[\''.$value["j_day"].'\', '.floor($total[$no]).', '.floor($my_total[$no]).']';
          }
          $no++;
          if ($no !== $j_row) {
          echo ",\n";
          }
        }
        ?>
        ]);
        var options = {
          title: '累計学習時間の推移',
          hAxis: {title: '月日',  format: "####", gridlines:{color:'transparent'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div2'));
        chart.draw(data, options);
      }


      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart3);
      function drawChart3() {

        var data = google.visualization.arrayToDataTable([
          ['感情', '回数'],
          <?php
          echo '[\'やる気があった\','. $ie0 .'],';
          echo '[\'イライラしていた\','. $ie1 .'],';
          echo '[\'集中していた\','. $ie2 .'],';
          echo '[\'不安だった\','. $ie3 .']';
          ?>
        ]);

        var options = {
          title: '感情グラフ'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }

  </script>


<div id="container">

<header>
<h1 id="logo"><a href="main.php?user=<?php echo $username;?>"><img src="images/logo.png" alt="学習支援システム"></a></h1>
<ul id="menubar" class="nav">
<li><a href="main.php?user=<?php echo $username;?>">メイン</a></li>
<li><a href="journal1.php?user=<?php echo $username;?>">学習日誌</a></li>
<li><a href="style.php?user=<?php echo $username;?>">学習スタイル</a></li>
<li><a href="progress/todo1.php?user=<?php echo $username;?>">ToDoリスト</a></li>
<?php
if($Ic < 1){
?>
<li><a href="contract_edit0.php?user=<?php echo $username;?>">自己変革プラン</a></li>
<?php
}
?>
<li><a href="help.php?user=<?php echo $username;?>">ヘルプ</a></li>
<li><a href="https://prep.ipusoft-el.jp/">入学前教育サイトへ</a></li>
</ul>
</header>

<div id="contents">

<section id="new">
<h2>お知らせ</h2>
<dl id="newinfo">
<?php
$i = 0;
foreach($get_not as $row){
    if($i == 5){
      break;
  }else{
    ?>
    <dt><?php echo date('Y-m-d', strtotime($row['log_day'])); ?></dt>
    <dd><a href="text.php?user=<?php echo $username;?>&id=<?php echo $row['id'];?>"><?php echo $row['content']; ?></a></dd>  
    <?php
  }
  $i++;
}
?>
</dl>
<p class="r"><a href="log.php?user=<?php echo $username;?>">過去ログ</a></p>
</section>
<br><br>

<?php
if($Ic == 0 && $ijou == 0){
?>
<section>


<h2>メインページについて</h2>

<h3>あなたの学習を記録しよう！</h3>
・このメインページでは登録された学習記録が図やグラフとなって表示されます。<br>
・各種機能で学習について振り返りしつつ、このページを確認して自分の学習状況を振り返ってみましょう！<br>
</p>

<h3>各機能の使い方</h3>

<p><strong class="color1">■実際に学習の振り返りを記録してみよう！</strong><br>
<b>【1.学習日誌】</b><br>
・学習日誌ではその日の学習状況を振り返ることができます。<br>
・学習日誌は毎週金曜日にあるので忘れずに取り組みましょう！<br>
・学習日誌は1/24から開始となります。<br>
<b>【2.学習スタイル】</b><br>
・学習スタイルでは質問に回答することであなたの学習傾向を知ることができます。<br>
・入学前教育をスタートする前に一度回答してみましょう！<br>
・あなたの学習傾向を知ることで目標を考えるヒントになるかもしれません。<br>
・1/30までに必ず行ってください。10分程度で終わります。<br>
<b>【3.ToDo管理機能】</b><br>
・ToDo管理機能では教科ごとにToDo(やること)を設定できます<br>
・学習計画の達成を目指してやるべきことを登録しておきましょう！<br>
<b>【4.自己変革プラン(契約書)の作成】</b><br>
・2月14日以降より取り組んでもらう課題となります。<br>
・可視化された学習データを元に振り返りをしてみましょう！<br>
・その上で、自分の学習行動の中で改善したいと思うことを考え、自己変革プランを作成してみましょう！<br>
</p>

</section>

<?php
}else if($Ic == 0 && $ijou > 0){
?>

<h2>メインページ</h2>
<div class="container-fluid">
  <!--row開始-->
  <div class="row">
      <div class="col-md-12 col-ld-6 border border-dark bg-light">あなたの達成度の平均:<?php echo $t_ave;?>%</div>
      <div class="col-md-12 col-ld-6 border border-dark bg-light" id="chart_div1"></div>
    </div>
    <div class="row">
      <div class="col-md-12 col-ld-6 border border-dark bg-light">あなたの学習時間の累計:<?php echo $t_sum;?>時間</div>
      <div class="col-md-12 col-ld-6 border border-dark bg-light" id="chart_div2"></div>
    </div>
    <div class="row">
      <div class="col-md-12 col-ld-6 border border-dark bg-light">あなたの感情グラフ</div>
      <div class="col-md-12 col-ld-6 border border-dark bg-light" id="piechart"></div>
    </div>
    <div class="row">
      <div class="col-md-12 col-ld-6 border border-dark" style="width:100%; height:250px;  overflow-y:scroll;">
      <table class="ta1" border="1" cellspacing="0" cellpadding="5" bordercolor="#333333" align="center" width="100%">
        <tr>
        <th colspan="2" class="tamidashi">過去の学習日誌</th>
        </tr>
        <tr bgcolor="silver" >
        <th><font color="white">月日</font></th>
        <th><font color="white">次回の目標</font></th>
        </tr>
        <?php 
        foreach ($journal as $key) {
          ?>
          <tr>
            <td width="20%"><?php echo date('n/j', strtotime($key["j_day"])); ?></td>
            <td width="80%"><?php echo $key["nextgoal"]; ?></td>
          </tr>
          <?php
        }
        ?>
      </table>
    </div>
    </div>
</div>

</section>

<br><br>

<section id="about">

<section>

<h2>メインページについて</h2>

<p><strong class="color1">■あなたの学習の記録を記録しよう</strong><br>
・このページでは設定したあなたが設定した目標や学習の記録が図やグラフとなって表示されます。<br>
・適宜、このページを確認して自分の学習状況を振り返ってみましょう！<br>
</p>


</section>

</section>
<?php

}else{


?>

<section>

<h2>メインページ</h2>

<!--契約書表示コード-->
<script type="text/javascript">
$('.gallery img').click(function(e) {
    $('#back-curtain')
        .css({
            'width' : $(window).width(),    // ウィンドウ幅
            'height': $(window).height()    // 同 高さ
        })
        .show();
    $('#largeImg')
        .css({
            'position': 'absolute',
            'left'    : Math.floor(($(window).width() - 800) / 2) + 'px',
            'top'     : $(window).scrollTop() + 30 + 'px'
        })
        .fadeIn();
});
// ④暗幕と拡大画像を非表示
$('#back-curtain, #largeImg').click(function() {
    $('#largeImg').fadeOut('slow', function() {$('#back-curtain').hide();});
});
</script>
<!--契約書表示　終わり-->



<div class="container-fluid">
  <!--row開始-->
  <div class="row">
    <!--縦長カラム-->
    <div class="col-sm-6 border border-dark bg-light text-center">
      <div class="gallery">
      <?php
      if($Ic == 1){
      ?>
      <img src="image/kari.jpg?<?php echo date("YmdHis");?>" width="100%">
      <?php
      }else if($Ic == 2){
      ?>
      <img src="image/<?php echo $username; ?>.jpg?<?php echo date("YmdHis");?>" width="100%">
      <?php
      }
      ?>
      <?php
      if($Ic2 == 1){
      ?>
      <p class="r"><a href="contract_visu.php?user=<?php echo $username;?>">→他のプランの閲覧</a></p>
      <?php
      }
      ?>
      </div>
    </div>

    <!--rowの中に最大８のrow-->
    <div class="col-sm-6">
    <div class="row">
      <div class="col-sm-12 border border-dark bg-light">あなたの達成度の平均:<?php echo $t_ave;?>%</div>
      <div class="col-sm-12 border border-dark bg-light" id="chart_div1"></div>
    </div>
    <div class="row">
      <div class="col-sm-12 border border-dark bg-light">あなたの学習時間の累計:<?php echo $t_sum;?>時間</div>
      <div class="col-sm-12 border border-dark bg-light" id="chart_div2"></div>
    </div>
    <div class="row">
            <div class="col-sm-12 border border-dark bg-light">あなたの感情グラフ</div>
      <div class="col-sm-12 border border-dark bg-light" id="piechart"></div>
    </div>
    </div>
    </div>
    <div class="row">
      <div class="col-sm-12 border border-dark" style="width:100%; height:250px;  overflow-y:scroll;">
      <table class="ta1" border="1" cellspacing="0" cellpadding="5" bordercolor="#333333" align="center" width="100%">
        <tr>
        <th colspan="2" class="tamidashi">過去の学習日誌</th>
        </tr>
        <tr bgcolor="silver" >
        <th><font color="white">月日</font></th>
        <th><font color="white">次回の目標</font></th>
        </tr>
        <?php 
        foreach ($journal as $key) {
          ?>
          <tr>
            <td width="20%"><?php echo date('n/j', strtotime($key["j_day"])); ?></td>
            <td width="80%"><?php echo $key["nextgoal"]; ?></td>
          </tr>
          <?php
        }
        ?>
      </table>
    </div>
    </div>
</div>

</section>

<br><br>

<section id="about">

<section>

<h2>メインページについて</h2>

<p><strong class="color1">■あなたの学習の記録を記録しよう</strong><br>
・このページでは設定したあなたが設定した目標や学習の記録が図やグラフとなって表示されます。<br>
・適宜、このページを確認して自分の学習状況を振り返ってみましょう！<br>
</p>


</section>

</section>

<?php
}
?>

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

<!--スマホ用更新情報　480px以下-->
<script type="text/javascript">
if (OCwindowWidth() <= 480) {
  open_close("newinfo_hdr", "newinfo");
}
</script>



</body>
</html>
