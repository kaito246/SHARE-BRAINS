<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ユーザー情報変更｜SHARE BRAINS</title>
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

    $session_id = $_SESSION["id"];
    $pattern = '/^[ァ-ヶｦ-ﾟー]+$/u';
    $pattern2 = '/^[a-zA-Z0-9._]{5,20}$/';
    $name = $_POST["name"];
    $name2 = $_POST["name2"];
    $userid = $_POST["userid"];
    $filenum = $_POST["filenum"];
    $send = $_POST["send"];

    if(isset($send)){
        if($name == NULL){
            $miss1 = "※お名前をご入力下さい";
        }

        if($name2 == NULL){
            $miss2 = "※お名前をご入力下さい";
        }elseif(!preg_match($pattern,$name2)){
            $miss3 = "※カタカナで入力してください";
        }

        if($userid == NULL){
            $miss4 = "※ユーザーIDをご入力下さい";
        }elseif(!preg_match($pattern2,$userid)){
            $miss5 = "※不正な形式のユーザーIDです";
        }

        $sql = 'SELECT * FROM m6_login';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach($results as $row){
            if($userid == $row['userid'] && $userid != NULL && preg_match($pattern2,$userid)){
                $sql = "SELECT * FROM m6_login WHERE id='$session_id'";
                $stmt = $pdo->query($sql);
                $result2s = $stmt->fetchAll();
                foreach($result2s as $row2){
                    if($userid != $row2["userid"]){
                        $miss6 = "※すでに登録されたユーザーIDです";
                    }
                }
            }else{
                $c = "くりあ";
            }
        }

        if($miss1 == NULL && $miss2 == NULL && $miss3 == NULL && $miss4 == NULL && $miss5 == NULL && $miss6 == NULL && $c == "くりあ"){
            $go = "質問送信";
            $sql = $pdo -> prepare("UPDATE m6_login SET name=:name, name2=:name2, userid=:userid, filenum=:filenum, updated_at=now() WHERE id='$session_id'" );                       
                $sql -> bindParam(':name', $name, PDO::PARAM_STR); 
                $sql -> bindParam(':name2', $name2, PDO::PARAM_STR); 
                $sql -> bindParam(':userid', $userid, PDO::PARAM_STR); 
                $sql -> bindParam(':filenum', $filenum, PDO::PARAM_INT); 
                $sql -> execute();
        }       
    }
    
    ?>


    <!--=======================表示画面==================-->

<?php if($go != NULL) : ?>
    <h1 style="color:red">ユーザー情報は更新されました</h1>
    <form action = "https://tb-220294.tech-base.net/mission6_main2.php" method = post>
        <input type = "submit" name = "editlogtomain" value = "メインメニューへ戻る>>">
    </form>

<?php else : ?>
    
    <?php 
        $sql = "SELECT * FROM m6_login WHERE id='$session_id'";
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row){
    ?>

    <form action = "" method = post>

    <div class = "title"><h3>氏名</h3></div>
        <input type = "text" name = "name" placeholder = "山田太郎" value = "<?php if(isset($send)){echo $name;}else{echo $row['name'];}?>"><br>
        <div class = "error"><?php echo $miss1; echo "　";?><br></div>

    <div class = "title"><h3>氏名カナ</h3></div>
        <input type = "text" name = "name2" placeholder = "ヤマダタロウ" value = "<?php if(isset($send)){echo $name2;}else{echo $row['name2'];} ?>"><br>
    <div class = "error"><?php echo $miss2; echo $miss3; echo "　";?><br></div>

    <div class = "title"><h3>ユーザーID</h3></div>
        <input type = "text" name = "userid" style = "width:200px;" value = "<?php if(isset($send)){echo $userid;}else{echo $row['userid'];} ?>">　（5~20文字で半角英数字,ピリオド,アンダーバーのみです）
    <div class = "error"><?php echo $miss4; echo $miss9; echo $miss5; echo $miss6; echo "　";?><br></div>

    <div class = "title"><h3>アイコン画像</h3></div>     
        <label><input type = "radio" name = "filenum" value = "1" <?php if(isset($send) && $filenum == 1 || !isset($send) && $row["filenum"] == 1){echo "checked";} ?>><img src="3.png" style="width:150px;height:150px;"></label>
        <label><input type = "radio" name = "filenum" value = "6" <?php if(isset($send) && $filenum == 6 || !isset($send) && $row["filenum"] == 6){echo "checked";} ?>><img src="8.png" style="width:150px;height:150px;"></label>
        <label><input type = "radio" name = "filenum" value = "11" <?php if(isset($send) && $filenum == 11 || !isset($send) && $row["filenum"] == 11){echo "checked";} ?>><img src="13.png" style="width:150px;height:150px;"></label>
        <label><input type = "radio" name = "filenum" value = "16" <?php if(isset($send) && $filenum == 16 || !isset($send) && $row["filenum"] == 16){echo "checked";} ?>><img src="18.png" style="width:150px;height:150px;"></label>
        <label><input type = "radio" name = "filenum" value = "21" <?php if(isset($send) && $filenum == 21 || !isset($send) && $row["filenum"] == 21){echo "checked";} ?>><img src="23.png" style="width:150px;height:150px;"></label>
        <label><input type = "radio" name = "filenum" value = "26" <?php if(isset($send) && $filenum == 26 || !isset($send) && $row["filenum"] == 26){echo "checked";} ?>><img src="28.png" style="width:150px;height:150px;"></label><br>
        <label><input type = "radio" name = "filenum" value = "31" <?php if(isset($send) && $filenum == 31 || !isset($send) && $row["filenum"] == 31){echo "checked";} ?>><img src="33.png" style="width:150px;height:150px;"></label>
        <label><input type = "radio" name = "filenum" value = "36" <?php if(isset($send) && $filenum == 36 || !isset($send) && $row["filenum"] == 36){echo "checked";} ?>><img src="38.png" style="width:150px;height:150px;"></label>
        <label><input type = "radio" name = "filenum" value = "41" <?php if(isset($send) && $filenum == 41 || !isset($send) && $row["filenum"] == 41){echo "checked";} ?>><img src="43.png" style="width:150px;height:150px;"></label>
        <label><input type = "radio" name = "filenum" value = "46" <?php if(isset($send) && $filenum == 46 || !isset($send) && $row["filenum"] == 46){echo "checked";} ?>><img src="48.png" style="width:150px;height:150px;"></label>
        <label><input type = "radio" name = "filenum" value = "51" <?php if(isset($send) && $filenum == 51 || !isset($send) && $row["filenum"] == 51){echo "checked";} ?>><img src="53.png" style="width:150px;height:150px;"></label>
        <label><input type = "radio" name = "filenum" value = "56" <?php if(isset($send) && $filenum == 56 || !isset($send) && $row["filenum"] == 56){echo "checked";} ?>><img src="58.png" style="width:150px;height:150px;"></label><br><br><br>
        <label><input type = "radio" name = "filenum" value = "0" <?php if(isset($send) && $filenum == 0 || !isset($send) && $row["filenum"] == 0){echo "checked";} ?>>No Image</label><br><br>


        <hr style = "border:0.5px dashed silver">
    <div style="display:inline-flex">
        <input type = "submit" name = "send" value = "送信" style = "width:120px; background-color:steelblue; color:white;">　
    </form>
    <form action = "https://tb-220294.tech-base.net/mission6_main2.php" method = post>
        <input type = "submit" name = "editlogtomain" value = "メインメニューへ戻る>>">
    </form>
    </div>

    <?php
        }
    ?>

<?php endif ; ?>

    
</body>
</html>