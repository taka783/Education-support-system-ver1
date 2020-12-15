
<?php

//urlのid受け取り処理
if(isset($_GET['user'])){
$get_id = $_GET['user'];  
$username = $get_id;
}

//カレンダー切り替え用 id取得
$id = 0;
if(isset($_GET['id'])){
$id = $_GET['id'];  
}

$ja_id = 0;

if(isset($_GET['ja'])){
$ja_id = $_GET['ja'];  
}

if(isset($_GET['year'])){
$year = $_GET['year'];  
}

if(isset($_GET['month'])){
$month = $_GET['month'];  
}

if(isset($_GET['j_day'])){
$j_day = $_GET['j_day'];  
}

$flag = 0;

//次の画面へid引き渡し
//<a href="main_m.php?user='.$get_id.'"></a>

require "mysql.php";

$g_flag = $ImA + $ImB + $ImC + $Ie + $Ii + $Ij;

//日誌登録
if(isset($_GET['today'])){
$today = $_GET['today'];  
}
$total = $_POST["math"] + $_POST["eng"] + $_POST["inf"] + $_POST["jap"];

if($_POST['journal1']){
  $flag = 1;
  $result = mysqli_query($con, "INSERT INTO journal2 SET user_id = '".$username."', j_day = '".$today."' , total = '".$total."' , math = '".$_POST["math"]."' , eng = '".$_POST["eng"]."' , inf = '".$_POST["inf"]."' , jap = '".$_POST["jap"]."' , emotion = '".$_POST["emotion"]."' , goodbad = '".$_POST["goodbad"]."', achievement = '".$_POST["achievement"]."', nextgoal = '".$_POST["nextgoal"]."'");
  if(!$result){
    echo "mysql文のエラー";
  }
  $result = mysqli_query($con, "INSERT INTO journal SET user_id = '".$username."', j_day = '".$today."'");
  if(!$result){
    echo "mysql文のエラー";
  }
}

if($_POST['journal2']){
  $flag = 1;
  $result = mysqli_query($con, "INSERT INTO journal2 SET user_id = '".$username."', j_day = '".$today."' , emotion = '".$_POST["emotion"]."' , goodbad = '".$_POST["goodbad"]."', achievement = '".$_POST["achievement"]."'");
  if(!$result){
    echo "mysql文のエラー";
  }
  $result = mysqli_query($con, "INSERT INTO journal SET user_id = '".$username."', j_day = '".$today."'");
  if(!$result){
    echo "mysql文のエラー";
  }
}

