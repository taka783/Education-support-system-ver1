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

<h2>過去のお知らせ</h2>

<table class="ta1">
<tr>
<th class="tamidashi">登録日</th>
<th class="tamidashi">件名</th>
</tr>
<?php
$get_not = mysqli_query($con, "SELECT * FROM notification WHERE user_id='". $username . "' OR user_id='all' ORDER BY log_day DESC");
foreach ($get_not as $row) {
?>
<tr>
<td width="30%"><?php echo date('Y-m-d', strtotime($row['log_day'])); ?></td>
<td width="70%"><a href="text.php?user=<?php echo $username;?>&id=<?php echo $row['id'];?>"><?php echo $row['content']; ?></a></td>
</tr>

<?php
}
?>

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