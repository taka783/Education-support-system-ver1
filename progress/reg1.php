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


<br>
<span class="look">登録用の行数を追加</span>:
<select id="numSelect" name="numSelect">
     <option value="1" selected>1</option>
     <option value="2">2</option>
     <option value="3">3</option>
     <option value="4">4</option>
     <option value="5">5</option>
     <option value="10">10</option>
</select>行
<br><br>

    <form action="todo1.php?user=<?php echo $username;?>&subject=<?php echo $s_id;?>" method="post">
      <div id="inputForms">
      <table class="ta1">
      <tr>
      <th colspan="2" class="tamidashi">入力フォーム</th>
      </tr>
      <tr>
      <th>期日</th>
      <td>
        <input name="deadline[]" type="date"></input>
      </td>
      </tr>
      <tr>
      <th>科目</th>
      <td>
        <select name="subject[]" align="left" required="">
            <option value="数学">数学</option>
            <option value="英語">英語</option>
            <option value="情報">情報</option>
            <option value="国語">国語</option>
            <option value="その他">その他</option>
        </select>
      </td>
      </tr>
      <tr>
      <th>ToDo</th>
      <td>
        <input type="text" name="goal[]" value="" autocomplete='off' style="width:100%;">
      </td>
    </tr>
      </table>
      </div>
<div class=" container-fluid">
<div class="row">
<div class="right-block col-sm-6 text-right">
   <input type="submit" name="reg" value="ToDoリスト登録" class="btn-gradient-simple"/>
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

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
    <script>
      $(function($) {
        $('#numSelect').change(function() {
          $('#inputForms').empty();
          for(var i = 0; i < $(this).val(); i++){
            var addForm = $("<table class='ta1'><tr><th colspan='2' class='tamidashi'>入力フォーム</th></tr><tr><th>期日</th><td><input name='deadline[]' type='date'></td></input></tr><tr><th>科目</th><td><select name='subject[]' align='left' required=''><option value='数学'>数学</option><option value='英語'>英語</option><option value='情報'>情報</option><option value='国語'>国語</option><option value='その他'>その他</option></select></td></tr><tr><th>ToDo</th><td><input type='text' name='goal[]' value='' autocomplete='off' style='width:100%;'></td></tr></table><br><br>");
            $('#inputForms').append(addForm);
          }
        });
      });
    </script>

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

