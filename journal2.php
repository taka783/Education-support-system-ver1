<?php

//urlのid受け取り処理
if(isset($_GET['user'])){
$get_id = $_GET['user'];  
$username = $get_id;
}

$ja_id = 0;

if(isset($_GET['id'])){
$id = $_GET['id'];  
}

if(isset($_GET['ja'])){
$ja_id = $_GET['ja'];  
}

if(isset($_GET['year'])){
$year = $_GET['year'];  
}

if(isset($_GET['month'])){
$month = $_GET['month'];  
}

if(isset($_GET['date'])){
$date = $_GET['date'];  
}

$j_flag = 0;

if($month == 11){
  $j_flag = 1;
}

$while = "-";

$da = $year.$while.$month.$while.$date;
$ref=strtotime($da);
$last_week = date('Y-m-d', strtotime('-1 week', $ref));


//次の画面へid引き渡し
//<a href="main_m.php?user='.$get_id.'"></a>

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


$jo1 = mysqli_query($con, "SELECT math FROM journal2 WHERE user_id='". $username . "' AND j_day = '".$da."'");
$row = mysqli_fetch_row($jo1);
$Jo1 = $row[0];
$jo4 = mysqli_query($con, "SELECT eng FROM journal2 WHERE user_id='". $username . "' AND j_day = '".$da."'");
$row = mysqli_fetch_row($jo4);
$Jo4 = $row[0];
$jo5 = mysqli_query($con, "SELECT inf FROM journal2 WHERE user_id='". $username . "' AND j_day = '".$da."'");
$row = mysqli_fetch_row($jo5);
$Jo5 = $row[0];
$jo6 = mysqli_query($con, "SELECT jap FROM journal2 WHERE user_id='". $username . "' AND j_day = '".$da."'");
$row = mysqli_fetch_row($jo6);
$Jo6 = $row[0];
$jo7 = mysqli_query($con, "SELECT emotion FROM journal2 WHERE user_id='". $username . "' AND j_day = '".$da."'");
$row = mysqli_fetch_row($jo7);
$Jo7 = $row[0];
$jo8 = mysqli_query($con, "SELECT goodbad FROM journal2 WHERE user_id='". $username . "' AND j_day = '".$da."'");
$row = mysqli_fetch_row($jo8);
$Jo8 = $row[0];
$jo9 = mysqli_query($con, "SELECT achievement FROM journal2 WHERE user_id='". $username . "' AND j_day = '".$da."'");
$row = mysqli_fetch_row($jo9);
$Jo9 = $row[0];
$jo10 = mysqli_query($con, "SELECT nextgoal FROM journal2 WHERE user_id='". $username . "' AND j_day = '".$da."'");
$row = mysqli_fetch_row($jo10);
$Jo10 = $row[0];

if($ja_id == 3){
$jo7 = mysqli_query($con, "SELECT emotion FROM journal2 WHERE user_id='". $username . "' AND j_day = '".$da."'");
$row = mysqli_fetch_row($jo7);
$Jo7 = $row[0];
$jo8 = mysqli_query($con, "SELECT goodbad FROM journal2 WHERE user_id='". $username . "' AND j_day = '".$da."'");
$row = mysqli_fetch_row($jo8);
$Jo8 = $row[0];
$jo9 = mysqli_query($con, "SELECT achievement FROM journal2 WHERE user_id='". $username . "' AND j_day = '".$da."'");
$row = mysqli_fetch_row($jo9);
$Jo9 = $row[0];
$jo10 = mysqli_query($con, "SELECT nextgoal FROM journal2 WHERE user_id='". $username . "' AND j_day = '".$da."'");
$row = mysqli_fetch_row($jo10);
$Jo10 = $row[0];
}

$last_goal = mysqli_query($con, "SELECT nextgoal FROM journal2 WHERE user_id='". $username . "' AND j_day = '".$last_week."'");
$row = mysqli_fetch_row($last_goal);
$lg = $row[0];
$row_cnt = mysqli_num_rows($last_goal);

$con1 = mysqli_query($con, "SELECT COUNT(*) FROM contract WHERE user_id='". $username . "' AND flag=2");
$Icon = mysqli_fetch_assoc($con1);
$Ic = $Icon['COUNT(*)'];
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
  <!-- BootstrapのCSS読み込み -->
