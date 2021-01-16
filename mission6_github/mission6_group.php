<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>SHARE BRAINS｜グループ作成</title>

    <style>
    .title{
        border-left : 8px solid steelblue;
        padding-left : 10px;
    }
    .error{
        color : red;
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
    .file_icon {
        vertical-align: middle ;
        display: inline-block;
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

        $s_id = $_SESSION["id"];


    ?>

<!--==============以下、表示部分=============-->

<hr><div class="title">グループ作成</div><hr>
    <br>
    <form action="https://tb-220294.tech-base.net/mission6_group_create.php" method="post">
        <input type="submit" name="create" value="グループ作成" style="width:200px; height:30px; font-size:15px;">
    <form>
    <br><br>

<hr><div class="title">グループ一覧</div><hr>
    <?php
        $sql = "SELECT * FROM m6_group WHERE createname='$s_id'";
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row){
            $row_id = $row["id"];
            echo "＊".$row["groupname"]."　";
        
    ?>
        <div class="hidden_box">
            <label for="<?php echo 'label'.$row_id;?>">参加者</label>
                <input type="checkbox" id="<?php echo 'label'.$row_id;?>" style = "display:none"/> 
                <div class="hidden_show">
                    <!--非表示ここから-->
                <?php
                    $sql = "SELECT * FROM m6_group_user WHERE groupid='$row_id'";
                    $stmt = $pdo->query($sql);
                    $result2s = $stmt->fetchAll();
                    foreach ($result2s as $row2){
                        $row2_username = $row2["username"];
                    
                        $sql = "SELECT * FROM m6_login WHERE id='$row2_username'";
                        $stmt = $pdo->query($sql);
                        $result3s = $stmt->fetchAll();
                        foreach ($result3s as $row3){
                            //アイコン表示
                            $row_file_0 = $row3["filenum"];
                       
                            if($row3['filenum'] == 0){
                                $sql = "SELECT * FROM m6_file WHERE id2=63";
                                $stmt = $pdo->query($sql);
                            }else{
                                $sql = "SELECT * FROM m6_file WHERE id2='$row_file_0'";
                                $stmt = $pdo->query($sql);
                            }
                            $result4s = $stmt->fetchAll();
                            foreach($result4s as $row4){
     ?>                               
                                <div class="file_icon">
                                    <img src="images/<?php echo $row4['filename'] ; ?>" width="30" height="30">   
                                </div>  
     <?php
                            }
                            //名前表示
                            echo "名前：".$row3["name"]."、ID：".$row3["userid"]."<br>";
                        }
                    }                           
    ?>                       
                    <!--ここまで-->
                </div>
        </div>
        <hr>
    <?php
        }
    ?>
    
</body>
</html>