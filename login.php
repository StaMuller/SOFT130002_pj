<?php session_start(); ?>
<?php
require_once ("./php/config.php");
$page = $_SESSION['page'];
array_push($page, "Login");
$_SESSION['page'] = $page;
?>
<!DOCTYPE html>
<html lang="en">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<head>
    <meta charset="UTF-8">
    <title>
        Sign In
    </title>
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
    <!-- 登录监听 -->
    <script type="text/javascript">
        $(document).ready(function (){
            $("#submit").focus(function (){
                if($("#username").val() === ""){
                    $("#usernameHint").html("<p style='color: red; font-family: \"Times New Roman\"; margin: 0'>username cannot be empty</p>");
                }else {
                    $("#usernameHint").html(null);
                }
                if($("#password").val() === ""){
                    $("#passwordHint").html("<p style='color: red; font-family: \"Times New Roman\"; margin: 0'>password cannot be empty</p>");
                }else{
                    $("#passwordHint").html(null);
                }
                $.ajax({
                    url: "php/loginConfirm.php",
                    type: "POST",
                    data: "&username=" + $("#username").val()
                        + "&password=" + $("#password").val(),
                    dataType: "json",
                    success:function (msg){
                        if(msg.message === "empty") {
                            $("#submitHint").html(
                                "<p style='color: red; font-family: \"Times New Roman\"; margin: 0'>" +
                                    "information can not be empty" +
                                "</p>");
                        }else if(msg.message === "wrong"){
                            $("#submitHint").html(
                                "<p style='color: red; font-family: \"Times New Roman\"; margin: 0'> " +
                                    "USERNAME OR PASSWORD MAY BE INCORRECT" +
                                "</p>"
                            )
                        }else if(msg.message === "pass"){
                            $("#submitHint").html(
                                "<p style='color: #146c43; font-family: \"Times New Roman\"; margin: 0'> " +
                                    "LOGIN SUCCESSFULLY<br>" +
                                    "Jump to previous page immediately" +
                                "</p>"
                            )
                            let time = 1;
                            setInterval(jump, 1000);
                            function jump(){
                                if(time === 0){
                                    if(sessionStorage.getItem('prev')){
                                        window.location.href = sessionStorage.getItem('prev');
                                    }else{
                                        window.location.href = ('index.php');
                                    }
                                }
                                time--;
                            }
                        }
                    }
                })
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
        trackShow("Login");
        ?>
    <!------------------------------------------------------------------------------------------>
    <h2 align="center" id="slogan">
        Enter Your Art World Here
    </h2>

    <div class="user">
        <form style="text-align: center">
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
            <input type="button" id="submit" value="LOG IN" class="button">
            <span id="submitHint"></span>
            <br>
            <a href="register.php" class="change">
                <b>CREAT ACCOUNT</b>
            </a>
        </form>
    </div>
    </div>

    <div id="myFooter">
        @ArtStore.Produced and maintained by Achillessanger at 2018.4.1 All Right Reserved
    </div>
</body>
</html>