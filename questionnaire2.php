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

$s2 = mysqli_query($con, "SELECT COUNT(*) FROM View WHERE user_id='". $username . "'");
$ss2 = mysqli_fetch_assoc($s2);
$is2 = $ss2['COUNT(*)'];
if($is2 > 0){
  header("Location: questionnaire3.php?user=". $username."");
}


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
$failure = $_POST["F1"] + $_POST["F2"] + $_POST["F3"] + $_POST["F4"] + $_POST["F5"] + $_POST["F6"];
$thinking = $_POST["T1"] + $_POST["T2"] + $_POST["T3"] + $_POST["T4"] + $_POST["T5"] + $_POST["T6"];
$strategy = $_POST["S1"] + $_POST["S2"] + $_POST["S3"] + $_POST["S4"] + $_POST["S5"] + $_POST["S6"];
$meaning = $_POST["M1"] + $_POST["M2"] + $_POST["M3"] + $_POST["M4"] + $_POST["M5"] + $_POST["M6"];

$F = round($failure, 0);
$T = round($thinking, 0);
$S = round($strategy, 0);
$M = round($meaning, 0);
if(isset($_POST["next"])){
$result = mysqli_query($con, "INSERT INTO View SET user_id = '".$username."', failure = '".$F."', thinking = '".$T."',strategy = '".$S."' , meaning ='".$M."'");
}
?>

<div id="contents">

<section>

<h2>学習スタイル診断(2/3)</h2>

<p><strong class="color1">あなたが何のために勉強をしているのかを、次の質問の回答で最も当てはまるものを選びなさい。</strong></p>
<form action="questionnaire3.php?user=<?php echo $username;?>" method="post">

<p><span class="look">Q1:新しいことを知りたいという気持ちから。</span><br>
<input type="radio" name="F1" value="16.67" required> そう思う
<input type="radio" name="F1" value="11.11"> どちらかといえばそう思う
<input type="radio" name="F1" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="F1" value="0"> そう思わない
</p>

<p><span class="look">Q2:勉強しないと充実感がないから。</span><br>
<input type="radio" name="F2" value="16.67" required> そう思う
<input type="radio" name="F2" value="11.11"> どちらかといえばそう思う
<input type="radio" name="F2" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="F2" value="0"> そう思わない
</p>

<p><span class="look">Q3:学習の仕方を身につけるため。</span><br>
<input type="radio" name="T1" value="16.67" required> そう思う
<input type="radio" name="T1" value="11.11"> どちらかといえばそう思う
<input type="radio" name="T1" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="T1" value="0"> そう思わない
</p>

<p><span class="look">Q4:勉強しないと、頭の働きが衰えてしまうから。</span><br>
<input type="radio" name="T2" value="16.67" required> そう思う
<input type="radio" name="T2" value="11.11"> どちらかといえばそう思う
<input type="radio" name="T2" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="T2" value="0"> そう思わない
</p>

<p><span class="look">Q5:勉強したことは、生活の場面で役に立つから。</span><br>
<input type="radio" name="P1" value="16.67" required> そう思う
<input type="radio" name="P1" value="11.11"> どちらかといえばそう思う
<input type="radio" name="P1" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="P1" value="0"> そう思わない
</p>

<p><span class="look">Q6:勉強しないと、将来仕事の上で困るから。</span><br>
<input type="radio" name="P2" value="16.67" required> そう思う
<input type="radio" name="P2" value="11.11"> どちらかといえばそう思う
<input type="radio" name="P2" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="P2" value="0"> そう思わない
</p>

<p><span class="look">Q7:みんながやるから、何となく当たり前と思って。</span><br>
<input type="radio" name="Ra1" value="16.67" required> そう思う
<input type="radio" name="Ra1" value="11.11"> どちらかといえばそう思う
<input type="radio" name="Ra1" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="Ra1" value="0"> そう思わない
</p>

<p><span class="look">Q8:親や好きな先生に認めてもらいたいから。</span><br>
<input type="radio" name="Ra2" value="16.67" required> そう思う
<input type="radio" name="Ra2" value="11.11"> どちらかといえばそう思う
<input type="radio" name="Ra2" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="Ra2" value="0"> そう思わない
</p>

<p><span class="look">Q9:成績がいいと、他の人より優れているような気持ちになれるから。</span><br>
<input type="radio" name="S1" value="16.67" required> そう思う
<input type="radio" name="S1" value="11.11"> どちらかといえばそう思う
<input type="radio" name="S1" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="S1" value="0"> そう思わない
</p>

