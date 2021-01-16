<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>SHARE BRAINS｜解説確認ページ</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/css/lightbox.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/js/lightbox.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.4/css/all.css">

    <style>  
    .title{
        border-left : 8px solid steelblue;
        padding-left : 10px;
    }
    .name{
        font-weight : bold;
    }
    .time{
        font-size : 15px;
        color : gray;
    }
    .good{
        font-size : 20px;
        color : red;
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
    .file_icon {
        vertical-align: middle ;
        display: inline-block;
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

    <?php
        error_reporting(E_ALL & ~E_NOTICE); //Noticeを表示させない 
        //DBに接続
        $dsn = 'mysql:dbname=***;host=***';
        $user = '***';
        $password = '***';
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING)); 

        $s_id = $_SESSION["id"];

        $qnum = $_POST["qnum"];
        $anum = $_POST["anum"];
        $good = $_POST["good"];
        $nogood = $_POST["nogood"];
        $toanswer = $_POST["toanswer"];

        if(isset($toanswer)){
            $sql = $pdo -> prepare("UPDATE m6_answer SET readed=1 WHERE qid='$qnum'");
                $sql -> execute();
        }

        if(isset($good)){
            $sql = $pdo -> prepare("UPDATE m6_answer SET good=2 WHERE id='$anum'");
                $sql -> execute();
            $sql = $pdo -> prepare("UPDATE m6_query SET solve=1 WHERE id='$qnum'");
                $sql -> execute();
        }

        if(isset($nogood)){
            $sql = $pdo -> prepare("UPDATE m6_answer SET good=1 WHERE id='$anum'");
                $sql -> execute();
            $sql = $pdo -> prepare("UPDATE m6_query SET solve=0 WHERE id='$qnum'");
                $sql -> execute();
        }
    ?>      

        <hr><div class = "title">質問内容</div><hr>
            <?php
                $sql = "SELECT * FROM m6_query WHERE id='$qnum'";
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                foreach ($results as $row){?>                                    
                    <!--時間表示、教科名、単元名、質問内容表示-->
                    <span class = "time"><?php echo $row['time']."<br>";?></span><?php
                    echo "【".$row["subject"]."】　".$row['unit']."<br>".$row["question"]."<br>"; ?>
                        
                    <!--画像表示-->
                    <?php if($row['filename'] != "noimage") : ?>
                        <a href="images/<?php echo $row['filename'] ; ?>" data-lightbox="<?php echo $row['filename'] ; ?>"><img src="images/<?php echo $row['filename'] ; ?>" width="300" height="300"></a>
                    <?php endif ; ?>                                              
            <?php   
                ;}     
            ?>
   
        <hr><div class = "title">解説一覧</div><hr>
            <?php
                $sql = "SELECT * FROM m6_answer WHERE qid='$qnum' order by id desc";
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                foreach ($results as $row){
                    //アイコン表示
                    $userid = $row['aid'];
                    $sql = "SELECT * FROM m6_login WHERE id=$userid";
                        $stmt = $pdo->query($sql);
                        $result2s = $stmt->fetchAll();
                        foreach ($result2s as $row2){
                            $row_file_0 = $row2["filenum"];
                            if($row2['filenum'] == "0"){
                                $sql = "SELECT * FROM m6_file WHERE id2=63";
                                $stmt = $pdo->query($sql);
                            }else{
                                $sql = "SELECT * FROM m6_file WHERE id2='$row_file_0'";
                                $stmt = $pdo->query($sql);
                            }
                            $result3s = $stmt->fetchAll();
                            foreach ($result3s as $row3){
            ?>                               
                                <div class="file_icon">
                                    <img src="images/<?php echo $row3['filename'] ; ?>" width="30" height="30">   
                                </div>  
            <?php
                            }
                        }

                    //名前表示
                        $userid = $row['aid'];
                        $sql = "SELECT * FROM m6_login WHERE id=$userid";
                            $stmt = $pdo->query($sql);
                            $result2s = $stmt->fetchAll();
                            foreach ($result2s as $row3){?>
                                <span class = "name"><?php echo $row3['name']."　";?></span>
                                <span class = "time"><?php echo $row3['userid']."　";?></span>
            <?php            
                            }                   
            ?>                        
                    <!--時間表示、教科名、単元名、優良解答、質問内容表示-->
                    <span class = "time"><?php echo $row['time'];?></span>
            <?php
                    if($row["good"] == 2){?>
                        <span class = "good"><?php echo "　優良<br>";?></span>
            <?php
                    }else{echo "<br>";}

                    echo $row["answer"]."<br>"; 
            ?>
                        
                    <!--画像表示-->
                    <?php if($row['filename'] != "noimage") : ?>
                        <a href="images/<?php echo $row['filename'] ; ?>" data-lightbox="<?php echo $row['filename'] ; ?>"><img src="images/<?php echo $row['filename'] ; ?>" width="300" height="300"></a>
                    <?php endif ; ?>

                    <br>
            <?php
                    $row_id = $row["id"];
                    $sql = "SELECT * FROM m6_reply WHERE aid='$row_id' AND qnum!='$s_id' AND readed=0";
                    $stmt = $pdo->query($sql);
                    $row_count_read = $stmt -> rowCount();
            ?>

                    <div style="display:inline-flex">
                        <form action = "" method = "post">
                    <?php if($row["good"] == 1) : ?>
                            <input type = "submit" name = "good" value = "優良解答に登録する" style = "width:200px; height:30px; font-size:15px;">　
                    <?php elseif($row["good"] == 2) : ?>
                            <input type = "submit" name = "nogood" value = "優良解答の登録解除" style = "width:200px; height:30px; font-size:15px;">　
                    <?php endif ; ?>
                            <input type = "hidden" name = "anum" value = "<?php echo $row['id']; ?>">
                            <input type = "hidden" name = "qnum" value = "<?php echo $qnum; ?>">
                        </form>
                        <form target="_blank" action = "https://tb-220294.tech-base.net/mission6_main_answer_reply.php" method = "post">
                            <input type = "submit" name= "toreply" value = "返信" style = "width:100px; height:30px; font-size:15px;">
                            <span style = "color:red"><?php if($row_count_read != 0){echo $row_count_read;}?></span>
                            <input type = "hidden" name = "anum" value = "<?php echo $row['id']; ?>">
                            <input type = "hidden" name = "qnum" value = "<?php echo $qnum; ?>">
                        </form>　
                    </div>
                    <hr>
            <?php   
                ;}     
            ?>


    
</body>
</html>