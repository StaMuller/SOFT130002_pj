<?php session_start(); ?>
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
    $username = $_POST['username'];
    $password = $_POST['password'];
    if($username == "" || $password == ""){
        $result = array("message" => "empty");
        echo json_encode($result);
    }else {
        $sql = "SELECT * FROM users WHERE `name` = \"{$username}\"";
        if($pdo->query($sql)->fetch()){
            $sql = "SELECT * FROM users WHERE `name` = \"{$username}\" AND password = \"{$password}\"";
            if($user = $pdo->query($sql)->fetch()){
                $_SESSION['username'] = $username;
                $_SESSION['password'] = $password;
                $_SESSION['userID'] = $user['userID'];
                $result = array("message" => "pass");
                echo json_encode($result);
                return;
            }
        }
        $result = array("message" => "wrong");
        echo json_encode($result);
    }
?>
