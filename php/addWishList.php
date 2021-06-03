<?php
require_once ("config.php");
try{
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch (PDOException $e){
    die($e->getMessage());
}
?>

<?php
    $artworkID = $_GET['artworkID'];

    $sql2 = "SELECT * FROM wishlist WHERE artworkID = {$artworkID}";
    $result = $pdo->query($sql2)->fetch();
    $added = 0;

    // 还未收藏，可以收藏
    if($result == null){
        $sql = "INSERT INTO wishlist (userID, artworkID) VALUES (1, '{$artworkID}')";
        $pdo->query($sql);
    }

    echo "<script>window.location.href = ('../exhibition.php?artworkID={$artworkID}&&added={$added}');</script>";
?>
