<?php session_start(); ?>
<?php
require_once ("./php/config.php");
$page = array("Homepage");
$_SESSION["page"] = $page;
?>
<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<head>
    <title>
        Home Page
    </title>
    <link rel="stylesheet" type="text/css" href="css/index.css">
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
        $page = $_SESSION['page'];
        $pageStr = "";
        for($i = 0; $i < count($page); ++$i){
            if($page[$i] == "Homepage"){
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
        <div class="headPic">
            <!-- 热门艺术品展示：展示访问量最多的三个艺术品 -->
            <div id="picContainer">
                <div id="photoContainer">

                    <?php
                    $sql = "SELECT * FROM artworks ORDER BY view DESC limit 0,3";
                    $result = $pdo->query($sql);
                    while($photo = $result->fetch()){
                        $imageFileName = '<div class="headColumn"><a href="exhibition.php?artworkID=' . $photo['artworkID'] . '"><img src="resources/img/' . $photo['imageFileName'] . '" class="head"></a>';
                        $title = '<h1 class="headPicTitle"><b>' . $photo['title'] . '</b></h1>';
                        $description = '<p class="headPicDes">' . $photo['description'] . '</p></div>';
                        echo $imageFileName . $title . $description;
                    }

                    ?>

                </div>
            </div>
        </div>

        <hr>
        <h1 style="font-size: 15px" align="center" class="title"> More art works </h1>
        <!--最新艺术品展示：展示最新发布的三个艺术品-->
        <div class="Row">

                    <?php
                    $sql = "SELECT * FROM artworks ORDER BY timeReleased DESC limit 0,3";
                    $result = $pdo->query($sql);
                    while($photo = $result->fetch()){
                        $artworkID = $photo['artworkID'];
                        $sql = "SELECT * FROM wishlist WHERE artworkID = {$artworkID}";
                        $exist = $pdo->query($sql);
                        if($exist->fetch()){
                            $added = 0;
                        }else{
                            $added = 1;
                        }
                        $imageFileName = '<div class="Col"><a href="exhibition.php?artworkID=' . $artworkID . '&added=' . $added . '"><img src="resources/img/' . $photo['imageFileName'] . '"></a><br>';
                        $title = '<span class = "des"><h1 class="des"><b>' . $photo['title'] . '</b></h1>';
                        $artist = $photo['artist'] . '<br>';
                        $description = $photo['description'] . '<br></span>';
                        $learnMore = '<a href="exhibition.php?artworkID=' . $artworkID . '&added=' . $added . '" class="more"><b>LEARN MORE</b></a></div>';
                        echo $imageFileName . $title . $artist . $description . $learnMore;
                    }

                    ?>
        </div>
    </div>

    <div id="myFooter">
        @ArtStore.Produced and maintained by Achillessanger at 2018.4.1 All Right Reserved
    </div>

</body>
</html>