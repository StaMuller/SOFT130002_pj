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
$sql = "DELETE FROM wishlist WHERE artworkID = {$artworkID}";
$pdo->query($sql);

echo "<script>window.location.href = ('../collection.php?artworkID={$artworkID}');</script>";
?>
