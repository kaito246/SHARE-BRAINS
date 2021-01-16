<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログインページ｜SHARE BRAINS</title>
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

session_start();

    //DBに接続
    $dsn = 'mysql:dbname=***;host=***';
    $user = '***';
    $password = '***';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

    //定義
    $login = $_POST["login"];
    $userid = $_POST["userid"];
    $pass = $_POST["pass"];

    if(isset($login)){
        if($userid != NULL && $pass != NULL){
            $sql = 'SELECT * FROM m6_login';
	        $stmt = $pdo->query($sql);
	        $results = $stmt -> fetchAll();
	        foreach ($results as $row){
                if(password_verify($pass,$row['password']) && $userid == $row['userid']){
                    $_SESSION["userid"] = $userid;
                    header("Location:https://tb-220294.tech-base.net/mission6_main2.php");
                    exit();
                }else{
                    $miss1 = "※ユーザーIDかパスワードが違います";   
                }
            }
        }elseif($userid == NULL && $pass != NULL){
            $miss2 = "※入力して下さい";
        }elseif($userid != NULL && $pass == NULL){
            $miss3 = "※入力して下さい";
        }else{
            $miss2 = "※入力して下さい";
            $miss3 = "※入力して下さい";
        }
    }


?>

    <h1>SHARE BRAINS ログインページ</h1><hr>
    <div class = "title"><h3>ログイン</h3></div>
    <form action = "" method = "post">
        ユーザーID<span style = "color:red"><?php echo "　".$miss2; ?></span><br>
        <input type = "text" name = "userid" style = "width:300px;" value = "<?php echo $userid; ?>"><br>
        パスワード<span style = "color:red"><?php echo "　".$miss3; ?></span><br>
        <input type = "password" name = "pass" style = "width:300px;" value = "<?php echo $pass; ?>">　
        <input type = "submit" name = "login" value = "ログイン" style = "width:150px; background-color:steelblue; color:white;"><br>
        <span style = "color:red"><?php echo $miss1; echo $password_hash; echo "　"; ?></span><br><br><br>
    </form>
    <div class = "title"><h3>初めての方はこちら</h3></div>
        新規登録ボタンよりご登録をお願いします。
        <button onclick="location.href='https://tb-220294.tech-base.net/mission6_newpre.php'" style = "width:150px; background-color:steelblue; color:white;">新規登録</button>

</body>
</html>