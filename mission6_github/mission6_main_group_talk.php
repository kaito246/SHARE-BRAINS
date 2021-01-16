<?php 
    session_start();
?>
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

<script language="javascript" type="text/javascript">
    function checkA() {
        const a = document.getElementById("a");
        const send = document.getElementById("send");
        if(a.value && a.value.length) {
            send.disabled = false;
        } else {
            send.disabled = true;
        }
    }
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
        error_reporting(E_ALL & ~E_NOTICE); //Noticeを表示させない 
        //DBに接続
        $dsn = 'mysql:dbname=***;host=***';
        $user = '***';
        $password = '***';
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING)); 

        $s_id = $_SESSION["id"];
        $s_groupid = $_SESSION["groupid"];

        $qid = $_POST["qid"];
        $reply = $_POST["reply"];
        $send = $_POST["send"];
        $file_name = $_FILES["file"]["name"];
        $file_tmp = $_FILES['file']['tmp_name'];
        $image = uniqid(mt_rand(), true);//ファイル名をユニーク化
        $image .= '.' . substr(strrchr($file_name, '.'), 1);//アップロードされたファイルの拡張子を取得
        $noimage = "noimage";
        $go = NULL;

        if(isset($send)){               
            $go = "質問送信";
            $sql = $pdo -> prepare("INSERT INTO m6_group_talk (qid, cnum, c, filename, time) VALUES (:qid, :cnum, :c, :filename, now())");
                $sql -> bindParam(':qid', $qid, PDO::PARAM_INT); 
                $sql -> bindParam(':cnum', $s_id, PDO::PARAM_INT); 
                $sql -> bindParam(':c', $reply, PDO::PARAM_STR);
                if(!empty($file_name)){
                    $sql -> bindParam(':filename', $image, PDO::PARAM_STR);
                    move_uploaded_file($file_tmp,'./images/'.$image);//imagesディレクトリにファイル保存
                }else{
                    $sql -> bindParam(':filename', $noimage, PDO::PARAM_STR);
                }
                $sql -> execute();           
        }  
        
    ?>



<!--============以下、表示部分===========-->

<div class="answer">

    <hr><div class = "title">質問</div><hr>
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
            }
        ?>                                           

    <hr><div class = "title">コメント</div><hr>
        <?php
            $sql = "SELECT * FROM m6_group_talk WHERE qid='$qid'";
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
                foreach($results as $row){
                    $cnum = $row["cnum"];
                    $sql = "SELECT * FROM m6_login WHERE id='$cnum'";
                    $stmt = $pdo->query($sql);
                    $result2s = $stmt->fetchAll();
                    foreach($result2s as $row2){
                        //アイコン表示
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
                    

                        //名前表示
        ?>
                        <span class = "name"><?php echo $row2['name']."　";?></span>
                        <span class = "time"><?php echo $row2['userid']."　";?></span>
        <?php
                    }
        ?>                                            
                        <!--時間表示、コメント内容表示-->
                        <span class = "time"><?php echo $row['time']."<br>";?></span>
                        <?php echo $row['c']."<br>"; ?>
                        
                        <!--画像表示-->
                        <?php if($row['filename'] != "noimage") : ?>
                            <a href="images/<?php echo $row['filename'] ; ?>" data-lightbox="<?php echo $row['filename'] ; ?>"><img src="images/<?php echo $row['filename'] ; ?>" width="300" height="300"></a>
                        <?php endif ; ?>    
                        <hr>                                          
        <?php       
                }
        ?>

</div>



<div class="reply">

    <hr><div class = "title">コメント入力</div><hr>
        <form action = "" method = "post" enctype = "multipart/form-data">
            <h3>●コメント入力（必須）</h3>
                <textarea name = "reply" id = "a" rows = "8" cols = "60" oninput="checkA()"><?php if($go == NULL){echo $reply;}?></textarea><br><hr>

            <h3>●画像（任意）</h3>
                <input type = "file" name = "file" accept = "image/*"><br><br><hr>

            内容を確認し、よろしければ送信ボタンを押して下さい<br>
                <input type = "hidden" name = "qid" value = "<?php echo $qid; ?>">
                <button type = "submit" id = "send" name = "send" style = "width:80px;" disabled>送信</button><br>
        </form>

</div>



</body>
</html>