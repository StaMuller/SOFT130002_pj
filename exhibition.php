<?php
require_once ("./php/config.php");
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
    <script type="text/javascript" src="JavaScript/exhibition.js"></script>
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
        <a href="collection.php">
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
    <div>
        <ul>
            <li><a href="register.html" class="navigation">
                Register
            </a></li>
            <li><a href="login.html" class="navigation">
                Login
            </a></li>
            <li><a href="search.php?info=0&condition=view" class="navigation">
                Search
            </a></li>
            <li><a class="navigation" href="index.php">
                HomePage
            </a></li>
        </ul>
    </div>
<!--    <div id="track" class="track"></div>-->
    <!------------------------------------------------------------------------------------------>
        <?php
            $artworkID = $_GET['artworkID'];
            $added = $_GET['added'];
            $sql = "SELECT * FROM artworks WHERE artworkID = '" . $artworkID . "'";
            $result = $pdo->query($sql);
            $artwork = $result->fetch();

            $title = '<div class="detail"><b>' . $artwork['title'] . '</b><br>';
            $author = '<a href="search.php" class="author">' . $artwork['artist'] . '</a></div><hr>';
            $picture = '<div class="row"><div class="column"><img id="picture" src="resources/img/' . $artwork['imageFileName'] . '"></div>';
            $yearOfWork = '<div class="column" id="description">Painted ' . $artwork['yearOfWork'] . '<br>';
            $genre = $artwork['genre'] . '<br>';
            $size = 'Dimensions: ' . $artwork['width'] . ' cm × ' . $artwork['height'] . ' cm<br>';
            $releaseTime = 'Released time: ' . $artwork['timeReleased'] . '<br>';
            $view = $artwork['view'];

            $view = $view + 1;
            // 更新view信息
            $sql = "UPDATE artworks SET view = '{$view}' WHERE artworkID = '{$artworkID}'";
            $pdo->query($sql);

            $view = "View: {$view} <br>";
            $description = $artwork['description'] . '<br><hr />';
            $price = 'Price: ' . $artwork['price'] . 'USD<br>';
            echo $title . $author . $picture . $yearOfWork . $genre . $size . $releaseTime . $view . $description . $price;

            if($added == 1){
                echo '<a href="./php/addWishList.php?artworkID=' . $artworkID . '">';
                echo '<button class="button" onclick="addWishListSuccess()">ADD TO WISH LIST</button></a>';
            }else{
                echo '<button class="button" onclick="addWishListFailed()">ALREADY ADDED</button></a>';
            }

        ?>
            <br />
            <a class="more" href="index.php">
                <b>SEE MORE GOODS</b>
            </a>
        </div>
    </div>
    </div>

    <div id="footer">
        @ArtStore.Produced and maintained by Achillessanger at 2018.4.1 All Right Reserved
    </div>
</body>
</html>