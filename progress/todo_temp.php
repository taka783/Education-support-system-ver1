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

$sub = ['情報基礎数学A', '情報基礎数学B', '情報基礎数学C', '英語' , '情報' , '国語'];
$sub2 = ['mathA', 'mathB', 'mathC', 'eng', 'inf', 'jap'];

date_default_timezone_set('Asia/Tokyo');
$now = date('Y-m-d H:i:s');

//次の画面へid引き渡し
//<a href="main_m.php?user='.$get_id.'"></a>

require "../mysql.php";

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

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>学習支援システム</title>
<link rel="stylesheet" href="../css/style.css">
<!-- プログレスバー-->
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
<!--小さな端末用（800px以下端末）メニュー-->
<nav id="menubar-s">
<ul>
<li><a href="../main.php?user=<?php echo $username;?>">メイン</a></li>
<li><a href="../journal1.php?user=<?php echo $username;?>">学習日誌</a></li>
<li><a href="../style.php?user=<?php echo $username;?>">学習スタイル</a></li>
<li><a href="todo1.php?user=<?php echo $username;?>">ToDoリスト</a></li>
<?php
if($Ic < 1){
?>
<li><a href="../contract_edit0.php?user=<?php echo $username;?>">自己変革プラン</a></li>
<?php
}
?>
<li><a href="../help.php?user=<?php echo $username;?>">ヘルプ</a></li>
<li><a href="https://prep.ipusoft-el.jp/">入学前教育サイトへ</a></li>
</ul>
</nav>

  <!-- BootstrapのCSS読み込み -->
<link href="../css/bootstrap.min.css" rel="stylesheet">
<!-- jQuery読み込み -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.0.js"></script>
<!-- BootstrapのJS読み込み -->
<script src="../js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<!-- メニュー開閉用-->
<script type="text/javascript" src="js/openclose.js"></script>
<script type="text/javascript" src="js/fixmenu_pagetop.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet"/>
  <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  <script type="text/javascript">
  $(document).ready(function() {
    toastr.options.timeOut = 3000; // 3秒
toastr.options = {
  "closeButton": true,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-bottom-right",
  "preventDuplicates": false,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}
    $('#linkButton').click(function() {
       toastr.success('click');
    });
  });
  </script>

<?php
if($flag == 1){
?>
  <script type="text/javascript">
  Command: toastr["success"]("ToDoリストが登録されました！", "登録完了");
  </script>
<?php
}
?>
<?php
if($flag == 2){
?>
  <script type="text/javascript">
  Command: toastr["success"]("達成情報が登録されました！", "登録完了");
  </script>
<?php
}
?>
<?php
if($flag == 3){
?>
  <script type="text/javascript">
  Command: toastr["success"]("ToDoリストが更新されました！", "更新完了");
  </script>
<?php
}
?>

<div id="container">


<header>
<h1 id="logo"><a href="../main.php?user=<?php echo $username;?>"><img src="../images/logo.png" alt="学習支援システム"></a></h1>
<ul id="menubar" class="nav">
<li><a href="../main.php?user=<?php echo $username;?>">メイン</a></li>
<li><a href="../journal1.php?user=<?php echo $username;?>">学習日誌</a></li>
<li><a href="../style.php?user=<?php echo $username;?>">学習スタイル</a></li>
<li><a href="todo1.php?user=<?php echo $username;?>">ToDoリスト</a></li>
<?php
if($Ic < 1){
?>
<li><a href="../contract_edit0.php?user=<?php echo $username;?>">自己変革プラン</a></li>
<?php
}
?>
<li><a href="../help.php?user=<?php echo $username;?>">ヘルプ</a></li>
<li><a href="https://prep.ipusoft-el.jp/">入学前教育サイトへ</a></li>
</ul>
</header>

<div id="contents">

<section>

<h2>ToDoリスト</h2>

<div class="container-fluid">
<!--row開始-->
<div class="row">
<div class="col-sm-6">
<h3>ToDoの進捗</h3>
<div class="w3-light-grey w3-round-xlarge">
    <div class="w3-container w3-blue w3-round-xlarge" style="width:30%">30%</div>
