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

$flag = 0;

//todo追加
if($_POST['reg']){
  $flag = 1;
  $deadline = $_POST['deadline'];
  $subject = $_POST['subject'];
  $goal = $_POST['goal'];
  //var_dump($deadline);
  //var_dump($subject);
  //var_dump($goal);
  $iii = 0;
  foreach( $deadline as $row ) {
    if($goal[$iii] != NULL){
   $result = mysqli_query($con, "INSERT INTO todo SET deadline = '".$row."', user_id = '".$username."', s_goal = '".$goal[$iii]."', c_flag = 0 , subject = '".$subject[$iii]."'");
 }
   $iii++;
  }
}

if($_POST['ch']){
  $flag = 3;
  $result = mysqli_query($con, "UPDATE todo SET deadline = '". $_POST["month"] ."', s_goal = '". $_POST["goal"] ."' WHERE id = '". $_POST["ID1"] ."'");
}

$goal_date = date("Y-m-d");

//下のフォームが送信された時
if($_POST['progress']){
  $flag = 2;
  $goal_ID = $_POST["progress"];
  $result = mysqli_query($con, "UPDATE todo SET c_date = '". $goal_date ."', c_flag = 1 WHERE id = '".$goal_ID."'");
  //if($Iachi == 0){
  //}else{
  /*
  $jo1 = mysqli_query($con, "SELECT a_point FROM achivement WHERE user_id='". $username . "' ORDER BY month ASC");
  $row = mysqli_fetch_row($jo1);
  $Jo1 = $row[0];
  $result1 = mysqli_query($con, "INSERT INTO achivement SET user_id = '".$username."', log_day = '".$now."', a_point = '".$le."'");
  */
  //}
    if (!$result) {
        echo "データベースの更新に失敗しました。<br>";
        exit;
    }
}

$con1 = mysqli_query($con, "SELECT flag FROM contract WHERE user_id='". $username . "'");
$row = mysqli_fetch_row($con1);
$Ic = $row[0];



//データ読み込み
//基礎情報数学Aデータ
//月ごとにデータ読み取り 0:10, 1:11, 2:12, 3:1, 4:2, 5:3
$todo1 = mysqli_query($con, "SELECT * FROM todo where user_id='". $username . "' ORDER BY deadline ASC");

//月ごとのデータ件数取得
$g1 = mysqli_query($con, "SELECT COUNT(*) FROM todo WHERE user_id='". $username . "'");
$gg1 = mysqli_fetch_assoc($g1);
$case_1 = $gg1['COUNT(*)'];

$total = $case_1;

//残り期日計算
function remainDate($day) {
    return intval((strtotime($day) - strtotime(date('Y/m/d'))) / (60*60*24));
}

$progress = mysqli_query($con, "SELECT COUNT(*) FROM todo WHERE user_id='". $username . "' AND c_flag = 1");
$pro = mysqli_fetch_assoc($progress);
$pro_INT = $pro['COUNT(*)'];
$All_goal = mysqli_query($con, "SELECT COUNT(*) FROM todo WHERE user_id='". $username . "'");
$All = mysqli_fetch_assoc($All_goal);
$All_INT = $All['COUNT(*)'];

$level = $pro_INT / $All_INT * 100;
$le = round($level, 1);

date_default_timezone_set('Asia/Tokyo');
$now = date('Y-m-d H:i:s');
/*
$achi = mysqli_query($con, "SELECT COUNT(*) FROM achivement WHERE user_id='". $username . "'");
$row = mysqli_fetch_assoc($achi);
$Iachi = $wor['COUNT(*)'];
*/

//下のフォームが送信された時
if($flag == 2){
  $result1 = mysqli_query($con, "INSERT INTO achievement SET user_id = '".$username."', log_day = '".$now."', a_point = '".$le."'");
}

