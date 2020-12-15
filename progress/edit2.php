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

$g_flag = $ImA + $ImB + $ImC + $Ie + $Ii + $Ij;
$total = $ImA + $ImB + $ImC + $Ie + $Ii + $Ij;

$con1 = mysqli_query($con, "SELECT flag FROM contract WHERE user_id='". $username . "'");
$row = mysqli_fetch_row($con1);
$Ic = $row[0];

//データベース接続

$user = "root";
$pass = "root";
$dbh =new PDO('mysql:host=localhost;dbname=learn;charset=utf8', $user, $pass);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$con = mysqli_connect("localhost", "root", "root");
if (!$con) {
exit('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
}
mysqli_set_charset($con, 'utf-8');
mysqli_select_db($con, "learn");

//データ読み込み
//基礎情報数学Aデータ
//月ごとにデータ読み取り 0:10, 1:11, 2:12, 3:1, 4:2, 5:3
$mathA0 = mysqli_query($con, "SELECT * FROM goal_list where user_id='". $username . "' AND subject=0 AND month=0 ORDER BY month ASC");
$mathA1 = mysqli_query($con, "SELECT * FROM goal_list where user_id='". $username . "' AND subject=0 AND month=1 ORDER BY month ASC");
$mathA2 = mysqli_query($con, "SELECT * FROM goal_list where user_id='". $username . "' AND subject=0 AND month=2 ORDER BY month ASC");
$mathA3 = mysqli_query($con, "SELECT * FROM goal_list where user_id='". $username . "' AND subject=0 AND month=3 ORDER BY month ASC");
$mathA4 = mysqli_query($con, "SELECT * FROM goal_list where user_id='". $username . "' AND subject=0 AND month=4 ORDER BY month ASC");
$mathA5 = mysqli_query($con, "SELECT * FROM goal_list where user_id='". $username . "' AND subject=0 AND month=5 ORDER BY month ASC");

//月ごとのデータ件数取得
$mathA_0 = mysqli_query($con, "SELECT COUNT(*) FROM goal_list WHERE user_id='". $username . "' AND subject=0 AND month=0");
$ImathA_0 = mysqli_fetch_assoc($mathA_0);
$I_m_0 = $ImathA_0['COUNT(*)'];

$mathA_1 = mysqli_query($con, "SELECT COUNT(*) FROM goal_list WHERE user_id='". $username . "' AND subject=0 AND month=1");
$ImathA_1 = mysqli_fetch_assoc($mathA_1);
$I_m_1 = $ImathA_1['COUNT(*)'];

$mathA_2 = mysqli_query($con, "SELECT COUNT(*) FROM goal_list WHERE user_id='". $username . "' AND subject=0 AND month=2");
$ImathA_2 = mysqli_fetch_assoc($mathA_2);
$I_m_2 = $ImathA_2['COUNT(*)'];

$mathA_3 = mysqli_query($con, "SELECT COUNT(*) FROM goal_list WHERE user_id='". $username . "' AND subject=0 AND month=3");
$ImathA_3 = mysqli_fetch_assoc($mathA_3);
$I_m_3 = $ImathA_3['COUNT(*)'];

$mathA_4 = mysqli_query($con, "SELECT COUNT(*) FROM goal_list WHERE user_id='". $username . "' AND subject=0 AND month=4");
$ImathA_4 = mysqli_fetch_assoc($mathA_4);
$I_m_4 = $ImathA_4['COUNT(*)'];

$mathA_5 = mysqli_query($con, "SELECT COUNT(*) FROM goal_list WHERE user_id='". $username . "' AND subject=0 AND month=5");
$ImathA_5 = mysqli_fetch_assoc($mathA_5);
$I_m_5 = $ImathA_5['COUNT(*)'];

$Data = array($I_m_0, $I_m_1, $I_m_2, $I_m_3, $I_m_4, $I_m_5);

$total = $I_m_0 + $I_m_1 + $I_m_2 + $I_m_3 + $I_m_4 + $I_m_5;

//前の画面からidの値を取得
if(isset($_POST["ID1"])){
  $id = htmlspecialchars($_POST["ID1"], ENT_QUOTES, 'UTF-8');
  $i = (int) $id;
}

  //idから月を取得
  $stmt1 = mysqli_query($con, "SELECT month FROM goal_list WHERE id ='" . $id . "'");
    if (!$stmt1) {
        echo "データの取得に失敗しました";
        exit;
    }
  $row = mysqli_fetch_row($stmt1);
  $month = $row[0];

  //idから目標を取得
  $stmt2 = mysqli_query($con, "SELECT s_goal FROM goal_list WHERE id='" . $id . "'");
  if (!$stmt2) {
      echo "データの取得に失敗しました";
      exit;
      }
  $row = mysqli_fetch_row($stmt2);
  $goal = $row[0];

    if ($_SERVER['REQUEST_METHOD'] == "POST"){
      //下のフォームの「変更」が実行された時
    if (array_key_exists("edit1", $_POST)) {
      //下のフォームで入力された値でデータベースを更新
      $result = mysqli_query($con, "UPDATE goal_list SET month = '". $_POST["month"] ."', s_goal = '". $_POST["goal"] ."' WHERE id = '". $_POST["ID1"] ."'");
      ?>
      <meta http-equiv="Refresh" content="0; URL=edit1.php?user=<?php echo $username;?>">
      <?php
      exit;
      
    }
  }

    if ($_SERVER['REQUEST_METHOD'] == "POST"){
      //下のフォームの「変更」が実行された時
    if (array_key_exists("delete", $_POST)) {
      //下のフォームで入力された値でデータベースを更新
      $result = mysqli_query($con, "DELETE FROM goal_list WHERE id ='". $_POST["ID2"] ."'");
      ?>
      <meta http-equiv="Refresh" content="0; URL=edit1.php?user=<?php echo $username;?>">
      <?php
      exit;
      
    }
  }

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
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
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
<!-- メニュー開閉用-->
<script type="text/javascript" src="js/openclose.js"></script>
<script type="text/javascript" src="js/fixmenu_pagetop.js"></script>
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

<h2>ToDoリストの追加</h2>


    <form action="todo1.php?user=<?php echo $username;?>&subject=<?php echo $s_id;?>" method="post">
      <table class="ta1">
      <tr>
        <th colspan="2" class="tamidashi">入力フォーム</th>
      </tr>
      <tr>
      <th>月</th>
      <input type="hidden" name="ID1" value="<?php echo $id;?>" />
      <td>
      <select name="month" align="left" required="">
           <?php
        if($month == 0){
          echo "<option value='0' selected>10</option>";
        }else{
          echo "<option value='0'>10</option>";
        }

        if($month == 1){
          echo "<option value='1' selected>11</option>";
        }else{
          echo "<option value='1'>11</option>";
        }

        if($month == 2){
          echo "<option value='2' selected>12</option>";
        }else{
          echo "<option value='2'>12</option>";
        }

        if($month == 3){
          echo "<option value='3' selected>1</option>";
        }else{
          echo "<option value='3'>1</option>";
        }

        if($month == 4){
          echo "<option value='4' selected>2</option>";
        }else{
          echo "<option value='4'>2</option>";
        }

        if($month == 5){
          echo "<option value='5' selected>3</option>";
        }else{
          echo "<option value='5'>3</option>";
        }
        ?>
      </select>
    </td>
  </tr>
  <tr>
    <th>ToDo</th>
    <td> <input type="text" name="goal" class="textbox1" size="80" value="<?php echo $goal;?>" required="" autocomplete="off" style="width: 100%;"></td>
  </tr>
</table>

<div class=" container-fluid">
<div class="row">
<div class="right-block col-sm-6 text-right">
   <input type="submit" name="ch" value="ToDoリスト登録" class="btn-gradient-simple"/>
</form>

</div>
<div class="left-block col-sm-6 text-left">
<form action="todo1.php?user=<?php echo $username;?>&subject=<?php echo $s_id;?>" method="post">
   <input type="submit" value="進捗管理へ戻る" class="btn-gradient-simple"/>
</form>
</div>
</div>
</div>
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

