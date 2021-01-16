<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン画面へ</title>
</head>
<body>

<h1>SHARE BRAINS</h1><hr>

<?php

    error_reporting(E_ALL & ~E_NOTICE); //Noticeを表示させない
    session_start();
    session_destroy();

    if(isset($_POST["gotop"])){
        header("Location: https://tb-220294.tech-base.net/mission6_login.php");
    }

?>

<form action = "" method = "post">
    <input type = "submit" name = "gotop" value = "ログイン画面へ>>">
</form>
    
</body>
</html>