//通知機能
if($le < 30){
  $delete_30 = mysqli_query($con, "DELETE FROM notification WHERE user_id='". $username . "' AND flag = 2");
  $delete_50 = mysqli_query($con, "DELETE FROM notification WHERE user_id='". $username . "' AND flag = 3");
  $delete_80 = mysqli_query($con, "DELETE FROM notification WHERE user_id='". $username . "' AND flag = 4");
  $delete_100 = mysqli_query($con, "DELETE FROM notification WHERE user_id='". $username . "' AND flag = 5");
}else if($le >= 30 && $le < 50){
  $not_30 = mysqli_query($con, "SELECT COUNT(*) FROM notification WHERE user_id='". $username . "' AND flag = 2");
  $no_30 = mysqli_fetch_assoc($not_30);
  $INT_30 = $no_30['COUNT(*)'];
  if($INT_30 == 0){
      $In_con = mysqli_query($con, "INSERT notification SET user_id = '". $username ."', log_day = '". $now ."', content = 'あなたのToDoの進捗が30%を達成しました!', flag = 2");
  }
  $delete_50 = mysqli_query($con, "DELETE FROM notification WHERE user_id='". $username . "' AND flag = 3");
  $delete_80 = mysqli_query($con, "DELETE FROM notification WHERE user_id='". $username . "' AND flag = 4");
  $delete_100 = mysqli_query($con, "DELETE FROM notification WHERE user_id='". $username . "' AND flag = 5");
}else if($le >= 50 && $le < 80){
  $not_50 = mysqli_query($con, "SELECT COUNT(*) FROM notification WHERE user_id='". $username . "' AND flag = 3");
  $no_50 = mysqli_fetch_assoc($not_50);
  $INT_50 = $no_50['COUNT(*)'];
  if($INT_50 == 0){
      $In_con = mysqli_query($con, "INSERT notification SET user_id = '". $username ."', log_day = '". $now ."', content = 'あなたのToDoの進捗が50%を達成しました!', flag = 3");
  }
  $delete_80 = mysqli_query($con, "DELETE FROM notification WHERE user_id='". $username . "' AND flag = 4");
  $delete_100 = mysqli_query($con, "DELETE FROM notification WHERE user_id='". $username . "' AND flag = 5");
}else if($le >= 80 && $le < 100){
  $not_80 = mysqli_query($con, "SELECT COUNT(*) FROM notification WHERE user_id='". $username . "' AND flag = 4 AND flag_2 = ". $s_id . "");
  $no_80 = mysqli_fetch_assoc($not_80);
  $INT_80 = $no_80['COUNT(*)'];
  if($INT_80 == 0){
      $In_con = mysqli_query($con, "INSERT notification SET user_id = '". $username ."', log_day = '". $now ."', content = 'あなたのToDoの進捗が80%を達成しました!', flag = 4");
  }
  $delete_100 = mysqli_query($con, "DELETE FROM notification WHERE user_id='". $username . "' AND flag = 5");
}else if($le == 100){
  $not_100 = mysqli_query($con, "SELECT COUNT(*) FROM notification WHERE user_id='". $username . "' AND flag = 5");
  $no_100 = mysqli_fetch_assoc($not_100);
  $INT_100 = $no_100['COUNT(*)'];
  if($INT_100 == 0){
      $In_con = mysqli_query($con, "INSERT notification SET user_id = '". $username ."', log_day = '". $now ."', content = 'あなたのToDoの進捗が100%を達成しました!', flag = 5");
  }
}

//合計学習時間取得

$sum = mysqli_query($con, "SELECT SUM(math) FROM journal1 WHERE user_id='". $username . "'");
$time_Sum = mysqli_fetch_assoc($sum);
$t_sumM = $time_Sum['SUM(math)'];
$sum = mysqli_query($con, "SELECT SUM(eng) FROM journal1 WHERE user_id='". $username . "'");
$time_Sum = mysqli_fetch_assoc($sum);
$t_sumE = $time_Sum['SUM(eng)'];
$sum = mysqli_query($con, "SELECT SUM(inf) FROM journal1 WHERE user_id='". $username . "'");
$time_Sum = mysqli_fetch_assoc($sum);
$t_sumI = $time_Sum['SUM(inf)'];
$sum = mysqli_query($con, "SELECT SUM(jap) FROM journal1 WHERE user_id='". $username . "'");
$time_Sum = mysqli_fetch_assoc($sum);
$t_sumS = $time_Sum['SUM(jap)'];

