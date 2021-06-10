<!DOCTYPE html>
<html lang="en">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" type="text/css" href="css/general.css">
    <link rel="stylesheet" type="text/css" href="css/user.css">
    <script type="text/javascript" src="bootstrap/js/jquery.js"></script>
    <script type="text/javascript" src="JavaScript/general.js"></script>
    <!-- 注册监听 -->
    <script type="text/javascript">
        $(document).ready(function (){
            $("#username").blur(function (){
                $(this).css("background-color", "#E8F0FE");
                $.ajax({
                    url: "php/registerConfirm.php",
                    type: "POST",
                    data: "confirm=username"
                        + "&username=" + $(this).val(),
                    success:function (msg){
                        $("#usernameHint").html(msg);
                    }
                })
            });
            $("#password").blur(function (){
                $(this).css("background-color", "#E8F0FE");
                $.ajax({
                    url: "php/registerConfirm.php",
                    type: "POST",
                    data: "confirm=password"
                        + "&password=" + $(this).val(),
                    success:function (msg){
                        $("#passwordHint").html(msg);
                    }
                })
            });
            $("#passwordConfirm").blur(function (){
                $(this).css("background-color", "#E8F0FE");
                $.ajax({
                    url: "php/registerConfirm.php",
                    type: "POST",
                    data: "confirm=passwordConfirm"
                        + "&passwordConfirm=" + $(this).val()
                        + "&password=" + $("#password").val(),
                    success:function (msg){
                        $("#passwordConfirmHint").html(msg);
                    }
                })
            });
            $("#create").focus(function (){
                if($("#username").val() === ""){
                    $("#usernameHint").html("<p style='color: red; font-family: \"Times New Roman\"; margin: 0'>username cannot be empty</p>");
                    return;
                }else if($("#password").val() === ""){
                    $("#passwordHint").html("<p style='color: red; font-family: \"Times New Roman\"; margin: 0'>password cannot be empty</p>");
                    return;
                }else if($("#passwordConfirm").val() === ""){
                    $("#passwordConfirmHint").html("<p style='color: red; font-family: \"Times New Roman\"; margin: 0'>password confirmation cannot be empty</p>");
                    return;
                }
                $.ajax({
                    url: "php/registerConfirm.php",
                    type: "POST",
                    data: "confirm=create"
                        + "&username=" + $("#username").val()
                        + "&password=" + $("#password").val()
                        + "&passwordConfirm=" + $("#passwordConfirm").val()
                        + "&email=" + $("#email").val()
                        + "&tel=" + $("#tel").val()
                        + "&address=" + $("#address").val(),
                    success:function (msg){
                        $("#createHint").html(msg);
                    }
                })
            });
        })
    </script>
</head>
<body onload="goRegister();trackShow()">
    <div id="container">
    <div class="header">
        <a href="collection.php?info=0">
            <img src="resources/img/user.png" id="myAccount">
        </a>
        <h1 class="title">
            Art World
        </h1>
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
                <li><a href="login.php" class="navigation">
                    Login
                </a></li>
                <li><a href="search.php?info=0&condition=view&currentPage=1" class="navigation">
                    Search
                </a></li>
                <li><a class="navigation" href="index.php">
                    HomePage
                </a></li>
            </ul>
        </div>
    <div id="track"></div>
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
            <input type="button" id="create" value="CREATE MY ACCOUNT" class="button">
            <span id="createHint"></span>
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