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

    $confirm = $_POST["confirm"];
    if($confirm == "username") {
        if(!username($_POST["username"])){
            $result = array("message" => "username exists");
            echo json_encode($result);
        }else{
            $result = array("message" => "");
            echo json_encode($result);
        }
    }else if($confirm == "submit") {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $passwordConfirm = $_POST["passwordConfirm"];
        $email = $_POST["email"];
        $tel = $_POST["tel"];
        $address = $_POST["address"];

        // 最后检验信息
        if(!username($username) || !password($password) || !passwordConfirm($password, $passwordConfirm)
            || $username == "" || $password == "" || $passwordConfirm == ""){
            $result = array("message" => "fail");
            echo json_encode($result);
        } else{
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
            $sql = "INSERT INTO users (`name`, email, password, tel, address) VALUES ('{$username}', '{$email}', '{$password}', '{$tel}', '{$address}')";
            $pdo->query($sql);
            $result = array("message" => "succeed");
            echo json_encode($result);
        }
    }

    function username($username){
        try{
            $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM users WHERE `name` = \"{$username}\"";
            if ($pdo->query($sql)->fetch()) {
                return false;
            }else{
                return true;
            }
        }catch (PDOException $e){
            die($e->getMessage());
        }
    }

    function password($password){
        if(!preg_match('/^(?=.*\d)(?=.*[a-zA-Z])[\dA-Za-z]{8,16}$/', $password)){
            return false;
        }else{
            return true;
        }
    }

    function passwordConfirm($password, $passwordConfirm){
        if($password != $passwordConfirm){
            return false;
        }else{
            return true;
        }
    }
?>

