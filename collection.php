<?php
require_once ("./php/config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Collection </title>
    <link rel="stylesheet" type="text/css" href="css/general.css">
    <link rel="stylesheet" type="text/css" href="css/collection.css">
    <script type="text/javascript" src="JavaScript/collection.js"></script>
    <script type="text/javascript" src="JavaScript/general.js"></script>
</head>
<body onload="goCollection();trackShow()">

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
        <a href="collection.php?info=0">
            <img src="resources/img/user.png" id="myAccount">
        </a>
        <h1 class="title">
            Art World
        </h1>
        <p class="slogan">
            This is your art world.
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
    <div id="track" class="track"></div>
    <!------------------------------------------------------------------------------------------>
    <div class="search">
        <form style="text-align: left" action="./php/searchCollection.php" method="get">
            <label> Search in my art world </label>
            <input type="text" name="info">
            <input type="submit" value="search" name="submit" style="font-size: 20px; height: 30px; font-family: 'Times New Roman'">
        </form>
    </div>
    <hr>
    <div class="row">

            <?php
            $info = $_GET['info'];
            $sql = "SELECT * FROM wishlist";
            echo '<div class="leftColumn">';
            $result = $pdo->query($sql);
            $index = 1;
            $exist = 0;
            while($row = $result->fetch()) {
                $exist = 1;
                $artworkID = $row['artworkID'];
                if($info == "0"){
                    $sql = "SELECT * FROM artworks WHERE artworkID = " . $artworkID;
                }else{
                    $sql = "SELECT * FROM artworks WHERE
                                concat(artist, title, description, yearOfWork, genre, price, timeReleased) like '%{$info}%'
                                AND artworkID = " . $artworkID;
                }
                $artwork = $pdo->query($sql);
                if($work = $artwork->fetch()) {
                    echo '<div class="card" id="card' . $index . '">';
                    echo '<a href="exhibition.php?artworkID=' . $work['artworkID'] . '&&added=0" class="more"><h1 class="picTitle">' . $work['title'] . '</h1></a>';
                    echo '<h2 class="picAuthor">' . $work['artist'] . '</h2>';
                    echo '<h2 style="font-size: 15px">' . $work['timeReleased'] . '</h2>';
                    echo '<img src="resources/img/' . $work['imageFileName'] . '" class="Image">';
                    echo '<p class="picDis">' . $work['description'] . '</p>';

                    echo '<a href="./php/deleteWishList.php?artworkID=' . $work['artworkID'] . '&info=' . $info .  '">';
                    echo '<button class="deleteButton" id="delete1" type="button" onclick="deleteCollection(this)">DELETE IT</button></div></a>';
                    $index++;
                }
            }
            if($exist == 0){
                echo '<div><p id="fail"> YOU DO NOT HAVE ANY PRODUCT. GO TO ADD SOME! </p></div>';
            }else if($index == 1){
                echo '<div><p id="fail"> NO RESULT HERE. GO TO ADD WHAT YOU WANT! </p></div>';
            }
            echo '</div>';
            ?>

        <div class="rightColumn">
            <div class="card">
                <?php
                $sql = "SELECT * FROM users WHERE userID = 1";
                $result = $pdo->query($sql);
                $user = $result->fetch();

                $name = '<h1>' . $user['name'] . '</h1>';
                $pic = '<div class="fakeImage" style="height: 200px">Picture</div>';
                $email = '<p>' . $user['email'] . '</p>';
                $tel = '<p>' . $user['tel'] . '</p>';
                $address = '<p>' . $user['address'] . '</p>';

                echo $name . $pic . $email . $tel . $address;
                ?>

            </div>
        </div>
    </div>
    </div>

    <div id="myFooter">
        @ArtStore.Produced and maintained by Achillessanger at 2018.4.1 All Right Reserved
    </div>
</body>
</html>