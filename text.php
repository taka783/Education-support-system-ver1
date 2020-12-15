<?php

//urlのid受け取り処理
if(isset($_GET['user'])){
$get_id = $_GET['user'];  
$username = $get_id;
}

//教科IDを取得
if(isset($_GET['id'])){
$id = $_GET['id'];  
}

date_default_timezone_set('Asia/Tokyo');
$now = date('Y-m-d H:i:s');

//次の画面へid引き渡し
//<a href="main_m.php?user='.$get_id.'"></a>

require "mysql.php";


$journal = mysqli_query($con, "SELECT * FROM journal1 WHERE user_id ='" . $username . "' AND total > 0");
$jou = mysqli_query($con, "SELECT COUNT(*) FROM journal1 WHERE user_id ='" . $username . "' AND total > 0");
$Ijou = mysqli_fetch_assoc($jou);
$ijou = $Ijou['COUNT(*)'];

$total_time = 0;
foreach ($journal as $row) {
  $total_time = $total_time + $row['mathA'] + $row['mathB'] + $row['mathC'] + $row['eng'] + $row['inf'] + $row['jap'];

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

$jo1 = mysqli_query($con, "SELECT log_day FROM notification WHERE (user_id='". $username . "' OR user_id='all') AND id = '".$id."'");
$row = mysqli_fetch_row($jo1);
$Jo1 = $row[0];
$jo2 = mysqli_query($con, "SELECT content FROM notification WHERE (user_id='". $username . "' OR user_id='all') AND id = '".$id."'");
$row = mysqli_fetch_row($jo2);
$Jo2 = $row[0];
$jo3 = mysqli_query($con, "SELECT content2 FROM notification WHERE (user_id='". $username . "' OR user_id='all') AND id = '".$id."'");
$row = mysqli_fetch_row($jo3);
$Jo3 = $row[0];

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

<h2>お知らせ</h2>

<table class="ta1">
<tr>
<th colspan="2" class="tamidashi">お知らせ</th>
</tr>
<tr>
<th width="30%">登録日</th>
<td width="70%"><?php echo date('Y-m-d', strtotime($Jo1)); ?></td>
</tr>

<tr>
<th>件名</th>
<td><?php echo $Jo2; ?></td>
</tr>

<tr>
<th>内容</th>
<td><?php echo $Jo3; ?></td>
</tr>
</table>

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

<!--スマホ用更新情報　480px以下-->
<script type="text/javascript">
if (OCwindowWidth() <= 480) {
  open_close("newinfo_hdr", "newinfo");
}
</script>



</body>
</html>
