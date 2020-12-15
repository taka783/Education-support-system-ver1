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

if($usermame == "manager"){
  ?>
  <meta http-equiv="Refresh" content="0; URL=manage/">
  <?php
  exit;
}

require "mysql.php";

$mathA = mysqli_query($con, "SELECT COUNT(*) FROM Goal WHERE user_id='". $username . "' AND subject=0");
$ImathA = mysqli_fetch_assoc($mathA);
$ImA = $ImathA['COUNT(*)'];
$mathAG = mysqli_query($con, "SELECT goal FROM Goal WHERE user_id ='" . $username . "' AND subject=0");
$row = mysqli_fetch_row($mathAG);
$mAG = $row[0];

$mathB = mysqli_query($con, "SELECT COUNT(*) FROM Goal WHERE user_id='". $username . "' AND subject=1");
$ImathB = mysqli_fetch_assoc($mathB);
$ImB = $ImathB['COUNT(*)'];
$mathBG = mysqli_query($con, "SELECT goal FROM Goal WHERE user_id ='" . $username . "' AND subject=1");
$row = mysqli_fetch_row($mathBG);
$mBG = $row[0];

$mathC = mysqli_query($con, "SELECT COUNT(*) FROM Goal WHERE user_id='". $username . "' AND subject=2");
$ImathC = mysqli_fetch_assoc($mathC);
$ImC = $ImathC['COUNT(*)'];
$mathCG = mysqli_query($con, "SELECT goal FROM Goal WHERE user_id ='" . $username . "' AND subject=2");
$row = mysqli_fetch_row($mathCG);
$mCG = $row[0];

$eng = mysqli_query($con, "SELECT COUNT(*) FROM Goal WHERE user_id='". $username . "' AND subject=3");
$Ieng = mysqli_fetch_assoc($eng);
$Ie = $Ieng['COUNT(*)'];
$engG = mysqli_query($con, "SELECT goal FROM Goal WHERE user_id ='" . $username . "' AND subject=3");
$row = mysqli_fetch_row($engG);
$eG = $row[0];

$inf = mysqli_query($con, "SELECT COUNT(*) FROM Goal WHERE user_id='". $username . "' AND subject=4");
$Iinf = mysqli_fetch_assoc($inf);
$Ii = $Iinf['COUNT(*)'];
$infG = mysqli_query($con, "SELECT goal FROM Goal WHERE user_id ='" . $username . "' AND subject=4");
$row = mysqli_fetch_row($infG);
$iG = $row[0];

$ja = mysqli_query($con, "SELECT COUNT(*) FROM Goal WHERE user_id='". $username . "' AND subject=5");
$Ija = mysqli_fetch_assoc($ja);
$Ij = $Ija['COUNT(*)'];
$jaG = mysqli_query($con, "SELECT goal FROM Goal WHERE user_id ='" . $username . "' AND subject=5");
$row = mysqli_fetch_row($jaG);
$jG = $row[0];

$g_flag = $ImA + $ImB + $ImC + $Ie + $Ii + $Ij;


$journal = mysqli_query($con, "SELECT * FROM journal1 WHERE user_id ='" . $username . "' AND total > 0");
$jou = mysqli_query($con, "SELECT COUNT(*) FROM journal1 WHERE user_id ='" . $username . "' AND total > 0");
$Ijou = mysqli_fetch_assoc($jou);
$ijou = $Ijou['COUNT(*)'];

$total_time = 0;
foreach ($journal as $row) {
  $total_time = $total_time + $row['mathA'] + $row['mathB'] + $row['mathC'] + $row['eng'] + $row['inf'] + $row['jap'];

}

$con1 = mysqli_query($con, "SELECT flag FROM contract WHERE user_id='". $username . "'");
$row = mysqli_fetch_row($con1);
$Ic = $row[0];

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
<li><a href="progress/todo1php?user=<?php echo $username;?>">ToDoリスト</a></li>
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


<h2>ヘルプページ</h2>

<section>
<h3>学習の進め方</h3>
<img border="0" class="c" src="images/project.png" width="100%" alt="イラスト1">
<br>
<p><strong class="color1">【STEP1】設定した目標や計画の達成を目指して課題を進めてもらう(1月24日〜2月13日)</strong><br>
・入学前教育の最初に定めた目標や学習計画を達成するためにみなさんには普段通りの学習を進めてもらいます。<br>
・この【STEP1】の期間は次のSTEPで反省・評価を行えるようにするためにデータを収集する期間です。<br>
・みなさんには学習の合間に「学習日誌」や「ToDo機能」を使って振り返りを行なってもらいます。<br>
→学習日誌では振り返りの質問項目が設けられているので、それに回答してもらいます。<br>
<b><u>金曜日の学習日誌は必須なので必ず行うようにしましょう。</u></b><br>
→ToDo機能ではToDo(やること)を登録して、そのリストの管理を行うものです。目標達成のために必要な項目をリストアップして、タスク管理を行なっていきましょう。<br>
<p><strong class="color1">【STEP2】これまでの振り返り＆学習誓約書作成(2月14日〜2月28日)</strong><br>
・この期間では【STEP1】までの学習について振り返りを行なってもらいます。<br>
・【STEP1】で収集されたデータがグラフ等で可視化されるようになるので、そのデータから振り返りを行い自分の学びの中の問題点を発見してもらいます。<br>
・<b><u>発見した問題点の中から自分が特に改善したいと思う点を選んで、それを改善する方法や期間などを考えてもらい、学習誓約書を作成してもらいます。</u></b><br>
<p><strong class="color1">【STEP3】入学前教育再開(2月29日〜3月19日)</strong><br>
・【STEP2】ではみなさんの学びの問題点とそれを改善するための作戦について考えてもらいました。<br>
・【STEP3】は学習誓約書作成の際に考えてもらった作戦を実際に実践してもらいます。<br>
<p><strong class="color1">【STEP5】振り返り(3月19日〜)</strong><br>
・全てのSTEPを通しての振り返りを行なってもらいます。<br>
</p>

</section>


<section>
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
