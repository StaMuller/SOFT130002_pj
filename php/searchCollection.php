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
$info = $_GET['info'];

echo "<script>window.location.href = ('../collection.php?info={$info}');</script>";
?>