<?php
require_once ("config.php");
session_start();
try{
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch (PDOException $e){
    die($e->getMessage());
}
?>

<?php

    $artworkID = $_POST['artworkID'];
    if(isset($_SESSION['userID'])){
        $added = $_POST['added'];
        if($added = 1){
            // 还未收藏，可以收藏
            $sql = "INSERT INTO wishlist (userID, artworkID) VALUES ({$_SESSION['userID']}, {$artworkID})";
            $pdo->query($sql);
            $result = array("message" => "success");
            echo json_encode($result);
        }else{
            $result = array("message" => "added");
            echo json_encode($result);
        }
    }else{
        $result = array("message" => "forbidden");
        echo json_encode($result);
    }

?>