$sum = mysqli_query($con, "SELECT SUM(total) FROM journal1 WHERE user_id='". $username . "'");
$time_Sum = mysqli_fetch_assoc($sum);
$total_time = $time_Sum['SUM(total)'];
$All_j = mysqli_query($con, "SELECT COUNT(*) FROM journal1 WHERE user_id='". $username . "'");
$row = mysqli_fetch_assoc($All_j);
$count_time = $row['COUNT(*)'];
if($count_time == 0){
  $total_time = 0;
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


<br>
<?php
if($total == 0){
  echo "※現在登録されているToDoリストはありません。";
    ?>
<br>
<p class="c">
<form action="reg1.php?user=<?php echo $username;?>&subject=<?php echo $s_id;?>" method="post">
   <button type="submit" class="btn-gradient-simple">ToDoリストの追加</button> 
</form>
</p>
<?php
}else{
?>

<div class="container-fluid">
<!--row開始-->
<div class="row">
<div class="col-sm-6">
<h3>ToDoの進捗</h3>
<div class="w3-light-grey w3-round-xlarge">
    <div class="w3-container w3-blue w3-round-xlarge" style="width:<?php echo $le; ?>%"><?php echo $le; ?>%</div>
</div>
<br>
    <p class="r"><a href="visu3.php?user=<?php echo $username;?>&flag=1" target="_blank">データの詳細</a></p>
</div>
<div class="col-sm-6">
<h3>学習時間の合計</h3>
<h5><?php echo $total_time; ?>時間</h5>
<p class="r"><a href="visu3.php?user=<?php echo $username;?>&flag=2" target="_blank">データの詳細</a></p>
</div>
</div>
</div>
<br>
<h3>ToDoリスト</h3>
<form action="todo1.php?user=<?php echo $username;?>&subject=<?php echo $s_id;?>" method="post">
<table  class="ta1" border="1" cellspacing="0" cellpadding="5" bordercolor="#333333" align="center" width="100%">
  <tr bgcolor="#87cefa" >
  <th><font color="white">期日</font></th>
  <th><font color="white">教科</font></th>
  <th><font color="white">ToDo</font></th>
  <th><font color="white">達成日</font></th>
  <th><font color="white">達成チェック</font></th>
  </tr>
  <tbody>

  <?php
    
    foreach ($todo1 as $row) {
    ?>

    <?php
    if($row['deadline'] > $goal_date){
    ?>
    <tr style="background-color: white">
    <?php
    }else if($row['deadline'] < $goal_date && $row['c_flag'] == 0){
    ?>
    <tr style="background-color: red">
    <?php
    }else if($row['c_flag'] == 1){
    ?>
    <tr style="background-color: lightgreen">
    <?php
    }
    ?>
    <td width="15%"><?php echo $row['deadline']; ?></a></td>

    <td width="10%"><?php echo $row['subject']; ?></a></td>
    <!--2.学習目標表示-->
    <td width="40%"><?php echo $row['s_goal']; ?></td>

    <!--3.達成日表示-->
    <?php
    //日付　非表示
    //フラグ定義
    if($row["c_date"] != "0000-00-00"){
    ?>
      <td width="20%"><?php echo $row["c_date"]; ?></td>
    <?php
    }else{
      echo '<td width="20%">   </td>';
    }
    ?>
    <!--4.隠しvalueとチェックボックス表示-->
    <?php
    //登録用ID
    $ID = $row["id"];

    if($row['c_flag'] == 1){
      echo '<td align="center" width="20%">';
      echo "完了済み";
    }else{
    ?>
      <td align="center" width="20%" class="firstBox">
      <button type="submit" name="progress" class="btn-flat-border" value="<?php echo $ID; ?>">達成</button>
    <?php
    }
    ?>
    </td>
    </tr>
    <?php
      }

?>

  </tbody>
</table>
</form>

<br>
<div class=" container-fluid">
<div class="row">
<div class="right-block col-sm-4 text-right">
<form action="reg1.php?user=<?php echo $username;?>" method="post">
   <button type="submit" class="btn-gradient-simple">ToDoリストの追加</button> 
</form>
</div>
<div class="center-block col-sm-4 text-center">
<form action="edit1.php?user=<?php echo $username;?>" method="post">
   <button type="submit" class="btn-gradient-simple">ToDoリストの削除</button> 
</form>
</div>
<div class="left-block col-sm-4 text-left">
<form action="reset.php?user=<?php echo $username;?>" method="post">
   <button type="submit" class="btn-gradient-simple">達成修正</button> 
</form>
</div>
</div>
</div>
<?php
}
?>
<br><br>
</section>



<section>

<h2>ToDoリストについて</h2>

<p><strong class="color1">■ToDoリストを設定してみましょう</strong><br>
・ToDoリスト機能では科目ごとにToDoリストの登録を行うことができます。<br>
・教科ごとに目標を達成するためにどんなことが必要なのかをToDoリストとして書き出してみましょう！<br>
・ToDoリストは月ごとに設定できるので、何月中に何をやるのかを整理してみましょう！<br>
<a href="todo_temp.php?user=<?php echo $username;?>&subject=<?php echo $s_id;?>">ToDoリストの作成例</a>はこちらから<br>
</p>

<p><strong class="color1">■達成チェックについて</strong><br>
・ToDoリストの追加をした後に、登録されたToDoの「達成」の欄をクリックすることで達成情報が登録されます。<br>
・達成した情報が進捗度に換算されます。<br>
・設定したToDoリストを計画的にこなして、進捗度100%を目指しましょう！<br>
</p>

<p><strong class="color1">■ToDoリストの追加, ToDoリストの修正&削除, 達成修正について</strong><br>
・ToDoリストの追加は新たにToDoリストを追加することができます。<br>
・ToDoリストの修正&削除はToDoリストの内容の訂正したい場合にToDoリストの編集を行うことができます。<br>
・達成修正は達成情報の登録を訂正したい場合に修正することができます。<br>
・必ず学習に関しての内容のToDo入れる必要はありません。プライベートの用事や作成物を進めるなどのタスクも列挙してやり忘れがないようにしましょう。<br>
</p>

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

