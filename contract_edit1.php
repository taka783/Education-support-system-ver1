<?php

//urlのid受け取り処理
if(isset($_GET['user'])){
$get_id = $_GET['user'];  
$username = $get_id;
}

if(isset($_POST['temp1'])){
$design = "temp1";
}

if(isset($_POST['temp2'])){
$design = "temp2";
}

if(isset($_POST['temp3'])){
$design = "temp3";
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
$Icon = mysqli_fetch_assoc($con1);
$Ic = $Icon['COUNT(*)'];

$con2 = mysqli_query($con, "SELECT COUNT(*) FROM contract WHERE user_id='". $username . "' AND flag=1");
$Icon = mysqli_fetch_assoc($con2);
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

<div id="contents">

<h2>自己変革プラン作成について</h2>

<p><strong class="color1">■あなたの学び方を改善する案を考えてみよう！</strong><br>
・先程の振り返りから、あなたが抱えている学習の問題点が見えてきたかと思います。<br>
・その問題点の中でも、特に改善したいと思うことを目標にしてみましょう！<br>
・目標が定まったら、どのようにして目標を達成するかの方法と、その判定方法を考えてみましょう！<br>
・この学習を進めていく上で、うまく進められている時の自分へのご褒美とできなかった時の罰も考えてみましょう！
ご褒美や罰則を設定することでメリハリのある学習が期待できます。<br><br>

※<a href="contract_temp.php?user=<?php echo $username;?>">自己変革プラン作成の例</a>はこちらから<br>
※<a href="visu2.php?user=<?php echo $username;?>" target="_blank">振り返りのデータ</a>はこちらから
</p>

</section>

<section>

<h2>自己変革プラン作成</h2>
<p><strong class="color1">■次の項目を入力してください</strong><br>
    <form action="contract_edit2.php?user=<?php echo $username;?>&design=<?php echo $design;?>" method="post">
<strong class="color1">1.目標</strong><br>
        ここまでの学習を振り返ることであなたの学習中の特徴や問題点が少しわかってきたかと思います。<br>
        振り返りであなたが自分で問題だと感じた学習行動を改善するための目標を立ててみましょう。<br><br>
        【目標の例】<br>
        ・学習する課題に優先順位を決めて苦手をなくすようにバランスよく学習する.<br>
        ・学習の際は音読をすることで理解を促進させる.<br>
        ・毎日英単語の暗記や長文読解の時間を設けることで英語の苦手意識をなくす. <br><br>
        【チェック項目】<br>
        □具体的な目標となっている(「しっかり学習を進める」のような目標でなく, 「毎日1時間以上の学習時間を設けることで継続的な学習を目指す」といったようにどのような目標なのかを明確に)<br>
        <textarea name="goal" rows="4" cols="100" wrap="soft" required="" autocomplete='off'maxlength="500"></textarea>
        <br>
<strong class="color1">2.目標を設定した理由</strong><br>
<p>
        何を根拠に問題と感じたのか、その目標を立てたのかの理由を記述してください。<br><br>
        【チェック項目】<br>
        □問題だと思った時のエピソードがきちんと記載されている.(「高校の授業中で...」「家出の自学の最中で...」「学び方支援システムでのデータから...」)
    </p>
        <textarea name="reason" rows="6" cols="100" wrap="soft" required="" autocomplete='off'maxlength="500"></textarea>
        <br>
<strong class="color1">3.達成するための方略</strong><br>
        あなたには、学習行動を改善するための目標を立ててもらいました。<br>
        あなたがこの目標を達成するためにこれからの学習で実践する学習法や作戦を設計してみましょう。<br><br>
        【学習方略の例】<br>
        ・学習の環境を変えてみる.(机の上を整理する, 図書室で勉強してみる)<br>
        ・新しい学習法を試す.(音読をしてみる, 図や表で整理する)<br>
        <textarea name="strategy" rows="6" cols="100" wrap="soft" required="" autocomplete='off'maxlength="500"></textarea>
        <br>
<strong class="color1">4.契約成功の判断材料</strong><br>
        あなたにが立てた目標は何を基準に達成したとみなすか、その基準となるデータorゴールを設定しましょう。<br>
        例1：学習時間の累計が50時間を超える.<br>
        例2：3月上旬までに行うべき課題すべてを完了させる.<br>
        <textarea name="judgment" rows="2" cols="100" wrap="soft" required="" autocomplete='off'maxlength="500"></textarea>
        <br>
<strong class="color1">5.報酬と罰</strong><br>
<p>
        あなたが上記で設計した契約通りに学習を進められた時、また契約に違反した学習行動を取った際に<br>
        自分へ与えるご褒美と自分の行動へ制限する内容を定めてください。<br><br>
        【チェック項目】<br>
        □報酬と罰それぞれ必ず一つは設定すること.(「特にない」という設定はしないでください)<br>
        ※設定する内容は, 報酬であれば「買い物をする」「音楽を聴く」, 罰であれば「部屋の掃除をする」「おやつを禁止にする」などのような日常生活での活動でかまいません.
    </p>
        <textarea name="reward" rows="6" cols="100" wrap="soft" required="" autocomplete='off'maxlength="300"></textarea><br>
<strong class="color1">6.達成までの期限</strong><br>
        この契約内容をいつまでに遂行するか、期限を定めてください。<br>
        <input type="date" name="date"><br>
<strong class="color1">7.サイン(あなたの名前)</strong><br>
        <input type="text" name="yourname"><br>
        <br>
        <br>
        <p class="c">
          <input type="submit" class="btn-gradient-simple" value="登録"> 
        </p>
    </form>
    <br>
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

</body>
</html>
