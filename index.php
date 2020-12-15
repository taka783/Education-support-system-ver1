<?php
// セッション開始
//session_start();

$db['host'] = "localhost";  // DBサーバのURL
$db['user'] = "root";  // ユーザー名
$db['pass'] = "root";  // ユーザー名のパスワード
$db['dbname'] = "learn";  // データベース名

// エラーメッセージの初期化
$errorMessage = "";

// ログインボタンが押された場合
if (isset($_POST["login"])) {
   header("Location: main.php?user=". $_POST["userid"] ."");  // メイン画面へ遷移
    exit();  // 処理終了
}
?>

<!doctype html>
<html>
    <head>
            <meta charset="UTF-8">
            <title>ログイン</title>
    </head>
    <body>
        <h1>ログイン画面</h1>
        <form id="loginForm" name="loginForm" action="" method="POST">
            <fieldset>
                <legend>ログインフォーム</legend>
                <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
                <label for="userid">ユーザーID</label><input type="text" id="userid" name="userid" placeholder="ユーザーIDを入力" value="<?php if (!empty($_POST["userid"])) {echo htmlspecialchars($_POST["userid"], ENT_QUOTES);} ?>">
                <br>
                <br>
                <input type="submit" id="login" name="login" value="ログイン">
            </fieldset>
        </form>
        <br>

    </body>
</html>