<p><span class="look">Q10:ライバルに負けたくないから。</span><br>
<input type="radio" name="S2" value="16.67" required> そう思う
<input type="radio" name="S2" value="11.11"> どちらかといえばそう思う
<input type="radio" name="S2" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="S2" value="0"> そう思わない
</p>

<p><span class="look">Q11:テストで成績がいいと、親や先生に褒めてもらえるから。</span><br>
<input type="radio" name="Rb1" value="16.67" required> そう思う
<input type="radio" name="Rb1" value="11.11"> どちらかといえばそう思う
<input type="radio" name="Rb1" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="Rb1" value="0"> そう思わない
</p>

<p><span class="look">Q12:勉強しないと親や先生に叱られるから。</span><br>
<input type="radio" name="Rb2" value="16.67" required> そう思う
<input type="radio" name="Rb2" value="11.11"> どちらかといえばそう思う
<input type="radio" name="Rb2" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="Rb2" value="0"> そう思わない
</p>

<p><span class="look">Q13:いろいろな知識を身につけた人になりたいから。</span><br>
<input type="radio" name="F3" value="16.67" required> そう思う
<input type="radio" name="F3" value="11.11"> どちらかといえばそう思う
<input type="radio" name="F3" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="F3" value="0"> そう思わない
</p>

<p><span class="look">Q14:わからないこと、そのままにしておきたくないから。</span><br>
<input type="radio" name="F4" value="16.67" required> そう思う
<input type="radio" name="F4" value="11.11"> どちらかといえばそう思う
<input type="radio" name="F4" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="F4" value="0"> そう思わない
</p>

<p><span class="look">Q15:勉強することは、頭の訓練になると思うから。</span><br>
<input type="radio" name="T3" value="16.67" required> そう思う
<input type="radio" name="T3" value="11.11"> どちらかといえばそう思う
<input type="radio" name="T3" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="T3" value="0"> そう思わない
</p>

<p><span class="look">Q16:合理的な考え方ができるようになるため。</span><br>
<input type="radio" name="T4" value="16.67" required> そう思う
<input type="radio" name="T4" value="11.11"> どちらかといえばそう思う
<input type="radio" name="T4" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="T4" value="0"> そう思わない
</p>

<p><span class="look">Q17:学んだことを、将来の仕事に生かしたいから。</span><br>
<input type="radio" name="P3" value="16.67" required> そう思う
<input type="radio" name="P3" value="11.11"> どちらかといえばそう思う
<input type="radio" name="P3" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="P3" value="0"> そう思わない
</p>

<p><span class="look">Q18:仕事で必要になってから、慌てて勉強したのでは間に合わないから。</span><br>
<input type="radio" name="P4" value="16.67" required> そう思う
<input type="radio" name="P4" value="11.11"> どちらかといえばそう思う
<input type="radio" name="P4" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="P4" value="0"> そう思わない
</p>

<p><span class="look">Q19:友達と一緒に何かしていたいから。</span><br>
<input type="radio" name="Ra3" value="16.67" required> そう思う
<input type="radio" name="Ra3" value="11.11"> どちらかといえばそう思う
<input type="radio" name="Ra3" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="Ra3" value="0"> そう思わない
</p>

<p><span class="look">Q20:みんながすることをやらないと、おかしいような気がするから。</span><br>
<input type="radio" name="Ra4" value="16.67" required> そう思う
<input type="radio" name="Ra4" value="11.11"> どちらかといえばそう思う
<input type="radio" name="Ra4" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="Ra4" value="0"> そう思わない
</p>

<p><span class="look">Q21:勉強が人並みにできないのはくやしいから。</span><br>
<input type="radio" name="S3" value="16.67" required> そう思う
<input type="radio" name="S3" value="11.11"> どちらかといえばそう思う
<input type="radio" name="S3" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="S3" value="0"> そう思わない
</p>

<p><span class="look">Q22:勉強が人並みにできないと、自信がなくなってしまいそうだから。</span><br>
<input type="radio" name="S4" value="16.67" required> そう思う
<input type="radio" name="S4" value="11.11"> どちらかといえばそう思う
<input type="radio" name="S4" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="S4" value="0"> そう思わない
</p>

<p><span class="look">Q23:成績が良ければ、小遣いやご褒美がもらえるから。</span><br>
<input type="radio" name="Rb3" value="16.67" required> そう思う
<input type="radio" name="Rb3" value="11.11"> どちらかといえばそう思う
<input type="radio" name="Rb3" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="Rb3" value="0"> そう思わない
</p>

