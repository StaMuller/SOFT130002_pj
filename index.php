<?php
    require_once ("./php/config.php");
?>
<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<head>
    <title>
        First Page
    </title>
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="stylesheet" type="text/css" href="css/general.css">
    <script type="text/javascript" src="JavaScript/general.js"></script>
</head>
<body onload="goHomepage();trackShow()">

    <?php
    try{
        $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch (PDOException $e){
        die($e->getMessage());
    }
    ?>

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
    <div>                                              <!--logo与标语-->
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
<!--    <div id="track"></div>-->
        <!------------------------------------------------------------------------------------------>
    <div class="headPic">
        <!-- 热门艺术品展示：展示访问量最多的三个艺术品 -->
        <div id="picContainer">
            <div id="photo">

                <?php
                $sql = "SELECT * FROM artworks ORDER BY view DESC limit 0,3";
                $result = $pdo->query($sql);
                while($photo = $result->fetch()){
                    $sql = "SELECT * FROM wishlist WHERE artworkID = {$photo['artworkID']}";
                    $exist = $pdo->query($sql);
                    if($exist->fetch()){
                        $added = 0;
                    }else{
                        $added = 1;
                    }
                    $imageFileName = '<div class="headColumn"><a href="exhibition.php?artworkID=' . $photo['artworkID'] . '&added=' . $added . '"><img src="resources/img/' . $photo['imageFileName'] . '" class="head"></a>';
                    $title = '<h1 class="headPicTitle"><b>' . $photo['title'] . '</b></h1>';
                    $description = '<p class="headPicDes">' . $photo['description'] . '</p></div>';
                    echo $imageFileName . $title . $description;
                }

                ?>

            </div>
        </div>
    </div>

    <div>
    <hr>
    <h1 style="font-size: 15px" align="center" class="title"> More art works </h1>
        <!--最新艺术品展示：展示最新发布的三个艺术品-->
    <div class="row">

                <?php
                $sql = "SELECT * FROM artworks ORDER BY timeReleased DESC limit 0,3";
                $result = $pdo->query($sql);
                $learnMore = '<a href="exhibition.php" class="more"><b>LEARN MORE</b></a></div>';
                while($photo = $result->fetch()){
                    $artworkID = $photo['artworkID'];
                    $sql = "SELECT * FROM wishlist WHERE artworkID = {$artworkID}";
                    $exist = $pdo->query($sql);
                    if($exist->fetch()){
                        $added = 0;
                    }else{
                        $added = 1;
                    }
                    $imageFileName = '<div class="column"><a href="exhibition.php?artworkID=' . $artworkID . '&added=' . $added . '"><img src="resources/img/' . $photo['imageFileName'] . '"></a><br>';
                    $title = '<span class = "des"><h1 class="headPicDes"><b>' . $photo['title'] . '</b></h1>';
                    $artist = $photo['artist'] . '<br>';
                    $description = $photo['description'] . '<br></span>';
                    echo $imageFileName . $title . $artist . $description . $learnMore;
                }

                ?>

    </div>
    </div>

    <div id="footer">
        @ArtStore.Produced and maintained by Achillessanger at 2018.4.1 All Right Reserved
    </div>

</body>
</html>