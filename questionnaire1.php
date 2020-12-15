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

if ($_SERVER['REQUEST_METHOD'] == "POST"){
  //下のフォームの「変更」が実行された時
  if (array_key_exists("Registration", $_POST)) {
  //下のフォームで入力された値でデータベースを更新
  $result = mysqli_query($con, "INSERT contract SET user_id = '". $username ."', flag = 1, url = 'image/". $username .".jpg'");
  }
}

$con1 = mysqli_query($con, "SELECT COUNT(*) FROM contract WHERE user_id='". $username . "' AND flag=1");
$Icon = mysqli_fetch_assoc($con);
$Ic = $Icon['COUNT(*)'];

$s1 = mysqli_query($con, "SELECT COUNT(*) FROM View WHERE user_id='". $username . "'");
$ss1 = mysqli_fetch_assoc($s1);
$is1 = $ss1['COUNT(*)'];
if($is1 > 0){
  header("Location: questionnaire2.php?user=". $username."");
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

<div id="contents">

<section>

<h2>学習スタイル診断(1/3)</h2>

<p><strong class="color1">次の質問にお答えください</strong></p>
<form action="questionnaire2.php?user=<?php echo $username;?>" method="post">
<p><span class="look">Q1:思ったようにいかない時、頑張ってなんとかしようとする方だ。</span><br>
<input type="radio" name="F1" value="16.67" required> そう思う
<input type="radio" name="F1" value="11.11"> どちらかといえばそう思う
<input type="radio" name="F1" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="F1" value="0"> そう思わない
</p>

<p><span class="look">Q2:間違いをすると、恥ずかしいような気になる。</span><br>
<input type="radio" name="F2" value="0" required> そう思う
<input type="radio" name="F2" value="5.56"> どちらかといえばそう思う
<input type="radio" name="F2" value="11.11"> どちらかといえばそう思わない
<input type="radio" name="F2" value="16.67"> そう思わない
</p>

<p><span class="look">Q3:ある問題が解けた後でも、別の解き方を探してみることがある。</span><br>
<input type="radio" name="T1" value="16.67" required> そう思う
<input type="radio" name="T1" value="11.11"> どちらかといえばそう思う
<input type="radio" name="T1" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="T1" value="0"> そう思わない
</p>

<p><span class="look">Q4:自分で解き方を色々考えるのは、面倒臭いと思う。</span><br>
<input type="radio" name="T2" value="0" required> そう思う
<input type="radio" name="T2" value="5.56"> どちらかといえばそう思う
<input type="radio" name="T2" value="11.11"> どちらかといえばそう思わない
<input type="radio" name="T2" value="16.67"> そう思わない
</p>

<p><span class="look">Q5:成功した人の勉強の仕方に興味がある。</span><br>
<input type="radio" name="S1" value="16.67" required> そう思う
<input type="radio" name="S1" value="11.11"> どちらかといえばそう思う
<input type="radio" name="S1" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="S1" value="0"> そう思わない
</p>

<p><span class="look">Q6:勉強の方法を変えても、効果は大して変わらないと思う。</span><br>
<input type="radio" name="S2" value="0" required> そう思う
<input type="radio" name="S2" value="5.56"> どちらかといえばそう思う
<input type="radio" name="S2" value="11.11"> どちらかといえばそう思わない
<input type="radio" name="S2" value="16.67"> そう思わない
</p>

<p><span class="look">Q7:ただ暗記するのではなく、理解して覚えるように心がけている。</span><br>
<input type="radio" name="M1" value="16.67" required> そう思う
<input type="radio" name="M1" value="11.11"> どちらかといえばそう思う
<input type="radio" name="M1" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="M1" value="0"> そう思わない
</p>

<p><span class="look">Q8:図や表で整理しながら勉強する。</span><br>
<input type="radio" name="M2" value="16.67" required> そう思う
<input type="radio" name="M2" value="11.11"> どちらかといえばそう思う
<input type="radio" name="M2" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="M2" value="0"> そう思わない
</p>

<p><span class="look">Q9:うまくいきそうもないと感じると、すぐやる気がなくなってしまう。</span><br>
<input type="radio" name="F3" value="0" required> そう思う
<input type="radio" name="F3" value="5.56"> どちらかといえばそう思う
<input type="radio" name="F3" value="11.11"> どちらかといえばそう思わない
<input type="radio" name="F3" value="16.67"> そう思わない
</p>

<p><span class="look">Q10:思ったように行かない時は、その原因を突き止めようとする。</span><br>
<input type="radio" name="F4" value="16.67" required> そう思う
<input type="radio" name="F4" value="11.11"> どちらかといえばそう思う
<input type="radio" name="F4" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="F4" value="0"> そう思わない
</p>

<p><span class="look">Q11:テストでできなかった問題は、後からでも解き方を知りたい。</span><br>
<input type="radio" name="T3" value="16.67" required> そう思う
<input type="radio" name="T3" value="11.11"> どちらかといえばそう思う
<input type="radio" name="T3" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="T3" value="0"> そう思わない
</p>

<p><span class="look">Q12:テストでは途中の考え方より、答えがあっていたかが気になる。</span><br>
<input type="radio" name="T4" value="0" required> そう思う
<input type="radio" name="T4" value="5.56"> どちらかといえばそう思う
<input type="radio" name="T4" value="11.11"> どちらかといえばそう思わない
<input type="radio" name="T4" value="16.67"> そう思わない
</p>

<p><span class="look">Q13:勉強の仕方を色々工夫してみるのが好きだ。</span><br>
<input type="radio" name="S3" value="16.67" required> そう思う
<input type="radio" name="S3" value="11.11"> どちらかといえばそう思う
<input type="radio" name="S3" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="S3" value="0"> そう思わない
</p>

<p><span class="look">Q14:成績を上げるには、とにかく努力してたくさん勉強するしかない。</span><br>
<input type="radio" name="S4" value="0" required> そう思う
<input type="radio" name="S4" value="5.56"> どちらかといえばそう思う
<input type="radio" name="S4" value="11.11"> どちらかといえばそう思わない
<input type="radio" name="S4" value="16.67"> そう思わない
</p>

<p><span class="look">Q15:同じパターンの問題を何回もやって慣れるようにする。</span><br>
<input type="radio" name="M3" value="0" required> そう思う
<input type="radio" name="M3" value="5.56"> どちらかといえばそう思う
<input type="radio" name="M3" value="11.11"> どちらかといえばそう思わない
<input type="radio" name="M3" value="16.67"> そう思わない
</p>

<p><span class="look">Q16:なぜそうなるかはあまり考えず、暗記してしまうことが多い。</span><br>
<input type="radio" name="M4" value="0" required> そう思う
<input type="radio" name="M4" value="5.56"> どちらかといえばそう思う
<input type="radio" name="M4" value="11.11"> どちらかといえばそう思わない
<input type="radio" name="M4" value="16.67"> そう思わない
</p>

<p><span class="look">Q17:失敗を繰り返しながら、だんだん完全なものにしていけばいいと思う。</span><br>
<input type="radio" name="F5" value="16.67" required> そう思う
<input type="radio" name="F5" value="11.11"> どちらかといえばそう思う
<input type="radio" name="F5" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="F5" value="0"> そう思わない
</p>

<p><span class="look">Q18:失敗すると、すぐにがっかりしてしまうほうだ。</span><br>
<input type="radio" name="F6" value="0" required> そう思う
<input type="radio" name="F6" value="5.56"> どちらかといえばそう思う
<input type="radio" name="F6" value="11.11"> どちらかといえばそう思わない
<input type="radio" name="F6" value="16.67"> そう思わない
</p>

<p><span class="look">Q19:答えがあっていたかどうかだけでなく、考えがあっていたかが大切だと思う。</span><br>
<input type="radio" name="T5" value="16.67" required> そう思う
<input type="radio" name="T5" value="11.11"> どちらかといえばそう思う
<input type="radio" name="T5" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="T5" value="0"> そう思わない
</p>

<p><span class="look">Q20:なぜそうなるのかわからなくても、答えがあっていればいいと思う。</span><br>
<input type="radio" name="T6" value="0" required> そう思う
<input type="radio" name="T6" value="5.56"> どちらかといえばそう思う
<input type="radio" name="T6" value="11.11"> どちらかといえばそう思わない
<input type="radio" name="T6" value="16.67"> そう思わない
</p>

<p><span class="look">Q21:テストの成績が悪かった時、勉強の量よりも方法を見直してみる。</span><br>
<input type="radio" name="S5" value="16.67" required> そう思う
<input type="radio" name="S5" value="11.11"> どちらかといえばそう思う
<input type="radio" name="S5" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="S5" value="0"> そう思わない
</p>

<p><span class="look">Q22:学習方法を変えるのは面倒そうだ。</span><br>
<input type="radio" name="S6" value="0" required> そう思う
<input type="radio" name="S6" value="5.56"> どちらかといえばそう思う
<input type="radio" name="S6" value="11.11"> どちらかといえばそう思わない
<input type="radio" name="S6" value="16.67"> そう思わない
</p>

<p><span class="look">Q23:習ったことと同士の関連を掴むようにしている。</span><br>
<input type="radio" name="M5" value="16.67" required> そう思う
<input type="radio" name="M5" value="11.11"> どちらかといえばそう思う
<input type="radio" name="M5" value="5.56"> どちらかといえばそう思わない
<input type="radio" name="M5" value="0"> そう思わない
</p>

<p><span class="look">Q24:数学の勉強では、公式を覚えることが大切だと思う。</span><br>
<input type="radio" name="M6" value="0" required> そう思う
<input type="radio" name="M6" value="5.56"> どちらかといえばそう思う
<input type="radio" name="M6" value="11.11"> どちらかといえばそう思わない
<input type="radio" name="M6" value="16.67"> そう思わない
</p>

<p class="c"><input type="submit" name="next" class="btn-gradient-simple" value="次のページへ"></p>
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