if($_POST['journal3']){
  $flag = 1;
  $result = mysqli_query($con, "INSERT INTO journal2 SET user_id = '".$username."', j_day = '".$today."' , total = '".$total."' , math = '".$_POST["math"]."' , eng = '".$_POST["eng"]."' , inf = '".$_POST["inf"]."' , jap = '".$_POST["jap"]."' , emotion = '".$_POST["emotion"]."' , goodbad = '".$_POST["goodbad"]."', achievement = '".$_POST["achievement"]."', nextgoal = '".$_POST["nextgoal"]."'");
  $result2 = mysqli_query($con, "INSERT INTO journal3 SET user_id = '".$username."', j_day = '".$today."' , contract = '".$_POST["contract"]."'");
  if(!$result){
    echo "mysql文のエラー";
  }
  $result = mysqli_query($con, "INSERT INTO journal SET user_id = '".$username."', j_day = '".$today."'");
  if(!$result){
    echo "mysql文のエラー";
  }
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
  Command: toastr["success"]("日誌が登録されました！", "登録完了");
  </script>
<?php
}
?>

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
<?php
    $stmt = mysqli_query($con, "SELECT COUNT(*) FROM journal WHERE user_id ='" . $username . "' AND j_day = '2020-1-24'");
    $stmtI = mysqli_fetch_assoc($stmt);
    $d1_24 = $stmtI['COUNT(*)'];
    $stmt = mysqli_query($con, "SELECT COUNT(*) FROM journal WHERE user_id ='" . $username . "' AND j_day = '2020-1-31'");
    $stmtI = mysqli_fetch_assoc($stmt);
    $d1_31 = $stmtI['COUNT(*)'];
    $stmt = mysqli_query($con, "SELECT COUNT(*) FROM journal WHERE user_id ='" . $username . "' AND j_day = '2020-2-7'");
    $stmtI = mysqli_fetch_assoc($stmt);
    $d2_7 = $stmtI['COUNT(*)'];
    $stmt = mysqli_query($con, "SELECT COUNT(*) FROM journal WHERE user_id ='" . $username . "' AND j_day = '2020-2-14'");
    $stmtI = mysqli_fetch_assoc($stmt);
    $d2_14 = $stmtI['COUNT(*)'];
    $stmt = mysqli_query($con, "SELECT COUNT(*) FROM journal WHERE user_id ='" . $username . "' AND j_day = '2020-2-21'");
    $stmtI = mysqli_fetch_assoc($stmt);
    $d2_21 = $stmtI['COUNT(*)'];
    $stmt = mysqli_query($con, "SELECT COUNT(*) FROM journal WHERE user_id ='" . $username . "' AND j_day = '2020-2-28'");
    $stmtI = mysqli_fetch_assoc($stmt);
    $d2_28 = $stmtI['COUNT(*)'];
    $stmt = mysqli_query($con, "SELECT COUNT(*) FROM journal WHERE user_id ='" . $username . "' AND j_day = '2020-3-6'");
    $stmtI = mysqli_fetch_assoc($stmt);
    $d3_6 = $stmtI['COUNT(*)'];
    $stmt = mysqli_query($con, "SELECT COUNT(*) FROM journal WHERE user_id ='" . $username . "' AND j_day = '2020-3-13'");
    $stmtI = mysqli_fetch_assoc($stmt);
    $d3_13 = $stmtI['COUNT(*)'];
    $stmt = mysqli_query($con, "SELECT COUNT(*) FROM journal WHERE user_id ='" . $username . "' AND j_day = '2020-3-20'");
    $stmtI = mysqli_fetch_assoc($stmt);
    $d3_20 = $stmtI['COUNT(*)'];
    $stmt = mysqli_query($con, "SELECT COUNT(*) FROM journal WHERE user_id ='" . $username . "' AND j_day = '2020-3-27'");
    $stmtI = mysqli_fetch_assoc($stmt);
    $d3_27 = $stmtI['COUNT(*)'];
?>

