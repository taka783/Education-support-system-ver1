<?php

//urlのid受け取り処理
if(isset($_GET['user'])){
$get_id = $_GET['user'];  
$username = $get_id;
}

require "mysql.php";

//次の画面へid引き渡し
//<a href="main_m.php?user='.$get_id.'"></a>

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


$s1 = mysqli_query($con, "SELECT COUNT(*) FROM View WHERE user_id='". $username . "'");
$ss1 = mysqli_fetch_assoc($s1);
$is1 = $ss1['COUNT(*)'];
$s2 = mysqli_query($con, "SELECT COUNT(*) FROM Motive WHERE user_id='". $username . "'");
$ss2 = mysqli_fetch_assoc($s2);
$is2 = $ss2['COUNT(*)'];
$s3 = mysqli_query($con, "SELECT COUNT(*) FROM VAKT WHERE user_id='". $username . "'");
$ss3 = mysqli_fetch_assoc($s3);
$is3 = $ss3['COUNT(*)'];

$s_flag = $is1+$is2+$is3;

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
$stmt1 = mysqli_query($con, "SELECT * FROM View where user_id='". $username . "'");
foreach ($stmt1 as $row) {
    $failure = $row['failure'];
    $thinking = $row['thinking'];
    $strategy = $row['strategy'];
    $meaning = $row['meaning'];
}

$stmt2 = mysqli_query($con, "SELECT * FROM Motive where user_id='". $username . "'");
foreach ($stmt2 as $row) {
    $fullness = $row['fullness'];
    $training = $row['training'];
    $practical = $row['practical'];
    $relationship = $row['relationship'];
    $self_esteem = $row['self_esteem'];
    $reward = $row['reward'];
}

$M1 = $fullness + $training + $practical;
$M2 = $relationship + $self_esteem + $reward;

$stmt3 = mysqli_query($con, "SELECT * FROM VAKT where user_id='". $username . "'");
foreach ($stmt3 as $row) {
    $vision = $row['vision'];
    $audibility = $row['audibility'];
    $tactile = $row['tactile'];
}

function array_count_by_motive ($arr) {
  $results = [];
  foreach ($arr as $it) {
    $key = (string)$it['point'];
    if (!isset($results[$key])) $results[$key] = [];
    $results[$key][] = $it;
  }
  return $results;
}


$array1 = array(
    array(
        'id'        => 0,
        'point'     => $fullness,
        'title'     => '充実志向',
    ),
    array(
        'id'        => 1,
        'point'     => $training,
        'title'     => '訓練志向',
    ),
    array(
        'id'        => 2,
        'point'     => $practical,
        'title'     => '実用志向',
    ),
    array(
        'id'        => 3,
        'point'     => $relationship,
        'title'     => '関係志向',
    ),
    array(
        'id'        => 4,
        'point'     => $self_esteem,
        'title'     => '自尊志向',
    ),
    array(
        'id'        => 5,
        'point'     => $reward,
        'title'     => '報酬志向',
    ),
);

foreach ((array) $array1 as $key => $value) {
    $sort[$key] = $value['point'];
}

array_multisort($sort, SORT_DESC, $array1);

usort($array1, function ($a, $b) {
  $a2 = $a['point'];
  $b2 = $b['point'];
  if ($a2 == $b2) return 0;
  return ($a2 < $b2) ? 1 : -1;
});

$rank = 1;
$count = 0;
foreach (array_count_by_motive($array1) as $point => $users) {
  foreach ($users as $user) {
    if($rank == 1){
      $motive1 = $user['title'];
      $count++;
      if($count == 2){
        $motive2 = $user['title'];
      }
      if($count == 3){
        $motive3 = $user['title'];
      }
    }
  }
  $rank += count($users);
}


//
function array_count_by_VAT ($arr) {
  $results = [];
  foreach ($arr as $it) {
    $key = (string)$it['point'];
    if (!isset($results[$key])) $results[$key] = [];
    $results[$key][] = $it;
  }
  return $results;
}


$array2 = array(
    array(
        'id'        => 0,
        'point'     => $vision,
        'title'     => '視覚',
    ),
    array(
        'id'        => 1,
        'point'     => $audibility,
        'title'     => '聴覚',
    ),
    array(
        'id'        => 2,
        'point'     => $tactile,
        'title'     => '触覚',
    ),
);

foreach ((array) $array2 as $key => $value) {
    $sort[$key] = $value['point'];
}

array_multisort($sort, SORT_DESC, $array2);

usort($array2, function ($a, $b) {
  $a2 = $a['point'];
  $b2 = $b['point'];
  if ($a2 == $b2) return 0;
  return ($a2 < $b2) ? 1 : -1;
});

