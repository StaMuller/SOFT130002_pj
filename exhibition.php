<?php
require_once ("./php/config.php");
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<head>
    <title>
        Product Exhibition
    </title>
    <link rel="stylesheet" type="text/css" href="css/exhibition.css">
    <link rel="stylesheet" type="text/css" href="css/general.css">
    <script type="text/javascript" src="bootstrap/js/jquery.js"></script>
    <script type="text/javascript" src="JavaScript/general.js"></script>
</head>

<body onload="goExhibition();trackShow()">

    <?php
    try{
        $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch (PDOException $e){
        die($e->getMessage());
    }
    ?>

    <!-- logo、标语与导航栏 -->
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
                    echo '<li><a href="index.php" class="navigation">LOGOUT</a></li>';
                    session_destroy();
                }else{
                    echo '<li><a href="login.php" class="navigation">Login</a></li>';
                    echo '<script>sessionStorage.setItem(\'prev\', window.location.href )</script>';
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
    <div id="track" class="track"></div>
    <!------------------------------------------------------------------------------------------>
        <?php
            $artworkID = $_GET['artworkID'];
            if(isset($_SESSION['userID'])){
                $sql = "SELECT * FROM wishlist WHERE artworkID = {$artworkID} AND userID = {$_SESSION['userID']}" ;
                if($pdo->query($sql)->fetch()){
                    $added = 0;
                }else{
                    $added = 1;
                }
            }else{
                $added = 1;
            }
            $sql = "SELECT * FROM artworks WHERE artworkID = {$artworkID}";
            $result = $pdo->query($sql);
            $artwork = $result->fetch();

            $title = '<div class="detail"><b>' . $artwork['title'] . '</b><br>';
            $author = '<a href="search.php?info=0&condition=view&currentPage=1" class="author">' . $artwork['artist'] . '</a></div><hr>';
            $picture = '<div class="row"><div class="column"><img id="picture" src="resources/img/' . $artwork['imageFileName'] . '"></div>';
            $yearOfWork = '<div class="column" id="description">Painted ' . $artwork['yearOfWork'] . '<br>';
            $genre = $artwork['genre'] . '<br>';
            $size = 'Dimensions: ' . $artwork['width'] . ' cm × ' . $artwork['height'] . ' cm<br>';
            $releaseTime = 'Released time: ' . $artwork['timeReleased'] . '<br>';
            $view = $artwork['view'];

            $view = $view + 1;
            // 更新view信息
            $sql = "UPDATE artworks SET view = {$view} WHERE artworkID = {$artworkID}";
            $pdo->query($sql);

            $view = "View: {$view} <br>";
            $description = $artwork['description'] . '<br><hr />';
            $price = 'Price: ' . $artwork['price'] . 'USD<br>';
            echo $title . $author . $picture . $yearOfWork . $genre . $size . $releaseTime . $view . $description . $price;

        ?>

        <button class="button" id="add" type="button">
        <?php
            if($added == 1){
                echo 'ADD TO WISH LIST';
            }else{
                echo 'ALREADY ADDED';
            }
        ?>
        </button>
        <span id="addHint"></span>

            <br />
            <a class="more" href="index.php">
                <b>SEE MORE GOODS</b>
            </a>
        </div>
    </div>
    </div>

    <div id="myFooter">
        @ArtStore.Produced and maintained by Achillessanger at 2018.4.1 All Right Reserved
    </div>

    <!-- 收藏监听 -->
    <script type="text/javascript">
        $(document).ready(function (){
            $("#add").focus(function (){
                let artworkID = '<?php echo $artworkID?>';
                let added = '<?php echo $added?>';
                $.ajax({
                    url: "php/addWishList.php",
                    type: "POST",
                    data: "artworkID=" + artworkID
                        + "&added=" + added,
                    dataType: "json",
                    success:function (msg){
                        if(msg.message === "forbidden"){
                            $("#addHint").html(
                                "<p style='color: red; font-family: \"Times New Roman\"; margin: 0'>" +
                                    "FAILED. Please LOG IN first." +
                                "</p>");
                        }else if(msg.message === "added"){
                            $("#addHint").html(
                                "<p style='color: red; font-family: \"Times New Roman\"; margin: 0'>" +
                                "ALREADY ADDED" +
                                "</p>");
                        }else{
                            $("#addHint").html(
                                "<p style='color: #146c43; font-family: \"Times New Roman\"; margin: 0'>" +
                                "ADD SUCCESSFULLY!" +
                                "</p>");
                        }
                    }
                })
            })
        })
    </script>
</body>
</html>