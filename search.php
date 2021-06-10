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
        <form style="text-align: left" action="./php/searchArtwork.php" method="get">
            <label> you may want to search </label>
            <?php
            $info = $_GET['info'];
            if($info == "0") {
                echo '<input type="text" style="height: 40px;font-size: 18px" name="info" placeholder="something about art">';
            }else{
                echo '<input type="text" style="height: 40px;font-size: 18px" name="info" value="' . $info . '">';
            }
            ?>
            <input type="submit" value="search" name="submit" style="font-size: 20px; height: 30px; font-family: 'Times New Roman'">
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
        <!-- 分页展示 -->
        <?php
            // 一页显示9个艺术品
            $currentPage = (int)$_GET['currentPage'];
            if($currentPage == 1){
                $prev = 1;
                $next = $currentPage + 1;
            }else{
                $prev = $currentPage - 1;
                $next = $currentPage + 1;
            }

            $info = $_GET['info'];
            $condition = $_GET['condition'];

            // 搜索需要显示的结果
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

            $totalNumber = $result->rowCount();
            $pageNumber = (int)($totalNumber / 9);
            if($totalNumber % 9 != 0){
                $pageNumber += 1;
            }
            if($currentPage > $pageNumber){
                $currentPage = $pageNumber;
            }
            $begin = ($currentPage - 1) * 9 + 1;
            $end = $begin + 8;

            page($result, $begin, $end);
            pageTurn($currentPage, $prev, $next, $info, $condition, $pageNumber);
        ?>

    </div>

    <div id="myFooter">
        @ArtStore.Produced and maintained by Achillessanger at 2018.4.1 All Right Reserved
    </div>

    <!-- 相关php辅助实现函数 -->
    <?php
    // 搜索界面的分页显示
    function page($result, $begin, $end){
        try {
            $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if ($result->rowCount() != 0) {
                $continue = 1;
                $i = 1;
                while($i != $begin){
                    if($result->fetch() == null){
                        break;
                    }
                    ++$i;
                }
                if($i != $begin){
                    $continue = 0;
                }
                while ($continue) {
                    echo '<div class="Row">';
                    for ($index = 0; $index < 3; $index++) {
                        if ($row = $result->fetch()) {
                            ++$begin;
                            $sql = "SELECT * FROM wishlist WHERE artworkID = {$row['artworkID']}";
                            $exist = $pdo->query($sql);
                            if ($exist->fetch()) {
                                $added = 0;
                            } else {
                                $added = 1;
                            }
                            echo '<div class="Col"><div class="picCard">';
                            echo '<h1 class="name"><b>' . $row['title'] . '</b></h1>';
                            echo '<h2 class="author">' . $row['artist'] . '</h2>';
                            echo '<h2 class="author"> View: ' . $row['view'] . '</h2>';
                            echo '<h2 class="author"> Price: ' . $row['price'] . '</h2>';
                            echo '<h2 class="author"> TimeReleased: ' . $row['timeReleased'] . '</h2>';
                            echo '<a href="exhibition.php?artworkID=' . $row['artworkID'] . '&added=' . $added . '">';
                            echo '<img src="resources/img/' . $row['imageFileName'] . '" class="picture"></a>';
                            echo '<p class="description">' . $row['description'] . '</p></div></div>';
                        } else {
                            $continue = 0;
                            break;
                        }
                    }
                    if($begin == ($end + 1)){
                        $continue = 0;
                    }
                    echo '</div>';
                }
            } else {
                echo '<div class="noRow"><p id="fail">PITY! NO RESULT HERE.</p></div>';
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    // 翻页操作
    function pageTurn($currentPage, $prev, $next, $info, $condition, $pageNumber){
        try {
            $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            echo '<div class="pagination">';
            // 显示五个页码
            echo '<a href="search.php?info=' . $info . '&condition=' . $condition . '&currentPage=1"><<<</a>';
            echo '<a href="search.php?info=' . $info . '&condition=' . $condition . '&currentPage=' . $prev . '"><<</a>';
            if($currentPage > $pageNumber){
                $currentPage = $pageNumber;
            }else if($currentPage < 1){
                $currentPage = 1;
            }
            $begin = $currentPage - ($currentPage % 5) + 1;
            $end = $begin + 4;
            if($end > $pageNumber){
                $end = $pageNumber;
            }
            if($currentPage > 5){
                echo '<a href="search.php?info=' . $info . '&condition=' . $condition . '&currentPage=' . ($begin - 5) . '">...</a>';
            }
            for($i = $begin; $i <= $end; ++$i){
                if($currentPage == $i){
                    echo '<a href="#" class="active">' . $i . '</a>';
                }else{
                    echo '<a href="search.php?info=' . $info . '&condition=' . $condition . '&currentPage=' . $i . '">' . $i . '</a>';
                }
            }
            if($end != $pageNumber){
                echo '<a href="search.php?info=' . $info . '&condition=' . $condition . '&currentPage=' . ($end + 1) . '">...</a>';
            }
            echo '<a href="search.php?info=' . $info . '&condition=' . $condition . '&currentPage=' . $next . '">>></a>';
            echo '<a href="search.php?info=' . $info . '&condition=' . $condition . '&currentPage=' . $pageNumber . '">>>></a>';
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    ?>

    </div>
</body>
</html>