<p><span class="look">Q24:学歴がいい方が、社会に出てからも得なことが多いから。</span><br>
<input type="radio" name="Rb4" value="16.67" required> そう思う
<input type="radio" name="Rb4" value="11.11"> どちらかといえばそう思う
<input type="radio" name="Rb4" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="Rb4" value="0"> そう思わない
</p>

<p><span class="look">Q25:すぐに役に立たないにしても、勉強がわかること自体面白いから。</span><br>
<input type="radio" name="F5" value="16.67" required> そう思う
<input type="radio" name="F5" value="11.11"> どちらかといえばそう思う
<input type="radio" name="F5" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="F5" value="0"> そう思わない
</p>

<p><span class="look">Q26:何かができるようになっていくことは楽しいから。</span><br>
<input type="radio" name="F6" value="16.67" required> そう思う
<input type="radio" name="F6" value="11.11"> どちらかといえばそう思う
<input type="radio" name="F6" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="F6" value="0"> そう思わない
</p>

<p><span class="look">Q27:勉強しないと、筋道だった考え方ができなくなるから。</span><br>
<input type="radio" name="T5" value="16.67" required> そう思う
<input type="radio" name="T5" value="11.11"> どちらかといえばそう思う
<input type="radio" name="T5" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="T5" value="0"> そう思わない
</p>

<p><span class="look">Q28:色々な面から物事を考えられるようになるため。</span><br>
<input type="radio" name="T6" value="16.67" required> そう思う
<input type="radio" name="T6" value="11.11"> どちらかといえばそう思う
<input type="radio" name="T6" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="T6" value="0"> そう思わない
</p>

<p><span class="look">Q29:勉強で得た知識は、いずれ仕事や生活の役に立つと思うから。</span><br>
<input type="radio" name="P5" value="16.67" required> そう思う
<input type="radio" name="P5" value="11.11"> どちらかといえばそう思う
<input type="radio" name="P5" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="P5" value="0"> そう思わない
</p>

<p><span class="look">Q30:知識や技能を使う喜びを味わいたいから。</span><br>
<input type="radio" name="P6" value="16.67" required> そう思う
<input type="radio" name="P6" value="11.11"> どちらかといえばそう思う
<input type="radio" name="P6" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="P6" value="0"> そう思わない
</p>

<p><span class="look">Q31:勉強しないと、親や先生に悪いような気がして。</span><br>
<input type="radio" name="Ra5" value="16.67" required> そう思う
<input type="radio" name="Ra5" value="11.11"> どちらかといえばそう思う
<input type="radio" name="Ra5" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="Ra5" value="0"> そう思わない
</p>

<p><span class="look">Q32:回りの人たちがよく勉強するので、それにつられて。</span><br>
<input type="radio" name="Ra6" value="16.67" required> そう思う
<input type="radio" name="Ra6" value="11.11"> どちらかといえばそう思う
<input type="radio" name="Ra6" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="Ra6" value="0"> そう思わない
</p>


<p><span class="look">Q33:勉強して良い学校を出た方が、立派な人だと思われるから。</span><br>
<input type="radio" name="S5" value="16.67" required> そう思う
<input type="radio" name="S5" value="11.11"> どちらかといえばそう思う
<input type="radio" name="S5" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="S5" value="0"> そう思わない
</p>

<p><span class="look">Q34:成績が良ければ、仲間から尊敬されると思うから。</span><br>
<input type="radio" name="S6" value="16.67" required> そう思う
<input type="radio" name="S6" value="11.11"> どちらかといえばそう思う
<input type="radio" name="S6" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="S6" value="0"> そう思わない
</p>

<p><span class="look">Q35:学歴があれば、社会に出て経済的にも良い生活ができるから。</span><br>
<input type="radio" name="Rb5" value="16.67" required> そう思う
<input type="radio" name="Rb5" value="11.11"> どちらかといえばそう思う
<input type="radio" name="Rb5" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="Rb5" value="0"> そう思わない
</p>

<p><span class="look">Q36:学歴がよくないと、社会に出てからのいい仕事先がないから。</span><br>
<input type="radio" name="Rb6" value="16.67" required> そう思う
<input type="radio" name="Rb6" value="11.11"> どちらかといえばそう思う
<input type="radio" name="Rb6" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="Rb6" value="0"> そう思わない
</p>

<p class="c"><input type="submit" name="next2" class="btn-gradient-simple" value="次のページへ"></p>
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
