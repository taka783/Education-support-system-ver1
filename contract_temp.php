<?php

//urlのid受け取り処理
if(isset($_GET['user'])){
$get_id = $_GET['user'];  
$username = $get_id;
}

if(isset($_GET['design'])){ 
$design = $_GET['design'];
}



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

if($design == "temp1"){
  $jpg = "templete1.jpg";
}else if($design == "temp2"){
  $jpg = "templete2.jpg";
}else if($design == "temp3"){
  $jpg = "templete3.jpg";
}




$goal = $_POST["goal"];
$reason = $_POST["reason"];
$strategy = $_POST["strategy"];
$judgment = $_POST["judgment"];
$reward = $_POST["reward"];
$date = $_POST["date"];

$goal = mb_convert_kana($goal, 'KVRN');
$reason = mb_convert_kana($reason, 'KVRN');
$strategy = mb_convert_kana($strategy, 'KVRN');
$judgment = mb_convert_kana($judgment, 'KVRN');
$reward = mb_convert_kana($reward, 'KVRN');


$font = "meiryo.ttc";
$image = imagecreatefromjpeg($jpg);
$color = imagecolorallocate($image, 0, 0, 0);

$g_size = 20;
$re_size = 20;
$s_size = 20;
$j_size = 20;
$r_size = 20;

//
if(mb_strlen($goal) < 85) { 
  if(isset($goal)){
    $goal = htmlspecialchars($goal, ENT_QUOTES);
  }
  $goal = wordwrap($goal, 105, "\n", true);
  $goal = mb_convert_encoding($goal, "UTF-8", "auto");
} else if(mb_strlen($goal) >= 85 && mb_strlen($goal) < 130) { 
  $g_size = 16;
  if(isset($goal)){
    $goal = htmlspecialchars($goal, ENT_QUOTES);
  }
  $goal = wordwrap($goal, 135, "\n", true);
  $goal = mb_convert_encoding($goal, "UTF-8", "auto");
} else if(mb_strlen($goal) >= 130) { 
  $g_size = 12;
  if(isset($goal)){
    $goal = htmlspecialchars($goal, ENT_QUOTES);
  }
  $goal = wordwrap($goal, 165, "\n", true);
  $goal = mb_convert_encoding($goal, "UTF-8", "auto");
}

//
if(mb_strlen($reason) < 85) { 
  if(isset($reason)){
    $reason = htmlspecialchars($reason, ENT_QUOTES);
  }
  $reason = wordwrap($reason, 105, "\n", true);
  $reason = mb_convert_encoding($reason, "UTF-8", "auto");
} else if(mb_strlen($reason) >= 85 && mb_strlen($reason) < 130) { 
  $re_size = 16;
  if(isset($reason)){
    $reason = htmlspecialchars($reason, ENT_QUOTES);
  }
  $reason = wordwrap($reason, 135, "\n", true);
  $reason = mb_convert_encoding($reason, "UTF-8", "auto");
} else if(mb_strlen($reason) >= 130) { 
  $re_size = 12;
  if(isset($reason)){
    $reason = htmlspecialchars($reason, ENT_QUOTES);
  }
  $reason = wordwrap($reason, 165, "\n", true);
  $reason = mb_convert_encoding($reason, "UTF-8", "auto");
}

//
if(mb_strlen($strategy) < 85) { 
  if(isset($strategy)){
    $strategy = htmlspecialchars($strategy, ENT_QUOTES);
  }
  $strategy = wordwrap($strategy, 105, "\n", true);
  $strategy = mb_convert_encoding($strategy, "UTF-8", "auto");
} else if(mb_strlen($strategy) >= 85 && mb_strlen($strategy) < 130) { 
  $s_size = 16;
  if(isset($strategy)){
    $strategy = htmlspecialchars($strategy, ENT_QUOTES);
  }
  $strategy = wordwrap($strategy, 135, "\n", true);
  $strategy = mb_convert_encoding($strategy, "UTF-8", "auto");
} else if(mb_strlen($strategy) >= 130) { 
  $s_size = 12;
  if(isset($strategy)){
    $strategy = htmlspecialchars($strategy, ENT_QUOTES);
  }
  $strategy = wordwrap($strategy, 165, "\n", true);
  $strategy = mb_convert_encoding($strategy, "UTF-8", "auto");
}

//
if(mb_strlen($judgment) < 85) { 
  if(isset($judgment)){
    $judgment = htmlspecialchars($judgment, ENT_QUOTES);
  }
  $judgment = wordwrap($judgment, 105, "\n", true);
  $judgment = mb_convert_encoding($judgment, "UTF-8", "auto");
} else if(mb_strlen($judgment) >= 85 && mb_strlen($judgment) < 130) { 
  $j_size = 16;
    if(isset($judgment)){
    $judgment = htmlspecialchars($judgment, ENT_QUOTES);
  }
  $judgment = wordwrap($judgment, 135, "\n", true);
  $judgment = mb_convert_encoding($judgment, "UTF-8", "auto");
} else if(mb_strlen($judgment) >= 130) { 
  $j_size =12;
    if(isset($judgment)){
    $judgment = htmlspecialchars($judgment, ENT_QUOTES);
  }
  $judgment = wordwrap($judgment, 165, "\n", true);
  $judgment = mb_convert_encoding($judgment, "UTF-8", "auto");
}

//
if(mb_strlen($reward) < 85) { 
  if(isset($reward)){
    $reward = htmlspecialchars($reward, ENT_QUOTES);
  }
  $reward = wordwrap($reward, 105, "\n", true);
  $reward = mb_convert_encoding($reward, "UTF-8", "auto");
} else if(mb_strlen($reward) >= 85 && mb_strlen($reward) < 130) { 
  $r_size = 16;
  if(isset($reward)){
    $reward = htmlspecialchars($reward, ENT_QUOTES);
  }
  $reward = wordwrap($reward, 135, "\n", true);
  $reward = mb_convert_encoding($reward, "UTF-8", "auto");
} else if(mb_strlen($reward) >= 130) { 
  $r_size = 12;
  if(isset($reward)){
    $reward = htmlspecialchars($reward, ENT_QUOTES);
  }
  $reward = wordwrap($reward, 165, "\n", true);
  $reward = mb_convert_encoding($reward, "UTF-8", "auto");
}

$user = $username;
$mentar = "小野峻明";

imagettftext($image, $g_size, 0, 140, 357, $color, $font, $goal);
imagettftext($image, $re_size, 0, 140, 560, $color, $font, $reason);
imagettftext($image, $s_size, 0, 140, 810, $color, $font, $strategy);
imagettftext($image, $j_size, 0, 140, 1065, $color, $font, $judgment);
imagettftext($image, $r_size, 0, 140, 1220, $color, $font, $reward);
imagettftext($image, 20, 0, 310, 1446, $color, $font, $user);
imagettftext($image, 20, 0, 310, 1498, $color, $font, $mentar);
imagettftext($image, 20, 0, 310, 1550, $color, $font, $date);

imagejpeg($image, "image/".$username.".jpg", 100);


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

<section>
<h2>自己変革プラン作成例</h2>
    <div class="text-center">
      <img src="image/admin.jpg?<?php echo date("YmdHis");?>" width="400" height="auto"><br>
    </div>


<div class=" container-fluid">
<div class="row">
<div class="right-block col-sm-12 text-center">
<?php
echo '<a href="' . $_SERVER['HTTP_REFERER'] . '" class="btn-gradient-simple">前に戻る</a>';
?>
</div>
</div>
</div>

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
