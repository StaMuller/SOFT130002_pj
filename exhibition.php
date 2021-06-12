<?php session_start(); ?>
<?php
require_once ("./php/config.php");
$page = $_SESSION['page'];
array_push($page, "Exhibition");
$_SESSION['page'] = $page;
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
</head>

<body>

    <?php
    try{
        $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch (PDOException $e){
        die($e->getMessage());
    }
    ?>

    <div id="container">
        <div id="page">
            <!-- 头部 -->
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

            <!--logo与标语-->
            <div>
                <ul>
                    <li><a href="register.php" class="navigation">
                            Register
                        </a></li>
                    <?php
                    if(isset($_SESSION['username']) && isset($_SESSION['password'])){
                        echo '<li><a id="logout" href="index.php" class="navigation"">LOGOUT</a></li>';
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

            <!-- 足迹栏 -->
            <br>
            <?php
            $page = $_SESSION['page'];
            $pageStr = "";
            for($i = 0; $i < count($page); ++$i){
                if($page[$i] == "Exhibition"){
                    $pageStr .= $page[$i];
                    $page = array_slice($page, 0, $i + 1);
                    $_SESSION['page'] = $page;
                    break;
                }
                if($i == count($page) - 1){
                    $pageStr .= $page[$i];
                }else {
                    $pageStr .= ($page[$i] . " -> ");
                }
            }
            echo "<div id='track'>{$pageStr}</div>"
            ?>

            <!------------------------------------------------------------------------------------------>
            <?php
                $artworkID = $_GET['artworkID'];
                if(isset($_SESSION['userID'])){
                    $sql = "SELECT * FROM wishlist WHERE artworkID = {$artworkID} AND userID = {$_SESSION['userID']}" ;
                    if($pdo->query($sql)->fetch()){
                        $added = 0;   // 已存在，不可重复收藏
                    }else{
                        $added = 1;   // 可以收藏
                    }
                }else{
                    $added = 2;
                }
                $sql = "SELECT * FROM artworks WHERE artworkID = {$artworkID}";
                $result = $pdo->query($sql);
                $artwork = $result->fetch();

                $title = '<div class="detail"><b>' . $artwork['title'] . '</b><br>';
                $author = '<a href="search.php?info=0&condition=view&currentPage=1" class="author">' . $artwork['artist'] . '</a></div><hr>';
                $picture = '<div class="row"><div class="column"><img id="picture" src="resources/img/' . $artwork['imageFileName'] . '"></div>';
                $yearOfWork = '<div class="column">Painted ' . $artwork['yearOfWork'] . '<br>';
                $genre = $artwork['genre'] . '<br>';
                $size = 'Dimensions: ' . $artwork['width'] . ' cm × ' . $artwork['height'] . ' cm<br>';
                $releaseTime = 'Released time: ' . $artwork['timeReleased'] . '<br>';
                $view = $artwork['view'];

                $view = $view + 1;
                // 更新view信息
                $sql = "UPDATE artworks SET view = {$view} WHERE artworkID = {$artworkID}";
                $pdo->query($sql);

                $view = "View: {$view} <br>";
                $description = '<p>' . $artwork['description'] . '</p><br><hr />';
                $price = 'Price: ' . $artwork['price'] . 'USD<br>';
                echo $title . $author . $picture . $yearOfWork . $genre . $size . $releaseTime . $view . $description . $price;

            ?>

            <button class="button" id="add" type="button">
            <?php
                if($added == 1 || $added == 2){
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
                                "<p style='color: #146c43; font-family: \"Times New Roman\"; margin: 0'>" +
                                "ALREADY ADDED" +
                                "</p>");
                        }else{
                            $("#addHint").html(
                                "<p style='color: #146c43; font-family: \"Times New Roman\"; margin: 0'>" +
                                "ADD SUCCESSFULLY!" +
                                "</p>");
                            $("#add").html("ALREADY ADDED");
                        }
                    }
                })
            })
        })
    </script>
</body>
</html>