<?php session_start(); ?>
<?php
require_once ("./php/config.php");
$page = $_SESSION['page'];
array_push($page, "Register");
$_SESSION['page'] = $page;
?>
<!DOCTYPE html>
<html lang="en">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" type="text/css" href="css/general.css">
    <link rel="stylesheet" type="text/css" href="css/user.css">
    <script type="text/javascript" src="bootstrap/js/jquery.js"></script>
    <!-- 登出操作 -->
    <script type="text/javascript">
        $(document).ready(function (){
            $("#logout").focus(function (){
                $.ajax({
                    url: "php/logout.php",
                })
            })
        })
    </script>
    <!-- 注册监听 -->
    <script type="text/javascript">
        $(document).ready(function (){
            $("#email").blur(function (){
                if($(this).val() !== ""){
                    $(this).css("background-color", "#E8F0FE");
                }else{
                    $(this).css("background-color", "white");
                }
            })
            $("#tel").blur(function (){
                if($(this).val() !== ""){
                    $(this).css("background-color", "#E8F0FE");
                }else{
                    $(this).css("background-color", "white");
                }
            })
            $("#address").blur(function (){
                if($(this).val() !== ""){
                    $(this).css("background-color", "#E8F0FE");
                }else{
                    $(this).css("background-color", "white");
                }
            })
            $("#username").blur(function (){
                if($(this).val() !== ""){
                    $(this).css("background-color", "#E8F0FE");
                }else{
                    $(this).css("background-color", "white");
                }
                $.ajax({
                    url: "php/registerConfirm.php",
                    type: "POST",
                    data: "confirm=username"
                        + "&username=" + $(this).val(),
                    dataType: "json",
                    success:function (msg){
                        if(msg.message === "username exists") {
                            $("#usernameHint").html(
                                "<p style='color: red; font-family: \"Times New Roman\"; margin: 0'>" +
                                    "username exists" +
                                "</p>");
                        }else{
                            $("#usernameHint").html(null);
                        }
                    }
                })
            });
            $("#password").blur(function (){
                if($(this).val() !== ""){
                    $(this).css("background-color", "#E8F0FE");
                }else{
                    $(this).css("background-color", "white");
                }
                const test = /^(?=.*\d)(?=.*[a-zA-Z])[\dA-Za-z]{8,16}$/;
                if(!test.test($(this).val())){
                    $("#passwordHint").html(
                        "<p style='color: red; font-family: \"Times New Roman\"; margin: 0'>" +
                            "password must be 8-16 long including both numbers and letters" +
                        "</p>");
                }else{
                    $("#passwordHint").html(null);
                }
            });
            $("#passwordConfirm").blur(function (){
                if($(this).val() !== ""){
                    $(this).css("background-color", "#E8F0FE");
                }else{
                    $(this).css("background-color", "white");
                }
                if($(this).val() !== $("#password").val()){
                    $("#passwordConfirmHint").html(
                        "<p style='color: red; font-family: \"Times New Roman\"; margin: 0'>" +
                            "password and confirmation are unmatched" +
                        "</p>");
                }else{
                    $("#passwordConfirmHint").html(null);
                }
            });
            $("#submit").focus(function (){
                if($("#username").val() === ""){
                    $("#usernameHint").html("<p style='color: red; font-family: \"Times New Roman\"; margin: 0'>username cannot be empty</p>");
                    return;
                }else if($("#password").val() === ""){
                    $("#passwordHint").html("<p style='color: red; font-family: \"Times New Roman\"; margin: 0'>password cannot be empty</p>");
                    return;
                }else if($("#passwordConfirm").val() === ""){
                    $("#passwordConfirmHint").html("<p style='color: red; font-family: \"Times New Roman\"; margin: 0'>password confirmation cannot be empty</p>");
                    return;
                }else {
                    $.ajax({
                        url: "php/registerConfirm.php",
                        type: "POST",
                        data: "confirm=submit"
                            + "&username=" + $("#username").val()
                            + "&password=" + $("#password").val()
                            + "&passwordConfirm=" + $("#passwordConfirm").val()
                            + "&email=" + $("#email").val()
                            + "&tel=" + $("#tel").val()
                            + "&address=" + $("#address").val(),
                        dataType: "json",
                        success: function (msg) {
                            if (msg.message === "succeed") {
                                $("#submitHint").html(
                                    "<p style='color: #146c43; font-family: \"Times New Roman\"; margin: 0'> " +
                                    "REGISTER SUCCESSFULLY<br>" +
                                    "Jump to home page immediately" +
                                    "</p>"
                                )
                                let time = 1;
                                setInterval(jump, 1000);

                                function jump() {
                                    if (time === 0) {
                                        window.location.href = ('index.php');
                                    }
                                    time--;
                                }
                            } else if (msg.message === "fail") {
                                $("#submitHint").html(
                                    "<p style='color: red; font-family: \"Times New Roman\"; margin: 0'>" +
                                    "some invalid information" +
                                    "</p>");
                            }

                        }
                    })
                }
            });
        })
    </script>
