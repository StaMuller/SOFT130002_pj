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

    $confirm = $_POST['confirm'];
    if($confirm == "username") {
        if(!username($_POST["username"])){
            echo "<p style='color: red; font-family: \"Times New Roman\"; margin: 0'>username exists</p>";
        }
    }else if($confirm == "password"){
        if(!password($_POST["password"])){
            echo "<p style='color: red; font-family: \"Times New Roman\"; margin: 0'>
                    password must be 8-16 long including both numbers and letters
                  </p>";
        }
    }else if($confirm == "passwordConfirm"){
        if(!passwordConfirm($_POST["password"], $_POST["passwordConfirm"])){
            echo "<p style='color: red; font-family: \"Times New Roman\"; margin: 0'>
                    password and password confirmation is unmatched.
                  </p>";
        }
    }else if($confirm == "create") {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $passwordConfirm = $_POST["passwordConfirm"];
        $email = $_POST["email"];
        $tel = $_POST["tel"];
        $address = $_POST["address"];

        // 最后检验信息
        if(!username($username) || !password($password) || !passwordConfirm($password, $passwordConfirm)
            || $username == "" || $password == "" || $passwordConfirm == ""){
            echo "<p style='color: red; font-family: \"Times New Roman\"; margin: 0'>some invalid information</p>";
        } else{
            $sql = "INSERT INTO users (`name`, email, password, tel, address) VALUES ('{$username}', '{$email}', '{$password}', '{$tel}', '{$address}')";
            $pdo->query($sql);
            echo "<script type='text/javascript'>
                    window.alert(\"REGISTER SUCCESSFULLY!\");
                    window.location.href = ('./index.php');
                  </script>";
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

