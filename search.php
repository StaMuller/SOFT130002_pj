<?php
require_once ("./php/config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Search </title>
    <link rel="stylesheet" type="text/css" href="css/general.css">
    <link rel="stylesheet" type="text/css" href="css/search.css">
    <script type="text/javascript" src="JavaScript/general.js"></script>
</head>
<body onload="goSearch();trackShow()">

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
            <li><a class="navigation" href="search.php?info=0&condition=view">
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
        <form style="text-align: left" action="./php/searchArtwork.php" method="get">
            <label> you may want to search </label>
            <input type="text" name="info" placeholder="something about art">
            <input type="submit" value="search" name="submit">
            <?php
                $condition = $_GET['condition'];
                if($condition == "view"){
                    $option1 = '<option value="view"> By View </option>';
                    $option2 = '<option value="price"> By Price </option>';
                    $option3 = '<option value="timeReleased"> By TimeReleased </option>';
                }else if($condition == "price"){
                    $option1 = '<option value="price"> By Price </option>';
                    $option2 = '<option value="view"> By View </option>';
                    $option3 = '<option value="timeReleased"> By TimeReleased </option>';
                }else{
                    $option1 = '<option value="timeReleased"> By TimeReleased </option>';
                    $option2 = '<option value="price"> By Price </option>';
                    $option3 = '<option value="view"> By View </option>';
                }

                echo '<select name="condition" class="condition">' . $option1 . $option2 . $option3 . '</select>';
            ?>
        </form>
    </div>
    <hr>

        <?php
            $info = $_GET['info'];
            $condition = $_GET['condition'];
            if($info == "0"){
                $sql = "SELECT * FROM artworks";
            }else{
                $sql = "SELECT * FROM artworks 
                WHERE title like '%{$info}%' 
                OR description like '%{$info}%'
                OR artist like '%{$info}%'
                ORDER BY {$condition} DESC ";
            }
                $result = $pdo->query($sql);

                if($row = $result->fetch()){
                    $continue = 1;
                    while($continue){
                        echo '<div class="row">';
                        for($index = 0; $index < 3; $index++){
                            if($row) {
                                $sql = "SELECT * FROM wishlist WHERE artworkID = {$row['artworkID']}";
                                $exist = $pdo->query($sql);
                                if($exist->fetch()){
                                    $added = 0;
                                }else{
                                    $added = 1;
                                }
                                echo '<div class="column"><div class="card">';
                                echo '<h1 class="name"><b>' . $row['title'] . '</b></h1>';
                                echo '<h2 class="author">' . $row['artist'] . '</h2>';
                                echo '<h2 class="author"> View: ' . $row['view'] . '</h2>';
                                echo '<h2 class="author"> Price: ' . $row['price'] . '</h2>';
                                echo '<h2 class="author"> TimeReleased: ' . $row['timeReleased'] . '</h2>';
                                echo '<a href="exhibition.php?artworkID=' . $row['artworkID'] . '&added=' . $added .  '">';
                                echo '<img src="resources/img/' . $row['imageFileName'] . '" class="picture"></a>';
                                echo '<p class="description">' . $row['description'] . '</p></div></div>';
                            }else{
                                $continue = 0;
                                break;
                            }
                            $row = $result->fetch();
                        }
                        echo '</div>';
                    }
                }else{
                    echo '<div class="row"><p id="fail">PITY! NO RESULT HERE.</p></div>';
                }

        ?>

    <div class="pagination">
        <a href="#"><<</a>
        <a href="#" class="active">1</a>
        <a href="#">2</a>
        <a href="#">3</a>
        <a href="#">4</a>
        <a href="#">5</a>
        <a href="#">6</a>
        <a href="#">7</a>
        <a href="#">>></a>
    </div>
    </div>

    <div id="footer">
        @ArtStore.Produced and maintained by Achillessanger at 2018.4.1 All Right Reserved
    </div>
</body>
</html>