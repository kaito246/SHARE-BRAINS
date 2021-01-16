<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>SHARE BRAINS｜返信ページ</title>

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
        color : gray
    }
    .error{
        color : red;
    }
    .answer{
        float: left;
        width: 63%;
    }
    .reply{
        float: right;
        width: 36%;
        border-left: 1px solid #818181;
        padding-left: 5px;
        position:fixed;
        right:0%;
        border-bottom: 1px solid #818181;
        padding-bottom: 10px;
    }
    #page_top{
        width: 90px;
        height: 90px;
        position: fixed;
        right: 27%;
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

        $aid = $_POST["anum"];
        $qid = $_POST["qnum"];
        $reply1 = $_POST["reply1"];
        $reply2 = $_POST["reply2"];
        $send = $_POST["send"];
        $file_name = $_FILES["file"]["name"];
        $file_tmp = $_FILES['file']['tmp_name'];
        $image = uniqid(mt_rand(), true);//ファイル名をユニーク化
        $image .= '.' . substr(strrchr($file_name, '.'), 1);//アップロードされたファイルの拡張子を取得
        $noimage = "noimage";
        $go = NULL;

        $sql = "SELECT * FROM m6_answer WHERE id='$aid'";
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row){
                $anum = $row["aid"];
            }

        $sql = "SELECT * FROM m6_query WHERE id='$qid'";
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row){
                $qnum = $row["userid"];
            }

        if(isset($_POST["toreply"])){
            $sql = $pdo -> prepare("UPDATE m6_reply SET readed=1 WHERE aid='$aid'");
                $sql -> execute();
        }

        if(isset($send)){
            if($reply1 != "no" || $reply2 != NULL){      
                $go = "質問送信";
                $sql = $pdo -> prepare("INSERT INTO m6_reply (qid, aid, anum, qnum, reply1, reply2, filename, time, readed) VALUES (:qid, :aid, :anum, :qnum, :reply1, :reply2, :filename, now(), 0)");
                    $sql -> bindParam(':qid', $qid, PDO::PARAM_INT); 
                    $sql -> bindParam(':aid', $aid, PDO::PARAM_INT); 
                    $sql -> bindParam(':anum', $anum, PDO::PARAM_INT);
                    $sql -> bindParam(':qnum', $qnum, PDO::PARAM_INT);
                    $sql -> bindParam(':reply1', $reply1, PDO::PARAM_STR);
                    $sql -> bindParam(':reply2', $reply2, PDO::PARAM_STR);
                    if(!empty($file_name)){
                        $sql -> bindParam(':filename', $image, PDO::PARAM_STR);
                        move_uploaded_file($file_tmp,'./images/'.$image);//imagesディレクトリにファイル保存
                    }else{
                        $sql -> bindParam(':filename', $noimage, PDO::PARAM_STR);
                    }
                    $sql -> execute();
            }else{
                $miss1 = "※送信内容を入力して下さい";
            }
            if(!empty($file_name)){
                $miss2 = "※改めて画像ファイルを選択して下さい";
            }
        }
    ?>



<!--==========表示部分==========-->

    <div class="answer">

    <hr><div class = "title">質問内容</div><hr>
        <?php
            $sql = "SELECT * FROM m6_query WHERE id='$qid'";
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row){
                //アイコン表示
                $userid = $row['userid'];
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
                    $sql = "SELECT * FROM m6_login WHERE id=$userid";
                        $stmt = $pdo->query($sql);
                        $result2s = $stmt->fetchAll();
                        foreach ($result2s as $row3){?>
                            <span class = "name"><?php echo $row3['name']."　";?></span>
                            <span class = "time"><?php echo $row3['userid']."　";?></span>
        <?php            
                        }                   
        ?>                                                           
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

    <hr><div class = "title">解答</div><hr>
        <?php
            $sql = "SELECT * FROM m6_answer WHERE id='$aid'";
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row){
                //アイコン表示
                $userid = $row['aid'];
                $aid_rep = $row['id'];
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
                <!--時間表示、教科名、単元名、質問内容表示-->
                <span class = "time"><?php echo $row['time']."<br>";?></span><?php
                echo $row["answer"]."<br>"; ?>
                        
                <!--画像表示-->
                <?php if($row['filename'] != "noimage") : ?>
                    <a href="images/<?php echo $row['filename'] ; ?>" data-lightbox="<?php echo $row['filename'] ; ?>"><img src="images/<?php echo $row['filename'] ; ?>" width="300" height="300"></a>
                <?php endif ; ?>
                <br>
        <?php   
            ;}     
        ?>

    <hr><div class = "title">返信一覧</div><hr>
        <?php
            $sql = "SELECT * FROM m6_reply WHERE aid='$aid_rep'";
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row){
                //アイコン表示
                $userid = $row['qnum'];
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
                    $sql = "SELECT * FROM m6_login WHERE id=$userid";
                        $stmt = $pdo->query($sql);
                        $result2s = $stmt->fetchAll();
                        foreach ($result2s as $row3){?>
                            <span class = "name"><?php echo $row3['name']."　";?></span>
                            <span class = "time"><?php echo $row3['userid']."　";?></span>
        <?php            
                        }                   
        ?>                        
                <!--時間表示、返信内容表示-->
                <span class = "time"><?php echo $row['time']."<br>";?></span>
        <?php    
                if($row["reply1"] == "thank"){
                    $row_reply1 = "【ありがとうございます！】<br>";
                }elseif($row["reply1"] == "nothank"){
                    $row_reply1 = "質問があります。<br>";
                }
                echo $row_reply1.$row["reply2"]."<br>"; ?>
                        
                <!--画像表示-->
                <?php if($row['filename'] != "noimage") : ?>
                    <a href="images/<?php echo $row['filename'] ; ?>" data-lightbox="<?php echo $row['filename'] ; ?>"><img src="images/<?php echo $row['filename'] ; ?>" width="300" height="300"></a>
                <?php endif ; ?>
                <br><hr>
        <?php   
            ;}     
        ?>
        

    </div>



    <div class="reply">

    <?php if($miss1 != NULL) : ?>
        <h1 style = color:red>正常に返信されませんでした</h1>
    <?php elseif($miss1 == NULL && $go != NULL) : ?>
        <h1 style = color:red>正常に返信されました</h1>
    <?php endif ; ?>

    <hr><div class = "title">返信</div><hr>
        <form method = "POST" action = "" enctype = "multipart/form-data">
            <select name = "reply1">
                <option value = "no" <?php if($reply1 == "no"){echo "selected";} ?>>　</option>
                <option value = "thank" <?php if($reply1 == "thank"){echo "selected";} ?>>ありがとうございます！</option>
                <option value = "nothank" <?php if($reply1 == "nothank"){echo "selected";} ?>>質問があります</option>
            </select>
            <br>
            <textarea name = "reply2" rows = "8" cols = "60"><?php if($go == NULL){echo $reply2;}?></textarea><br><hr>
            <br><input type = "file" name = "file" accept = "image/*"><div class = "error"><?php if($go == NULL){echo $miss2 ;} echo "　"; ?></div><hr>
            <input type = "submit"  name = "send" value = "送信"><div class = "error"><?php echo $miss1 ;?></div>
            <input type = "hidden" name = "anum" value = "<?php echo $aid; ?>">
            <input type = "hidden" name = "qnum" value = "<?php echo $qid; ?>">
        </form>

    </div>



</body>
</html>