</head>
<body>
    <div id="container">
    <div class="header">
        <?php
        if(isset($_SESSION['username']) && isset($_SESSION['password'])){
            echo '<a href="collection.php?info=0"><img src="resources/img/user.png" id="myAccount"></a>';
            echo '<h1 class="title">Art World</h1>';
            echo '<h3 class="title" style="font-size: 20px; color: #664d03">'
                . $_SESSION['username']
                .', enjoy your art world!</h3>';
        }else{
            echo '<a href="login.php"><img src="resources/img/user.png" id="myAccount"></a>';
            echo '<h1 class="title">Art World</h1>';
            echo '<script>sessionStorage.setItem(\'prev\', window.location.href)</script>';
        }
        ?>
        <p class="slogan">
            Art is never abstruse.<br>
            She is just the emotional transmission of artists.
        </p>
    </div>
        <div>                                              <!--logo与标语-->
            <ul>
                <li><a href="register.php" class="navigation">
                    Register
                </a></li>
                <?php
                if(isset($_SESSION['username']) && isset($_SESSION['password'])){
                    echo '<li><a id="logout" href="index.php" class="navigation"">LOGOUT</a></li>';
                }else{
                    echo '<li><a href="login.php" class="navigation">Login</a></li>';
                    echo '<script>sessionStorage.setItem(\'prev\', window.location.href)</script>';
                }
                ?>
                <li><a href="search.php?info=0&condition=view&currentPage=1" class="navigation">
                    Search
                </a></li>
                <li><a class="navigation" href="index.php">
                    HomePage
                </a></li>
            </ul>
        </div>
        <br>
        <!-- 足迹栏部分 -->
        <?php
        require_once ("./php/track.php");
        trackShow("Register");
        ?>
    <!------------------------------------------------------------------------------------------>
    <h2 align="center" id="slogan">
        Sign Up For Your New Account.
    </h2>

    <div class="user">
        <form style="text-align: center" name="registerForm">
            <label for="username" class="label">
                Username
            </label>
            <input type="text" name="username" id="username" placeholder="Your name...">
            <span id="usernameHint"></span>
            <br>
            <label for="password" class="label">
                Password
            </label>
            <input type="password" name="password" id="password" placeholder="Your password...">
            <span id="passwordHint"></span>
            <br>
            <label for="passwordConfirm" class="label">
                Confirm Password
            </label>
            <input type="password" name="passwordConfirm" id="passwordConfirm" placeholder="Confirm your password...">
            <span id="passwordConfirmHint"></span>
            <br>
            <label for="email" class="label">
                Email
            </label>
            <input type="text" name="email" id="email" placeholder="Your email...">
            <br>
            <label for="tel" class="label">
                Tel
            </label>
            <input type="text" name="tel" id="tel" placeholder="Your telephone...">
            <br>
            <label for="address" class="label">
                Address
            </label>
            <input type="text" name="address" id="address" placeholder="Your address...">
            <input type="button" id="submit" value="CREATE MY ACCOUNT" class="button">
            <span id="submitHint"></span>
            <br>
            <a href="login.php" class="change">
                <b>GO TO LOGIN</b>
            </a>
        </form>
    </div>
    </div>
    <br>
    <br>
    <div id="myFooter">
        @ArtStore.Produced and maintained by Achillessanger at 2018.4.1 All Right Reserved
    </div>
</body>
</html>