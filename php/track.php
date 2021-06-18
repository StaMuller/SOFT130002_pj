<link rel="stylesheet" type="text/css" href="../css/general.css">
<?php
function trackShow($pageNow){
    $page = $_SESSION['page'];
    $pageStr = "";
    for($i = 0; $i < count($page); ++$i){
        if(($i == count($page) - 1)
            || ($page[$i] == $pageNow
                || (strpos($page[$i], 'Exhibition') !== false && strpos($pageNow, 'Exhibition') !== false))){
            if($page[$i] == "Homepage"){
                $pageStr .= "<a href='index.php' style='text-decoration: none; color: black;'>Homepage</a>";
            }else if($page[$i] == "Search"){
                $pageStr .= "<a href='search.php?info=0&condition=view&currentPage=1' style='text-decoration: none; color: black;'>Search</a>";
            }else if(strpos($page[$i], 'Exhibition') !== false){
                $artworkID = findNum($page[$i]);
                $pageStr .= "<a href='exhibition.php?artworkID={$artworkID}' style='text-decoration: none; color: black;'>Exhibition</a>";
            }else if($page[$i] == "Collection"){
                $pageStr .= "<a href='collection.php?info=0' style='text-decoration: none; color: black;'>Collection</a>";
            }else{
                $pageStr .= "<a href='{$page[$i]}.php' style='text-decoration: none; color: black;'>$page[$i]</a>";
            }
            if($page[$i] == $pageNow
                || (strpos($page[$i], 'Exhibition') !== false && strpos($pageNow, 'Exhibition') !== false)){
                $page = array_slice($page, 0, $i + 1);
                $_SESSION['page'] = $page;
                break;
            }
        }else {
            if($page[$i] == "Homepage"){
                $pageStr .= ("<a href='index.php' style='text-decoration: none; color: black;'>Homepage</a>" . " -> ");
            }else if($page[$i] == "Search"){
                $pageStr .= "<a href='search.php?info=0&condition=view&currentPage=1' style='text-decoration: none; color: black;'>Search</a>" . " -> ";
            }else if(strpos($page[$i], 'Exhibition') !== false){
                $artworkID = findNum($page[$i]);
                $pageStr .= "<a href='exhibition.php?artworkID={$artworkID}' style='text-decoration: none; color: black;'>Exhibition</a>" . " -> ";
            }else if($page[$i] == "Collection"){
                $pageStr .= "<a href='collection.php?info=0' style='text-decoration: none; color: black;'>Collection</a>" . " -> ";
            }else{
                $pageStr .= ("<a href='{$page[$i]}.php' style='text-decoration: none; color: black;'>$page[$i]</a>" . " -> ");
            }
        }
    }
    echo "<div id='track'>{$pageStr}</div>";
}

function findNum($str = ''){
    $str = trim($str);
    if(empty($str)){return '';}
    $result='';
    for($i = 0; $i < strlen($str); $i++){
        if(is_numeric($str[$i])){
            $result .= $str[$i];
        }
    }
    return $result;
}