<table class="ta1 c">
  <tr>
    <?php
    if($d1_24 == 0){
    ?>
    <td width="20%"><a href="journal2.php?user=<?php echo $username;?>&ja=0&year=2020&month=1&date=24" method="post">第1回<br>1/24</a></td>
    <?php
    }else if($d1_24 > 0){
    ?>
    <td width="20%" bgcolor="skyblue">完了<br><a href="journal2.php?user=<?php echo $username;?>&ja=1&year=2020&month=11&date=15">日誌を確認する</a></td>
    <?php
    }
    ?>
    <?php
    if($d1_31 == 0){
    ?>
    <td width="20%"><a href="journal2.php?user=<?php echo $username;?>&ja=0&year=2020&month=1&date=31" method="post">第2回<br>1/31</td>
    <?php
    }else if($d1_31 > 0){
    ?>
    <td width="20%" bgcolor="skyblue">完了<br><a href="journal2.php?user=<?php echo $username;?>&ja=1&year=2020&month=1&date=31">日誌を確認する</a></td>
    <?php
    }
    ?>
    <?php
    if($d2_7 == 0){
    ?>
    <td width="20%"><a href="journal2.php?user=<?php echo $username;?>&ja=0&year=2020&month=2&date=7" method="post">第3回<br>2/7</td>
    <?php
    }else if($d2_7 > 0){
    ?>
    <td width="20%" bgcolor="skyblue">完了<br><a href="journal2.php?user=<?php echo $username;?>&ja=1&year=2020&month=2&date=7">日誌を確認する</a></td>
    <?php
    }
    ?>
    <?php
    if($d2_14 == 0){
    ?>
    <td width="20%"><a href="journal2.php?user=<?php echo $username;?>&ja=0&year=2020&month=2&date=14" method="post">第4回<br>2/14</td>
    <?php
    }else if($d2_14 > 0){
    ?>
    <td width="20%" bgcolor="skyblue">完了<br><a href="journal2.php?user=<?php echo $username;?>&ja=1&year=2020&month=2&date=14">日誌を確認する</a></td>
    <?php
    }
    ?>
    <?php
    if($d2_21 == 0){
    ?>
    <td width="20%"><a href="journal2.php?user=<?php echo $username;?>&ja=0&year=2020&month=2&date=21" method="post">第5回<br>2/21</td>
    <?php
    }else if($d2_21 > 0){
    ?>
    <td width="20%" bgcolor="skyblue">完了<br><a href="journal2.php?user=<?php echo $username;?>&ja=1&year=2020&month=2&date=21">日誌を確認する</a></td>
    <?php
    }
    ?>
  </tr>
   <tr>
    <?php
    if($d2_28 == 0){
    ?>
    <td width="20%"><a href="journal2.php?user=<?php echo $username;?>&ja=0&year=2020&month=2&date=28" method="post">第6回<br>2/28</a></td>
    <?php
    }else if($d2_28 > 0){
    ?>
    <td width="20%" bgcolor="skyblue">完了<br><a href="journal2.php?user=<?php echo $username;?>&ja=1&year=2020&month=2&date=28">日誌を確認する</a></td>
    <?php
    }
    ?>
    <?php
    if($d3_6 == 0){
    ?>
    <td width="20%"><a href="journal2.php?user=<?php echo $username;?>&ja=0&year=2020&month=3&date=6" method="post">第7回<br>3/6</td>
    <?php
    }else if($d3_6 > 0){
    ?>
    <td width="20%" bgcolor="skyblue">完了<br><a href="journal2.php?user=<?php echo $username;?>&ja=1&year=2020&month=3&date=6">日誌を確認する</a></td>
    <?php
    }
    ?>
    <?php
    if($d3_13 == 0){
    ?>
    <td width="20%"><a href="journal2.php?user=<?php echo $username;?>&ja=0&year=2020&month=3&date=13" method="post">第8回<br>3/13</td>
    <?php
    }else if($d3_13 > 0){
    ?>
    <td width="20%" bgcolor="skyblue">完了<br><a href="journal2.php?user=<?php echo $username;?>&ja=1&year=2020&month=3&date=13">日誌を確認する</a></td>
    <?php
    }
    ?>
    <?php
    if($d3_20 == 0){
    ?>
    <td width="20%"><a href="journal2.php?user=<?php echo $username;?>&ja=0&year=2020&month=3&date=20" method="post">第9回<br>3/20</td>
    <?php
    }else if($d3_20 > 0){
    ?>
    <td width="20%" bgcolor="skyblue">完了<br><a href="journal2.php?user=<?php echo $username;?>&ja=1&year=2020&month=3&date=20">日誌を確認する</a></td>
    <?php
    }
    ?>
    <?php
    if($d3_27 == 0){
    ?>
    <td width="20%"><a href="journal2.php?user=<?php echo $username;?>&ja=0&year=2020&month=3&date=27" method="post">第10回<br>3/27</td>
    <?php
    }else if($d3_27 > 0){
    ?>
    <td width="20%" bgcolor="skyblue">完了<br><a href="journal2.php?user=<?php echo $username;?>&ja=1&year=2020&month=3&date=27">日誌を確認する</a></td>
    <?php
    }
    ?>
  </tr>
</table>


<br><br>
</section>

<section id="about">

<section>

<h2>学習日誌の書き方</h2>

<p><strong class="color1">■学習日誌を記入する日の日付をクリックしましょう</strong><br>
・カレンダーの日付をクリックすると学習日誌の記述欄が表示されるのでそこに記入をしましょう。<br>
・毎日、学習日誌に取り組む必要はありませんが、余力のある人は積極的に記録してみると良いでしょう。<br>
・<span class="look">金曜日の学習日誌</span>は必須なので忘れずに取り組むようにしてください。<br>
</p>

<p><strong class="color1">■学習日誌を記録すると...</strong><br>
・学習日誌が記録されると、その記録がグラフとなって表示されます。<br>
・学習日誌を書くことで自分の学習状態を振り返ることができるので、率先して取り組んでみましょう。<br>

</p>

</section>

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