$rank = 1;
$count = 0;
foreach (array_count_by_motive($array2) as $point => $users) {
  foreach ($users as $user) {
    if($rank == 1){
      $VAT1 = $user['title'];
      $count++;
      if($count == 2){
        $VAT2 = $user['title'];
      }
      if($count == 3){
        $VAT3 = $user['title'];
      }
    }
  }
  $rank += count($users);
}

?>
<div id="contents">
<section>
<h2>学習スタイル</h2>
<?php
if($is1 == 0 || $is2 == 0 || $is3 == 0){
?>
<br>
<p class="c">
<a href="questionnaire1.php?user=<?php echo $username;?>" class="btn-gradient-simple">学習スタイル診断を始める</a><br>
</p>
<br>
<h2>学習スタイル診断について</h2>
学習スタイル診断では用意された質問項目に回答してもらうことであなたの学習傾向を可視化することができます。<br>
あなたの学び方について知ることができる機会ですので、入学前教育を本格的に始める前に回答してみましょう。<br>
回答にかかる時間は10分程度です。<br>
スタイル診断の結果は今後の振り返りの際に必要になるため必ず行うようにしてください。<br>
期限は1月30日までです。<br>
<br>

<?php
}else{
?>
<h3>あなたの学習観</h3>
<div class="container-fluid">
<div class="row">
<div class="center-block col-xs-12 col-sm-6 col-md-6 col-lg-6 bg-white border border-dark text-center">
あなたの学習観
<hr>
  <canvas id="graph-radar" width=“30” height=“30”></canvas>
</div>
<div class="center-block col-xs-12 col-sm-6 col-md-6 col-lg-6 bg-white border border-dark text-center">
<p class="l"><strong class="color1">■あなたの学習観</strong><br>
失敗に対する柔軟性：失敗に対して柔軟に対応できる強さを指します。<br>
思考過程の重視：学習において思考過程を大切にしようとする強さを指します。<br>
方略志向：勉強の際に、学習方法を意識しようとする強さを指します。<br>
意味理解志向：ただ暗記するのでなく、意味を理解しようとする強さを指します。<br>
</p>
</div>
</div>
</div>

<br>

<h3>学習動機の強さ</h3>
<div class="container-fluid">
<div class="row">
<div class="center-block col-xs-2 col-sm-2 col-md-2 col-lg-2">
</div>
<div class="center-block col-xs-4 col-sm-4 col-md-4 col-lg-4 text-center">
<table class="ta1">
  <tr>
    <th bgcolor="25b1d9" style="color:white;">
      自己充実的達成動機
    </th>
  </tr>
  <tr>
    <td>
      <?php
      if($M1 >= 210){
        echo "強";
      }else if($M1 < 210 || $M1 >= 120){
        echo "中";
      }else if($M1 < 120){
        echo "弱";
      }
      ?>
    </td>
  </tr>
</table>
</div>
<div class="center-block col-xs-4 col-sm-4 col-md-4 col-lg-4 text-center">
<table class="ta1">
  <tr>
    <th bgcolor="25b1d9" style="color:white;">
      競争的達成動機
    </th>
  </tr>
  <tr>
    <td>
      <?php
      if($M2 >= 210){
        echo "強";
      }else if($M2 < 210 || $M2 >= 120){
        echo "中";
      }else if($M2 < 120){
        echo "弱";
      }
      ?>
    </td>
  </tr>
</table>
</div>
<div class="center-block col-xs-2 col-sm-2 col-md-2 col-lg-2">
</div>
<div class="center-block col-xs-2 col-sm-2 col-md-2 col-lg-2">
</div>
<div class="center-block col-xs-8 col-sm-8 col-md-8 col-lg-8">
・「自己充実的達成動機」は自身の成長のためや、将来のためといった目的で学習をする際の学習動機を指します。<br>
・「競争的達成動機」は他の人がやっているから、誰かに褒めて欲しい、そういった周囲の影響を受けて学習をする際の学習動機を指します。
</div>
<div class="center-block col-xs-2 col-sm-2 col-md-2 col-lg-2">
</div>
</div>
</div>
<br>

<h3>あなたの学習タイプ</h3>
<div class="container-fluid">
<div class="row">
<div class="center-block col-sm-2 text-center align-middle border border-dark" style="background: #25b1d9;">
<font color="white">
あなたの<br>学習動機
</font>
</div>
<div class="center-block col-sm-10 bg-white border border-dark">

<?php
if($motive1 == '充実志向' || $motive2 == '充実志向' || $motive3 == '充実志向'){
?>
<div class="row">
<div class="center-block col-sm-3 text-center border border-dark" style="background: orange;">
充実志向
</div>
<div class="center-block col-sm-9 bg-white border border-dark">
勉強すること自体が楽しいと感じられるタイプの人です。充実志向タイプの人のオススメの学習手法として、興味のある本や教材を読んでみたり、学習に費やす時間を増やしてみると良いでしょう。
</div>
</div>
<?php
}
?>

<?php
if($motive1 == '訓練志向' || $motive2 == '訓練志向' || $motive3 == '訓練志向'){
?>
<div class="row">
<div class="center-block col-sm-3 text-center border border-dark" style="background: lightskyblue;">
訓練志向
</div>
<div class="center-block col-sm-9 bg-white border border-dark">
自己鍛錬のために学習を続けるタイプの人です。訓練志向タイプの人のオススメの学習手法として、能力が上がったことを数値化して記録してみたり、段階的に難しい問題に挑戦してみると良いでしょう。
</div>
</div>
<?php
}
?>

<?php
if($motive1 == '実用志向' || $motive2 == '実用志向' || $motive3 == '実用志向'){
?>
<div class="row">
<div class="center-block col-sm-3 text-center border border-dark" style="background: greenyellow;">
実用志向
</div>
<div class="center-block col-sm-9 bg-white border border-dark">
実務や生活等で役立てるために学習をしようと思うタイプの人です。実用志向タイプの人のオススメの学習手法として、これから取り組む学習の有用性を確認してみたり、具体的な仕事や生活への活用事例を提示してみるとよいでしょう。
</div>
</div>
<?php
}
?>

<?php
if($motive1 == '関係志向' || $motive2 == '関係志向' || $motive3 == '関係志向'){
?>
<div class="row">
<div class="center-block col-sm-3 text-center border border-dark" style="background: mistyrose;">
関係志向
</div>
<div class="center-block col-sm-9 bg-white border border-dark">
強い動機はなく、他の人がやっているからと学習をするタイプの人です。関係志向タイプの人のオススメの学習手法として、学習意欲の高い友達と一緒に勉強を進めたり、学習動画を見たりすると良いでしょう。
</div>
</div>
<?php
}
?>

<?php
if($motive1 == '自尊志向' || $motive2 == '自尊志向' || $motive3 == '自尊志向'){
?>
<div class="row">
<div class="center-block col-sm-3 text-center border border-dark" style="background: tomato;">
自尊志向
</div>
<div class="center-block col-sm-9 bg-white border border-dark">
周りに負けたくないからという競争心から学習をしようとするタイプの人です。自尊志向タイプの人のオススメの学習手法として、周りの人よりワンランク上の目標を立ててみると良いでしょう。
</div>
</div>
<?php
}
?>

<?php
if($motive1 == '報酬志向' || $motive2 == '報酬志向' || $motive3 == '報酬志向'){
?>
<div class="row">
<div class="center-block col-sm-3 text-center border border-dark" style="background: lightpink;">
報酬志向
</div>
<div class="center-block col-sm-9 bg-white border border-dark">
外発的報酬を得ることを目的に学習をしようとするタイプの人です。報酬志向タイプの人のオススメの学習手法として、自分へ何か報酬を用意しておくと良いでしょう。
</div>
</div>
<?php
}
?>

</div>
</div>
</div>

<br>


<div class="container-fluid">
<div class="row">
<div class="center-block col-sm-2 text-center align-middle border border-dark" style="background: #25b1d9;">
<font color="white">
あなたの<br>学習スタイル
</font>
</div>
<div class="center-block col-sm-10 bg-white border border-dark">
<?php
if($VAT1 == '視覚' || $VAT2 == '視覚' || $VAT3 == '視覚'){
?>
<div class="row">
<div class="center-block col-sm-3 text-center border border-dark" style="background: skyblue;">
視覚型
</div>
<div class="center-block col-sm-9 bg-white border border-dark">
あなたにはノートや図表などの視覚情報に最も効果的に馴染みます。筆記による伝達や記号操作の能力が高いです。そのため、重要部分にはマーカーを引いたり、図や絵にして整理することでより理解が進むでしょう。
</div>
</div>
<?php
}
?>

<?php
if($VAT1 == '聴覚' || $VAT2 == '聴覚' || $VAT3 == '聴覚'){
?>
<div class="row">
<div class="center-block col-sm-3 text-center border border-dark" style="background: greenyellow;">
聴覚型
</div>
<div class="center-block col-sm-9 bg-white border border-dark">
あなたには話を聞いたり音として聞くことで効果的に学習することができます。ノートや配布資料を声に出して読んで復唱してみたり、音声教材を聞くと良いでしょう。
</div>
</div>
<?php
}
?>

<?php
if($VAT1 == '体感覚' || $VAT2 == '体感覚' || $VAT3 == '体感覚'){
?>
<div class="row">
<div class="center-block col-sm-3 text-center border border-dark" style="background: gold;">
体感覚型
</div>
<div class="center-block col-sm-9 bg-white border border-dark">
あなたは体感覚をうまく使うことで集中力を高められる傾向があります。体を動かして動作パターンを覚えたり、手で書いてみることで理解が進むでしょう。
</div>
</div>
<?php
}
?>

</div>
</div>
</div>

<br>

<h3>診断結果の詳細</h3>

<!-- グラフのライブラリの読み込み -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>
<div class="container-fluid">
<div class="row">

<div class="center-block col-xs-12 col-sm-6 col-md-6 col-lg-6 bg-white border border-dark text-center">
あなたの各学習動機傾向
<hr>
  <canvas id="graph-radar2" width=“30” height=“30”></canvas>
</div>
<div class="center-block col-xs-12 col-sm-6 col-md-6 col-lg-6 bg-white border border-dark text-center">
VAK診断
<hr>
  <canvas id="graph-radar3" width=“30” height=“30”></canvas>
</div>
</div>
</div>

<br><br>

<!-- レーダーチャートの読み込み -->
<script>

var colorSet = {
  red: 'rgba(255,99,132,1)',
  yellow: 'rgb(255, 205, 86)',
  green: 'rgba(75, 192, 192, 1)',
  grey: 'rgb(201, 203, 207)',
    black: 'rgb(0, 0, 0)'
};

var color = Chart.helpers.color;



var ctx = document.getElementById("graph-radar").getContext('2d');
ctx.canvas.width = 180;
var myChart = new Chart(ctx, {
    type: 'radar',
    data: {
        labels: ['失敗に対する柔軟性', '思考過程の重視', '方略志向','意味理解志向'],
        datasets: [{
      label: "あなたの結果",
      backgroundColor: color(colorSet.red).alpha(0).rgbString(),
      borderColor: colorSet.red,
      pointBackgroundColor: colorSet.red,
      data: [<?php echo $failure;?>,<?php echo $thinking;?>,<?php echo $strategy;?>,<?php echo $meaning;?>]    }]
    },
    options: {
        legend: {
            position: 'bottom'
        },
        scale: {
      display: true,
            // ラベルの設定
      pointLabels: {
        fontSize: 10,
        fontColor: colorSet.black
      },
            // 目盛りの設定
      ticks: {
        display: true,
        fontSize: 15,
        fontColor: colorSet.grey,
        min: 0,
        max: 100,
        beginAtZero: true
      },
            // チャートのラインの設定
      gridLines: {
        display: true,
        color: color(colorSet.grey).alpha(0.3).rgbString()
      },
            // レーダーチャートの余白の調整
            beforeFit: function (scale) {
                if (scale.chart.config.data.labels.length === 3) {
                    var pointLabelFontSize = Chart.helpers.getValueOrDefault(scale.options.pointLabels.fontSize, Chart.defaults.global.defaultFontSize);
                    scale.height *= (2 / 1.5)
                    scale.height -= pointLabelFontSize;
                }
            },
            afterFit: function (scale) {
                if (scale.chart.config.data.labels.length === 3) {
                    var pointLabelFontSize = Chart.helpers.getValueOrDefault(scale.options.pointLabels.fontSize, Chart.defaults.global.defaultFontSize);
                    scale.height += pointLabelFontSize;
                    scale.height /= (2 / 1.5);
                }
            }
    }
    }
});
var ctx2 = document.getElementById("graph-radar2").getContext('2d');
ctx2.canvas.width = 180;
var myChart2 = new Chart(ctx2, {
    type: 'radar',
    data: {
        labels: ['訓練志向', '実用志向','関係志向','自尊志向','報酬志向','充実志向',],
        datasets: [{
            label: "あなたの結果",
      backgroundColor: color(colorSet.yellow).alpha(0).rgbString(),
      borderColor: colorSet.yellow,
      pointBackgroundColor: colorSet.yellow,
      data: [<?php echo $training;?>,<?php echo $practical;?>,<?php echo $relationship;?>,<?php echo $self_esteem;?>,<?php echo $reward;?>,<?php echo $fullness;?>]        }]
    },
    options: {
        legend: {
            position: 'bottom'
        },
        scale: {
      display: true,
            // ラベルの設定
      pointLabels: {
        fontSize: 15,
        fontColor: colorSet.black
      },
            // 目盛りの設定
      ticks: {
        display: true,
        fontSize: 15,
        fontColor: colorSet.grey,
        min: 0,
        max: 100,
        beginAtZero: true
      },
            // チャートのラインの設定
      gridLines: {
        display: true,
        color: color(colorSet.grey).alpha(0.3).rgbString()
      },
            // レーダーチャートの余白の調整
            beforeFit: function (scale) {
                if (scale.chart.config.data.labels.length === 3) {
                    var pointLabelFontSize = Chart.helpers.getValueOrDefault(scale.options.pointLabels.fontSize, Chart.defaults.global.defaultFontSize);
                    scale.height *= (2 / 1.5)
                    scale.height -= pointLabelFontSize;
                }
            },
            afterFit: function (scale) {
                if (scale.chart.config.data.labels.length === 3) {
                    var pointLabelFontSize = Chart.helpers.getValueOrDefault(scale.options.pointLabels.fontSize, Chart.defaults.global.defaultFontSize);
                    scale.height += pointLabelFontSize;
                    scale.height /= (2 / 1.5);
                }
            }
      }
    }
});
var ctx3 = document.getElementById("graph-radar3").getContext('2d');
ctx3.canvas.width = 180;
var myChart3 = new Chart(ctx3, {
    type: 'radar',
    data: {
        labels: ['視覚型', '聴覚型','体感覚型'],
        datasets: [{
            label: "あなたの結果",
      backgroundColor: color(colorSet.green).alpha(0).rgbString(),
      borderColor: colorSet.green,
      pointBackgroundColor: colorSet.green,
      data: [<?php echo $vision;?>,<?php echo $audibility;?>,<?php echo $tactile;?>]        }]
    },
    options: {
        legend: {
            position: 'bottom'
        },
        scale: {
      display: true,
            // ラベルの設定
      pointLabels: {
        fontSize: 15,
        fontColor: colorSet.black
      },
            // 目盛りの設定
      ticks: {
        display: true,
        fontSize: 15,
        fontColor: colorSet.grey,
        min: 0,
        max: 100,
        beginAtZero: true
      },
            // チャートのラインの設定
      gridLines: {
        display: true,
        color: color(colorSet.grey).alpha(0.3).rgbString()
      },
            // レーダーチャートの余白の調整
            beforeFit: function (scale) {
                if (scale.chart.config.data.labels.length === 3) {
                    var pointLabelFontSize = Chart.helpers.getValueOrDefault(scale.options.pointLabels.fontSize, Chart.defaults.global.defaultFontSize);
                    scale.height *= (2 / 1.5)
                    scale.height -= pointLabelFontSize;
                }
            },
            afterFit: function (scale) {
                if (scale.chart.config.data.labels.length === 3) {
                    var pointLabelFontSize = Chart.helpers.getValueOrDefault(scale.options.pointLabels.fontSize, Chart.defaults.global.defaultFontSize);
                    scale.height += pointLabelFontSize;
                    scale.height /= (2 / 1.5);
                }
            }
      }
    }
});
</script>
<?php
}
?>

