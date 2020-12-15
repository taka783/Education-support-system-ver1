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


$con1 = mysqli_query($con, "SELECT flag FROM contract WHERE user_id='". $username . "'");
$row = mysqli_fetch_row($con1);
$Ic = $row[0];

$flag　=　0;

    if($_POST['delete']){
  $flag = 1;
  $result = mysqli_query($con, "DELETE FROM todo WHERE id ='". $_POST["ID2"] ."'");
}


      //exit;
      

  //データ読み込み
//基礎情報数学Aデータ
//月ごとにデータ読み取り 0:10, 1:11, 2:12, 3:1, 4:2, 5:3
$todo1 = mysqli_query($con, "SELECT * FROM todo where user_id='". $username . "' ORDER BY deadline ASC");

//月ごとのデータ件数取得
$g1 = mysqli_query($con, "SELECT COUNT(*) FROM todo WHERE user_id='". $username . "'");
$gg1 = mysqli_fetch_assoc($g1);
$case_1 = $gg1['COUNT(*)'];
$total = $case_1;

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
  Command: toastr["success"]("ToDoリストが削除されました！", "削除完了");
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

<h2>ToDoリストの修正・削除</h2>


<?php
if($total == 0){
  echo "現在登録されている目標はありません。";
}else{
?>
<table class="ta1" border="1" cellspacing="0" cellpadding="5" bordercolor="#333333" align="center" width="100%">
  <tr bgcolor="#87cefa" >
  <th><font color="white">期日</font></th>
　<th><font color="white">教科</font></th>
  <th><font color="white">ToDo</font></th>
　<th><font color="white">編集</font></th>
  <th><font color="white">削除</font></th>
  </tr>
  <tbody>

   <?php
    
    foreach ($todo1 as $row) {
    ?>

    <tr style="background-color: white">

    <td width="15%"><?php echo $row['deadline']; ?></a></td>

    <td width="10%"><?php echo $row['subject']; ?></a></td>
    <!--2.学習目標表示-->
    <td width="40%"><?php echo $row['s_goal']; ?></td>
    <?php
    //登録用ID
    $ID = $row["id"];

    ?>
    <!--3.編集フォーム-->
    <td align="center">
    <form name="EDIT" action="edit2.php?user=<?php echo $username;?>" method="post">
        <input type="hidden" name="ID1" value="<?php echo $ID; ?>">
        <input type="submit" name="edit" class="btn-flat-border" value="編集">
      </form>
    </td>
    <!--4.削除フォーム-->
    <td align="center">
    <form name="DELETE" action="edit1.php?user=<?php echo $username;?>" method="post">
        <input type="hidden" name="ID2" value="<?php echo $ID; ?>">
        <input type="submit" name="delete" class="btn-flat-border" value="×">
    </form>
    </td>
    <!--4.隠しvalueとチェックボックス表示-->

    </td>
    </tr>
    <?php
      }

?>

  </tbody>
</table>

<div class="text-center">
<p class="c">
<form action="todo1.php?user=<?php echo $username;?>" method="post">
   <button type="submit" class="btn-gradient-simple c">進捗管理へ戻る</button> 
</form>
</p>
</p>
<br>
<?php
}
?>
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