<link href="css/bootstrap.min.css" rel="stylesheet">
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


<section>

<h2>学習日誌</h2>

<div class="container-fluid">
  <div class="row">
  <div class="col-md-7">
<h3><?php echo $month; ?>月<?php echo $date; ?>日の学習日誌</h3>
<?php
if($ja_id == 0){
?>
<?php
if($row_cnt > 0){
?>
先週の目標(<?php echo $last_week; ?>)
<h6><font size="5"><?php echo $lg; ?></font></h6>
<br><br>
<?php
}
?>
<form action="journal1.php?user=<?php echo $username;?>&today=<?php echo $da;?>" method="post">
<table class="ta1">
<tr>
<th colspan="2" class="tamidashi">入力フォーム</th>
</tr>
<tr>
<th>数学(時間)</th>
<td><input type="number" name="math" min="0" style="width: 90%; height: 100%; "/>時間</td>
</tr>

<tr>
<th>英語(時間)</th>
<td><input type="number" name="eng" min="0" style="width: 90%; height: 100%; "/>時間</td>
</tr>

<th>情報(時間)</th>
<td><input type="number" name="inf" min="0" style="width: 90%; height: 100%; "/>時間</td>
</tr>

<tr>
<th>国語(時間)</th>
<td><input type="number" name="jap" min="0" style="width: 90%; height: 100%; "/>時間</td>
</tr>

<tr>
<th>学習中の感情</th>
<td>
<select name="emotion" align="left" required="" style="width: 100%; height: 100%; ">
<option value="0">やる気があった</option>
<option value="1">イライラしていた</option>
<option value="2">集中していた</option>
<option value="3">不安だ</option>
</select></td>
</tr>
<?php
if($Ic > 0){
?>
<tr>
<th>変革プランの遂行度<br>(0-100)%</th>
<td><input type="number" name="con_achieve" min="0" max="100" style="width: 90%; height: 100%; "/>%</td>
</tr>
<?php
}
?>
<tr>
<th>良かった点<br>悪かった点</th>
<td><textarea name="goodbad" rows="4" cols="50" wrap="soft" required="" autocomplete='off'maxlength="200" style="width: 100%; height: 100%; "></textarea></td>
</tr>
<tr>
<th>達成度<br>(0-100)%</th>
<td><input type="number" name="achievement" min="0" max="100" style="width: 90%; height: 100%; "/>%</td>
</tr>
<tr>
<th>次回の目標</th>
<td><textarea name="nextgoal" rows="4" cols="50" wrap="soft" required="" autocomplete='off'maxlength="200" style="width: 100%; height: 100%; "></textarea></td>
</tr>
</table>
</div>
<div class="col-md-5 border-left">
  <br>
  <b>学習日誌の項目について</b><br><br>
  【数学, 英語, 情報, 国語】<br>
  ▶︎それぞれの学習時間についてその週にどれくらい取り組んだかを大まかでいいので記入してください.<br>
  【学習中の感情】<br>
  ▶︎その週の学習ではどういった感情で学習していることが一番多かったのかを考えて選択してください.<br>
  【良かった点・悪かった点】<br>
  ▶︎その週の学習であった良かったこと悪かったことを最低1つはあげてください.<br>
  【達成度】<br>
  ▶︎その週の学習の出来を0〜100%で評価してみてください.<br>
  【次回の目標】<br>
  ▶︎来週までに達成したい目標を決めてください. 小さな目標でも構いません. 悪かった点があった人はそれを改善するための目標を決めましょう.<br>
  <?php
  if($Ic > 0){
  ?>
  【変革プランの遂行度(0-100)%】<br>
    ▶︎プランの遂行具合を評価しましょう.<br>
  <?php       
  }
  ?>
  <hr>
  <b>書き方の注意事項</b><br>
  ・「しっかり〇〇」などの表現は控え, 具体的に書いてみましょう.(どのようにするのかを！)<br>
  ・記述欄では最低でも１行以上でまとめましょう.<br>


</div>
</div>
</div>
<br>
<div class=" container-fluid">
<div class="row">
<div class="right-block col-sm-6 text-right">
<input type="submit" name="journal1" class="btn-gradient-simple" value="登録"> 
</form>
</div>
<div class="center-block col-sm-6 text-left">
<form action="journal1.php?user=<?php echo $username;?>&year=<?php echo $year;?>&month=<?php echo $month;?>&id=1" method="post">
   <button type="submit" class="btn-gradient-simple">学習日誌へ戻る</button> 
</form>
</div>
</div>

    <?php
}else if($ja_id == 1){
  ?>
<table class="ta1">
<tr>
<th colspan="2" class="tamidashi">記録</th>
</tr>
<tr>
<th width="30%">数学(時間)</th>
<td width="70%"><?php echo $Jo1; ?>時間</td>
</tr>

<tr>
<th>英語(時間)</th>
<td><?php echo $Jo4; ?>時間</td>
</tr>

<th>情報(時間)</th>
<td><?php echo $Jo5; ?>時間</td>
</tr>

<tr>
<th>国語(時間)</th>
<td><?php echo $Jo6; ?>時間</td>
</tr>

<tr>
<th>学習中の感情</th>
<td>
<?php 
if($Jo7 == 0){
  echo "やる気があった";
}else if($Jo7 == 1){
  echo "イライラしていた";
}else if($Jo7 == 2){
  echo "集中していた";
}else if($Jo7 == 3){
  echo "不安だ";
}
?>
</td>
</tr>
<tr>
<th>良かった点・悪かった点</th>
<td><?php echo $Jo8; ?></td>
</tr>
<tr>
<th>達成度(0-100)%</th>
<td><?php echo $Jo9; ?>%</td>
</tr>
<tr>
<th>次回の目標</th>
<td><?php echo $Jo10; ?></td>
</tr>
  </table>
<?php
}else if($ja_id == 2){
?>
<form action="journal1.php?user=<?php echo $username;?>&today=<?php echo $da;?>" method="post">
<table class="ta1">
<tr>
<th colspan="2" class="tamidashi">入力フォーム</th>
</tr>
<tr>
<th>学習中の感情</th>
<td>
<select name="emotion" align="left" required="">
<option value="0">やる気があった</option>
<option value="1">イライラしていた</option>
<option value="2">集中していた</option>
<option value="3">心配だ</option>
</select></td>
</tr>
<tr>
<th>良かった点・悪かった点</th>
<td><textarea name="goodbad" rows="4" cols="50" wrap="soft" required="" autocomplete='off'maxlength="200" style="width: 100%; height: 100%; "></textarea></td>
</tr>
<tr>
<th>達成度(0-100)%</th>
<td><input type="number" name="achievement" min="0" max="100" style="width: 90%; height: 100%; "/>%</td>
</tr>
</table> 
<div class=" container-fluid">
<div class="row">
<div class="right-block col-sm-6 text-right">
<input type="submit" name="journal1" class="btn-gradient-simple" value="登録"> 
</form>
</div>
<div class="center-block col-sm-6 text-left">
<form action="journal1.php?user=<?php echo $username;?>&year=<?php echo $year;?>&month=<?php echo $month;?>&id=1" method="post">
   <button type="submit" class="btn-gradient-simple">学習日誌へ戻る</button> 
</form>
</div>
</div>
<?php
}else if($ja_id == 3){
  ?>
<table class="ta1">
<tr>
<th colspan="2" class="tamidashi">記録</th>
</tr>
<tr>
<th width="30%">学習中の感情</th>
<td width="70%">
<?php 
if($Jo7 == 0){
  echo "やる気があった";
}else if($Jo7 == 1){
  echo "イライラしていた";
}else if($Jo7 == 2){
  echo "集中していた";
}else if($Jo7 == 3){
  echo "不安だ";
}
?>
</td>
</tr>
<tr>
<th>良かった点・悪かった点</th>
<td><?php echo $Jo8; ?></td>
</tr>
<tr>
<th>達成度(0-100)%</th>
<td><?php echo $Jo9; ?>%</td>
</tr>
<tr>
<th>次回の目標</th>
<td><?php echo $Jo10; ?></td>
</tr>
  </table>
<?php
}
?>
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
</body>
</html>
