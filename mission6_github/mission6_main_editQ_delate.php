<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>SHARE BRAINS｜質問編集ページ</title>
    
</head>
<body>

    <?php if(!isset($_SESSION["userid"])) : ?>
        <script language="javascript" type="text/javascript">
            alert('セッションが無効です');
            location.href = "https://tb-220294.tech-base.net/mission6_login.php";
        </script>
    <?php endif ; ?>
        
<h1 style = color:red>質問は削除されました</h1>
    
</body>
</html>