<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>パスワード変更｜SHARE BRAINS</title>
    <style>
        .title{
            border-left : 8px solid steelblue;
            padding-left : 10px;
        }
        .error{
            color : red;
        }
    </style>
</head>
<body>
    <?php
        error_reporting(E_ALL & ~E_NOTICE); //Noticeを表示させない
    ?>


    <?php if(!isset($_SESSION["userid"])) : ?>
        <script language="javascript" type="text/javascript">
            alert('セッションが無効です');
            location.href = "https://tb-220294.tech-base.net/mission6_login.php";
        </script>
    <?php endif ; ?>

    <?php

    //DBに接続
    $dsn = 'mysql:dbname=***;host=***';
    $user = '***';
    $password = '***';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

    $send = $_POST["send"];
    $newpass = $_POST["newpass"];
    $nowpass = $_POST["nowpass"];
    $passcheck = $_POST["passcheck"];
    $pattern = '/^[a-zA-Z0-9]{6,12}$/';
    $password_hash =  password_hash($newpass, PASSWORD_DEFAULT);
    $session_id = $_SESSION["id"];

    if(isset($send)){
        if($newpass == NULL or $passcheck == NULL){
            $miss1 = "※パスワードをご入力下さい";
        }elseif($newpass != $passcheck){
            $miss2 = "※パスワードが一致しません";
        }elseif(!preg_match($pattern,$newpass)){
            $miss3 = "※6~12文字以上で設定して下さい";
        }

        $sql = "SELECT * FROM m6_login WHERE id='$session_id'";
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row){
            if(!password_verify($nowpass,$row['password'])){
                $miss4 = "※パスワードが違います";
            }
        }

        if($miss1 == NULL && $miss2 == NULL && $miss3 == NULL && $miss4 == NULL){
            $go = "質問送信";
            $sql = $pdo -> prepare("UPDATE m6_login SET password=:password WHERE id='$session_id'" );                       
                $sql -> bindParam(':password', $password_hash, PDO::PARAM_STR); 
                $sql -> execute();
        }       
    }

    ?>




<!--====================表示画面===================-->

<?php if($go != NULL) : ?>
    <h1 style="color:red">パスワードは変更されました</h1>
    <form action = "https://tb-220294.tech-base.net/mission6_main2.php" method = post>
        <input type = "submit" name = "passtomain" value = "メインメニューへ戻る>>">
    </form>

<?php else : ?>
    <form action = "" method = post>

    <div class = "title"><h3>現在のパスワード</h3></div>
        <div class = "error"><?php echo $miss4; echo "　";?></div>
        <input type = "password" name = "nowpass" style = "width:320px;" placeholder = "現在のパスワード" value = "<?php echo $nowpass; ?>"><br><br>
    <div class = "title"><h3>新しいパスワード</h3></div>
        <div class = "error"><?php echo $miss1; echo $miss2; echo $miss3; echo "　";?></div>
        <input type = "password" name = "newpass" style = "width:320px;" placeholder = "新しいパスワード" value = "<?php echo $newpass; ?>">　（6~12文字で半角英数字のみです）<br>
        <input type = "password" name = "passcheck" style = "width:320px;" placeholder = "確認用" value = "<?php echo $passcheck; ?>">　確認のためもう一度ご入力下さい。<br><br>
        <hr style = "border:0.5px dashed silver">

    <div style="display:inline-flex">
        <input type = "submit" name = "send" value = "送信" style = "width:120px; background-color:steelblue; color:white;">　
    </form>
    <form action = "https://tb-220294.tech-base.net/mission6_main2.php" method = post>
        <input type = "submit" name = "passtomain" value = "メインメニューへ戻る>>">
    </form>
    </div>

<?php endif ; ?>
    
</body>
</html>