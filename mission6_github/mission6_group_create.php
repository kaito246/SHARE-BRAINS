
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>SHARE BRAINS｜グループ作成</title>

    <style>
    .main{
        float: left;
        width: 53%;
    }
    .sub{
        float: right;
        width: 46%;
        border-left: 1px solid #818181;
        padding-left: 5px;
        position:fixed;
        right:0%;
        border-bottom: 1px solid #818181;
        padding-bottom: 10px;
    }
    .title{
        border-left : 8px solid steelblue;
        padding-left : 10px;
    }
    .error{
        color : red;
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
        $create = $_POST["create"];
        $userid = $_POST["userid"];
        $add = $_POST["add"];
        $serch = $_POST["serch"];
        $username = $_POST["username"];
        $groupname = $_POST["groupname"];
        $goname = $_POST["goname"];
        $invite = $_POST["invite"];

        if(isset($goname)){
            if($groupname==NULL){
                $miss1 = "グループ名を入力して下さい";
            }else{
                $sql = $pdo -> prepare("INSERT INTO m6_group (groupname, cr_time, createname) VALUES (:groupname, now(), :createname)");
                    $sql -> bindParam(':groupname', $groupname, PDO::PARAM_STR); 
                    $sql -> bindParam(':createname', $s_id, PDO::PARAM_INT); 
                    $sql -> execute();
            }
        }

        
         $sql = "SELECT * FROM m6_group WHERE groupname='$groupname' AND createname='$s_id' order by id desc LIMIT 1";
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row){
                $row_id = $row["id"];
                $row_groupname = $row["groupname"];
            }
        

        if(isset($add)){
            $sql = "SELECT * FROM m6_group_user WHERE groupid='$row_id' AND username='$username'";
            $stmt = $pdo->query($sql);
            $row_count = $stmt -> rowCount();
            if($row_count==0){
                $sql = $pdo -> prepare("INSERT INTO m6_group_user (groupid, username) VALUES (:groupid, :username)");
                    $sql -> bindParam(':groupid', $row_id, PDO::PARAM_INT); 
                    $sql -> bindParam(':username', $username, PDO::PARAM_INT); 
                    $sql -> execute();
            }else{
                $miss2 = "すでに登録されています";
            }
        }

        if(isset($invite)){
            $sql = $pdo -> prepare("INSERT INTO m6_group_user (groupid, username) VALUES (:groupid, :username)");
                $sql -> bindParam(':groupid', $row_id, PDO::PARAM_INT); 
                $sql -> bindParam(':username', $s_id, PDO::PARAM_INT); 
                $sql -> execute();
        }

?>

<!--==============以下、表示部分=============-->

<div class="main">
    <hr><div class="title">参加者一覧</div><hr>
    <?php
        $sql = "SELECT * FROM m6_group_user WHERE groupid='$row_id'";
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row){
                $row_username = $row["username"];
                $sql = "SELECT * FROM m6_login WHERE id='$row_username'";
                    $stmt = $pdo->query($sql);
                    $result2s = $stmt->fetchAll();
                    foreach ($result2s as $row2){
                        //アイコン表示
                        $row_file_0 = $row2["filenum"];                     
                        if($row2['filenum'] == 0){
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
                            echo "名前：".$row2["name"]."、ID：".$row2["userid"]."<br>";    
                    }
            }                                               		        
        ?>
</div>



<div class="sub">

<?php if(isset($invite) || isset($serch) || isset($add)) : ?>

    <hr><div class="title">グループ名</div><hr>
        <br><?php echo $groupname; ?><br><br>
        <form action="" method="post">
            <input type="hidden" name="groupname" value="<?php echo $groupname; ?>">
   
    <hr><div class="title">ID検索</div><hr>
            <input type="text" name="userid"><br><br>
            <input type="submit" name="serch" value="検索">
        <br>
    <hr><div class="title">検索結果</div><hr>
        <?php
            $sql = "SELECT * FROM m6_login WHERE userid='$userid'";
            $stmt = $pdo->prepare($sql);
            $stmt -> execute();

            $row_count = $stmt -> rowCount();

            if($row_count == 1){ 
                $results = $stmt->fetchAll();
                foreach ($results as $row){
                    //アイコン表示
                    $row_file_0 = $row["filenum"];
                    if($row['filenum'] == "0"){
                        $sql = "SELECT * FROM m6_file WHERE id2=63";
                        $stmt = $pdo->query($sql);
                    }else{
                        $sql = "SELECT * FROM m6_file WHERE id2='$row_file_0'";
                        $stmt = $pdo->query($sql);
                    }
                    $result2s = $stmt->fetchAll();
                    foreach($result2s as $row2){
         ?>                               
                        <div class="file_icon">
                            <img src="images/<?php echo $row2['filename'] ; ?>" width="30" height="30">   
                        </div> 
        <?php
                    }
                        //名前表示
                        echo "名前：".$row["name"]."、ID：".$row["userid"];
        ?>
                        
                            <input type="submit" name="add" value="追加" style="width:200px">
                            <input type="hidden" name="username" value="<?php echo $row["id"];?>">
                        </form>
        <?php
                }                                                
		    }else{
                echo "<br>検索結果に一致するものはありません<br>";
            }
            echo $miss2;
        ?>

<?php elseif(isset($goname) && $miss1==NULL) : ?>

    <hr><div class="title">参加者招待</div><hr>
    <form action="" method="post">
        <input type="hidden" name="groupname" value="<?php echo $groupname; ?>"><br><br>
        <input type="submit" name="invite" value="参加者招待">
    </form>

<?php else : ?>
    <hr><div class="title">グループ作成</div><hr>
    <form action="" method="post">
        <?php echo $miss1; echo "　"; ?>
        <input type="text" name="groupname"><br><br>
        <input type="submit" name="goname" value="作成">
    </form>

<?php endif ; ?>

<hr><br>
    <form action="https://tb-220294.tech-base.net/mission6_group.php" method="post">
        <input type="submit" name="createtogroup" value="ホームへ戻る" style="width:200px; height:30px; font-size:15px;">
    <form>
<br><br>
</div>


    
</body>
</html>