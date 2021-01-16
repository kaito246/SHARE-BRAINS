<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>解答一覧｜SHARE BRAINS</title>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.4/css/all.css">

    <style>
    .title{
        border-left : 8px solid steelblue;
        padding-left : 10px;
    }
    .good{
        font-size : 20px;
        color : red;
    }
    .time{
        font-size : 15px;
        color : gray
    }
    .hidden_box{
        margin: 1em 0;
        padding: 0;
    }
    .hidden_box label {
        padding: 5px;
        font-size: 15px;
        background: #EEEEEE;
        border: solid 1px black;
        cursor :pointer;
        transition: .5s;
    }
    .hidden_box label:hover {
        background: #DDDDDD;
    }
    .hidden_box .hidden_show {
        height: 0;
        padding: 0;
        overflow: hidden;
        opacity: 0;
        transition: 0.8s;
    }
    .hidden_box input:checked ~ .hidden_show {
        padding: 10px 0;
        height: auto;
        opacity: 1;
    }
    #page_top{
        width: 90px;
        height: 90px;
        position: fixed;
        right: 5%;
        bottom: 0;
        opacity: 0.6;
    }
    #page_top a{
        position: relative;
        display: block;
        width: 90px;
        height: 90px;
        text-decoration: none;
    }
    #page_top a::before{
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        content: '\f102';
        font-size: 25px;
        color: steelblue;
        position: absolute;
        width: 25px;
        height: 25px;
        top: -40px;
        bottom: 0;
        right: 0;
        left: 0;
        margin: auto;
        text-align: center;
    }
    #page_top a::after{
        content: 'PAGE TOP';
        font-size: 13px;
        color: #fff;
        position: absolute;
        top: 45px;
        bottom: 0;
        right: 0;
        left: 0;
        margin: auto;
        text-align: center;
        color: steelblue;
    }
    </style>

<script language="javascript" type="text/javascript">
    //トップへとぶボタンの作成-----------------
    jQuery(function() {
        var pagetop = $('#page_top');   
        pagetop.hide();
        $(window).scroll(function () {
            if($(this).scrollTop() > 200) {  //200pxスクロールしたら表示
                pagetop.fadeIn();
            }else{
                pagetop.fadeOut();
            }
        });
        pagetop.click(function () {
            $('body,html').animate({
                scrollTop: 0
            }, 500); //0.5秒かけてトップへ移動
            return false;
        });
    });
</script>
    
</head>
<body>

<div id="page_top"><a href="#"></a></div>

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


?>


<!--=====================以下、表示部分=================-->

    <hr><div class = "title">解説一覧</div><hr>
        <?php
            $sql = "SELECT * FROM m6_answer WHERE aid='$session_id'";
            $stmt = $pdo->query($sql);
            $result0s = $stmt->fetchAll();
            foreach ($result0s as $row0){
        ?>
                <!--時間表示、優良解答、解答内容表示-->
                <span class = "time"><?php echo $row0['time'];?></span>
            <?php
                if($row0["good"] == 2){?>
                    <span class = "good"><?php echo "　優良<br>";?></span>
            <?php
                }else{echo "<br>";}

                echo $row0["answer"]."<br>";
            ?>
                        
                <!--画像表示-->
            <?php if($row0['filename'] != "noimage") : ?>
                <a href="images/<?php echo $row0['filename'] ; ?>" data-lightbox="<?php echo $row0['filename'] ; ?>"><img src="images/<?php echo $row0['filename'] ; ?>" width="300" height="300"></a>
            <?php endif ; ?>
            <br>
            <?php
                $row0_aid = $row0["id"];
                $sql = "SELECT * FROM m6_reply WHERE anum='$session_id' AND qnum!='$session_id' AND readed=0 AND aid='$row0_aid'";
                $stmt = $pdo->query($sql);
                $row_count_read = $stmt -> rowCount();
            ?>
            <form target="_blank" action = "https://tb-220294.tech-base.net/mission6_main_answer_reply.php" method = "post">
                <input type = "submit" name = "toreply" value = "返信" style = "width:100px; height:30px; font-size:15px;">　
                <input type = "hidden" name = "anum" value = "<?php echo $row0['id']; ?>">
                <input type = "hidden" name = "qnum" value = "<?php echo $row0['qid']; ?>">
                <span style="color:red"><?php if($row_count_read != 0){echo $row_count_read;} ?></span>
            </form>
            <hr>  
        <?php                    
            }
        ?>



    
</body>
</html>