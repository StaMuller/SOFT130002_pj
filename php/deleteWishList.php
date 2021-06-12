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
$artworkID = $_GET['artworkID'];
$info = $_GET['info'];
$sql = "DELETE FROM wishlist WHERE artworkID = {$artworkID}";
$pdo->query($sql);

echo "<script>window.location.href = ('../collection.php?info={$info}');</script>";
?>