</div>
</div>
<div class="col-sm-6">
<h3>学習時間の合計</h3>
<h5>20時間</h5>
</div>
</div>
</div>
<br>
<h3>ToDoリスト</h3>
<table  class="ta1" border="1" cellspacing="0" cellpadding="5" bordercolor="#333333" align="center" width="100%">
  <tr bgcolor="#87cefa" >
  <th width="10%"><font color="white">月</font></th>
  <th width="10%"><font color="white">教科</font></th>
  <th width="60%"><font color="white">ToDo</font></th>
  <th width="15%"><font color="white">達成日</font></th>
  <th width="15%"><font color="white">達成チェック</font></th>
  </tr>
  <tbody>
    <tr bgcolor="white">
      <td rowspan="5" valign='top' width='10%'>10</td>
      <td bgcolor="white">数学</td>
      <td bgcolor="white">事前テストに取り組む</td>
      <td bgcolor="white">2019-10-06</td>
      <td align="center" bgcolor="white">完了済み</td>
    </tr>
    <tr bgcolor="white">
      <td bgcolor="white">数学</td>
      <td bgcolor="white">事前テストでの間違いを復習する</td>
      <td bgcolor="white">2019-10-06</td>
      <td align="center" bgcolor="white">完了済み</td>
    </tr>
    <tr bgcolor="white">
      <td bgcolor="white">数学</td>
      <td bgcolor="white">三角関数をワークで復習する</td>
      <td bgcolor="white">2019-10-10</td>
      <td align="center" bgcolor="white">完了済み</td>
    </tr>
    <tr bgcolor="white">
      <td bgcolor="white">数学</td>
      <td bgcolor="white">加法定理の練習問題に取り組む</td>
      <td bgcolor="white">2019-10-15</td>
      <td align="center" bgcolor="white">完了済み</td>
    </tr>
    <tr bgcolor="white">
      <td bgcolor="white">数学</td>
      <td bgcolor="white">指数・対数の範囲を復習する</td>
      <td bgcolor="white">2019-10-27</td>
      <td align="center" bgcolor="white">完了済み</td>
    </tr>


    <tr bgcolor="white">
      <td rowspan="3" valign='top' width='10%'>11</td>
      <td bgcolor="white">英語</td>
      <td bgcolor="white">模試対策で苦手な範囲を復習する</td>
      <td bgcolor="white"></td>
      <td align="center" bgcolor="white"><button class="btn-flat-border">達成</button></td>
    </tr>
    <tr bgcolor="white">
      <td bgcolor="white">数学</td>
      <td bgcolor="white">極限の範囲を予習する</td>
      <td bgcolor="white"></td>
      <td align="center" bgcolor="white"><button class="btn-flat-border">達成</button></td>
    </tr>
    <tr bgcolor="white">
      <td bgcolor="white">数学</td>
      <td bgcolor="white">極限の練習問題に挑戦してみる</td>
      <td bgcolor="white"></td>
      <td align="center" bgcolor="white"><button class="btn-flat-border">達成</button></td>
    </tr>

    <tr bgcolor="white">
      <td rowspan="4" valign='top' width='10%'>12</td>
      <td bgcolor="white">英語</td>
      <td bgcolor="white">実力テストで間違った範囲を復習する</td>
      <td bgcolor="white"></td>
      <td align="center" bgcolor="white"><button class="btn-flat-border">達成</button></td>
    </tr>
    <tr bgcolor="white">
      <td bgcolor="white">数学</td>
      <td bgcolor="white">微分積分の範囲を復習する</td>
      <td bgcolor="white"></td>
      <td align="center" bgcolor="white"><button class="btn-flat-border">達成</button></td>
    </tr>
    <tr bgcolor="white">
      <td bgcolor="white">数学</td>
      <td bgcolor="white">確認テストに挑戦する</td>
      <td bgcolor="white"></td>
      <td align="center" bgcolor="white"><button class="btn-flat-border">達成</button></td>
    </tr>
    <tr bgcolor="white">
      <td bgcolor="white">数学</td>
      <td bgcolor="white">確認テストで解けなかった問題を復習する</td>
      <td bgcolor="white"></td>
      <td align="center" bgcolor="white"><button class="btn-flat-border">達成</button></td>
    </tr>

    <tr bgcolor="white">
      <td rowspan="1" valign='top' width='10%'>1</td>
      <td bgcolor="white">英語</td>
      <td bgcolor="white">苦手な範囲の復習をする</td>
      <td bgcolor="white"></td>
      <td align="center" bgcolor="white"><button class="btn-flat-border">達成</button></td>
    </tr>

    <tr bgcolor="white">
      <td rowspan="2" valign='top' width='10%'>2</td>
      <td bgcolor="white">数学</td>
      <td bgcolor="white">事後テストに挑戦する</td>
      <td bgcolor="white"></td>
      <td align="center" bgcolor="white"><button class="btn-flat-border">達成</button></td>
    </tr>
    <tr bgcolor="white">
      <td bgcolor="white">数学</td>
      <td bgcolor="white">事後テストの復習をする</td>
      <td bgcolor="white"></td>
      <td align="center" bgcolor="white"><button class="btn-flat-border">達成</button></td>
    </tr>
  </tbody>
</table>

<br>
<div class=" container-fluid">
<div class="row">
<div class="center-block col-sm-12 text-center">
<form action="todo1.php?user=<?php echo $username;?>&subject=<?php echo $s_id;?>" method="post">
   <button type="submit" class="btn-gradient-simple">進捗管理へ戻る</button> 
</form>
</div>
</div>
</div>
<br><br>
</section>


</div>
<!--/contents-->

<footer>
<small>Copyright&copy; <a href="../main.php?user=<?php echo $username;?>">学習支援システム</a> All Rights Reserved.</small>
<span class="pr">《<a href="http://template-party.com/" target="_blank">Web Design:Template-Party</a>》</span>
</footer>

</div>
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