<h2>診断結果の見方</h2>

<h3>診断結果の詳細</h3>
<p><strong class="color1">■あなたの学習動機</strong><br>
充実志向：勉強すること自体が楽しいと感じられるタイプの人<br>
訓練志向：自己鍛錬のために学習を続けるタイプの人<br>
実用志向：実務や生活等で役立てるために学習をしようと思うタイプの人<br>
関係志向：強い動機はなく、他の人がやっているからと学習をするタイプの人<br>
自尊志向：周りに負けたくないからという競争心から学習をしようとするタイプの人<br>
報酬志向：外発的報酬を得ることを目的に学習をしようとするタイプの人<br>
</p>
<p><strong class="color1">■VAK診断</strong><br>
・あなたの五感で優位な感覚を指します。
</p>


</section>

</div>
<!--/contents-->

<footer>
<small>Copyright&copy; <a href="main.php?user=<?php echo $username;?>">学習支援システム</a> All Rights Reserved.</small>
<span class="pr">《<a href="http://template-party.com/" target="_blank">Web Design:Template-Party</a>》</span>
</footer>

<p class="nav-fix-pos-pagetop"><a href="#">↑</a></p>

<!--メニュー開閉ボタン-->
<div id="menubar_hdr" class="close"></div>
<!--メニューの開閉処理条件設定　800px以下-->
<script type="text/javascript">
if (OCwindowWidth() <= 800) {
  open_close("menubar_hdr", "menubar-s");
}
</script>

</div>
</body>
</html> 