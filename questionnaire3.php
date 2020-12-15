<?php

//urlのid受け取り処理
if(isset($_GET['user'])){
$get_id = $_GET['user'];  
$username = $get_id;
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

$con1 = mysqli_query($con, "SELECT COUNT(*) FROM contract WHERE user_id='". $username . "' AND flag=1");
$Icon = mysqli_fetch_assoc($con);
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

<?php
$fullness = $_POST["F1"] + $_POST["F2"] + $_POST["F3"] + $_POST["F4"] + $_POST["F5"] + $_POST["F6"];
$training = $_POST["T1"] + $_POST["T2"] + $_POST["T3"] + $_POST["T4"] + $_POST["T5"] + $_POST["T6"];
$practical = $_POST["P1"] + $_POST["P2"] + $_POST["P3"] + $_POST["P4"] + $_POST["P5"] + $_POST["P6"];
$relationship = $_POST["Ra1"] + $_POST["Ra2"] + $_POST["Ra3"] + $_POST["Ra4"] + $_POST["Ra5"] + $_POST["Ra6"];
$self_esteem = $_POST["S1"] + $_POST["S2"] + $_POST["S3"] + $_POST["S4"] + $_POST["S5"] + $_POST["S6"];
$reward = $_POST["Rb1"] + $_POST["Rb2"] + $_POST["Rb3"] + $_POST["Rb4"] + $_POST["Rb5"] + $_POST["Rb6"];

$F = round($fullness, 0);
$T = round($training, 0);
$P = round($practical, 0);
$Ra = round($relationship, 0);
$S = round($self_esteem, 0);
$Rb = round($reward, 0);
if(isset($_POST["next2"])){
$result = mysqli_query($con, "INSERT INTO Motive SET user_id = '".$username."', fullness = '".$F."', training = '".$T."',practical = '".$P."' , relationship ='".$Ra."', self_esteem ='".$S."', reward ='".$Rb."'");
}
?>


<div id="contents">

<section>

<h2>学習スタイル診断(3/3)</h2>

<p><strong class="color1">次の質問の内、もっとも自分の行いに近い回答を選びなさい。</strong></p>
<form action="questionnaire4.php?user=<?php echo $username;?>" method="post">

<p><span class="look">Q1:頭に物事をはっきり描くことができる。</span><br>
<input type="radio" name="V1" value="33.33" required> そう思う
<input type="radio" name="V1" value="22.22"> どちらかといえばそう思う
<input type="radio" name="V1" value="11.11"> どちらかといえばそう思わない
<input type="radio" name="V1" value="0"> そう思わない
</p>

<p><span class="look">Q2:本を読む時、頭の中で音韻化するか、あるいは声に出して読む。</span><br>
<input type="radio" name="A1" value="33.33" required> そう思う
<input type="radio" name="A1" value="22.22"> どちらかといえばそう思う
<input type="radio" name="A1" value="11.11"> どちらかといえばそう思わない
<input type="radio" name="A1" value="0"> そう思わない
</p>

<p><span class="look">Q3:音楽がかかっている方が集中できる。</span><br>
<input type="radio" name="K1" value="33.33" required> そう思う
<input type="radio" name="K1" value="22.22"> どちらかといえばそう思う
<input type="radio" name="K1" value="11.11"> どちらかといえばそう思わない
<input type="radio" name="K1" value="0"> そう思わない
</p>

<p><span class="look">Q4:ノートへの落書きで勉強に集中できる。</span><br>
<input type="radio" name="T1" value="33.33" required> そう思う
<input type="radio" name="T1" value="22.22"> どちらかといえばそう思う
<input type="radio" name="T1" value="11.11"> どちらかといえばそう思わない
<input type="radio" name="T1" value="0"> そう思わない
</p>

<p><span class="look">Q5:私のノートには、たくさんの絵やグラフが描かれている。</span><br>
<input type="radio" name="V2" value="33.33" required> そう思う
<input type="radio" name="V2" value="22.22"> どちらかといえばそう思う
<input type="radio" name="V2" value="11.11"> どちらかといえばそう思わない
<input type="radio" name="V2" value="0"> そう思わない
</p>

<p><span class="look">Q6:問題解決や何かを書いている時、頭の中で自分自身に話しかけている。</span><br>
<input type="radio" name="A2" value="33.33" required> そう思う
<input type="radio" name="A2" value="22.22"> どちらかといえばそう思う
<input type="radio" name="A2" value="11.11"> どちらかといえばそう思わない
<input type="radio" name="A2" value="0"> そう思わない
</p>

<p><span class="look">Q7:机や自分の部屋が散らかっている。</span><br>
<input type="radio" name="K2" value="33.33" required> そう思う
<input type="radio" name="K2" value="22.22"> どちらかといえばそう思う
<input type="radio" name="K2" value="11.11"> どちらかといえばそう思わない
<input type="radio" name="K2" value="0"> そう思わない
</p>

<p><span class="look">Q8:考えている時は、ペンや他のものをいじる。</span><br>
<input type="radio" name="T2" value="33.33" required> そう思う
<input type="radio" name="T2" value="22.22"> どちらかといえばそう思う
<input type="radio" name="T2" value="11.11"> どちらかといえばそう思わない
<input type="radio" name="T2" value="0"> そう思わない
</p>

<p><span class="look">Q9:テスト中、頭の中に教科書の正答のあるページを思い出すことができる。</span><br>
<input type="radio" name="V3" value="33.33" required> そう思う
<input type="radio" name="V3" value="22.22"> どちらかといえばそう思う
<input type="radio" name="V3" value="11.11"> どちらかといえばそう思わない
<input type="radio" name="V3" value="0"> そう思わない
</p>

<p><span class="look">Q10:英語の単語や文法を覚えるときには音読をする。</span><br>
<input type="radio" name="A3" value="33.33" required> そう思う
<input type="radio" name="A3" value="22.22"> どちらかといえばそう思う
<input type="radio" name="A3" value="11.11"> どちらかといえばそう思わない
<input type="radio" name="A3" value="0"> そう思わない
</p>

<p><span class="look">Q11:勉強している時も動き回るのが好きで、その方が考えられる。</span><br>
<input type="radio" name="K3" value="33.33" required> そう思う
<input type="radio" name="K3" value="22.22"> どちらかといえばそう思う
<input type="radio" name="K3" value="11.11"> どちらかといえばそう思わない
<input type="radio" name="K3" value="0"> そう思わない
</p>

<p><span class="look">Q12:服を選ぶ時、生地の着心地が最も重要だ。</span><br>
<input type="radio" name="T3" value="33.33" required> そう思う
<input type="radio" name="T3" value="22.22"> どちらかといえばそう思う
<input type="radio" name="T3" value="11.11"> どちらかといえばそう思わない
<input type="radio" name="T3" value="0"> そう思わない
</p>


<p class="c"><input type="submit" class="btn-gradient-simple" value="次のページへ"></p>
</form>
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
