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
    $condition = $_GET['condition'];
    // 通过名称、简介、作者名进行搜索

    echo "<script>window.location.href = ('../search.php?info={$info}&condition={$condition}&currentPage=1');</script>";
?>