<?php

//urlのid受け取り処理
if(isset($_GET['user'])){
$get_id = $_GET['user'];  
$username = $get_id;
}

if(isset($_GET['id'])){
$id = $_GET['id'];  
}


//次の画面へid引き渡し
//<a href="main_m.php?user='.$get_id.'"></a>

require "mysql.php";

if ($_SERVER['REQUEST_METHOD'] == "POST"){
  //下のフォームの「変更」が実行された時
  if (array_key_exists("Registration", $_POST)) {
  //下のフォームで入力された値でデータベースを更新
  $result = mysqli_query($con, "INSERT contract SET user_id = '". $username ."', flag = 1, url = 'image/". $username .".jpg'");
  }
}

$con1 = mysqli_query($con, "SELECT flag FROM contract WHERE user_id='". $username . "'");
$row = mysqli_fetch_row($con1);
$Ic = $row[0];


$jo1 = mysqli_query($con, "SELECT * FROM journal1 WHERE user_id='". $username . "' ORDER BY j_day DESC");
$jo2 = mysqli_query($con, "SELECT * FROM journal1 WHERE user_id='". $username . "' AND total > 0 ORDER BY j_day DESC");
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
<!-- BootstrapのJS読み込み -->
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<!-- メニュー開閉用-->
<script type="text/javascript" src="js/openclose.js"></script>
<script type="text/javascript" src="js/fixmenu_pagetop.js"></script>

<div id="container">


<header>
<h1 id="logo"><a href="main.php?user=<?php echo $username;?>"><img src="images/logo.png" alt="学習支援システム"></a></h1>
</header>

<div id="contents">


<section>
<?php
if($id == 0){
?>

<h2>過去の学習日誌一覧</h2>
<table class='ta1'>
  <tr>
  <th class='tamidashi' >登録日</th>
  <th class='tamidashi' >良かった点＆悪かった点</th>
  </tr>
  <?php
  foreach($jo1 as $row){
  ?>
  <tr>
  <?php
  echo "<td>".$row['j_day']."</td><td>".$row['goodbad']."</td>";
}s
?>
</tr>
</table>
<?php
}else if($id == 1){
?>
<h2>過去の学習日誌一覧</h2>
<table class='ta1'>
  <tr>
  <th class='tamidashi' width="15%">登録日</th>
  <th class='tamidashi' width="85%">良かった点＆悪かった点</th>
  </tr>
  <?php
  foreach($jo2 as $row){
  ?>
  <tr>
  <?php
  echo "<td>".$row['j_day']."</td><td>".$row['nextgoal']."</td>";
}
?>
</tr>
</table>
<?php 
}
?>
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
