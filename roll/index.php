<!DOCTYPE html>
<?php
$food_lst=array(
"小椒牛肉丝盖饭",
"干煸四季豆盖饭",
"酸辣土豆丝盖饭",
"茄子牛肉盖饭",
"韭菜炒鸡蛋盖饭",
"海带烧排骨盖饭",

"糖醋排骨粒盖饭",
"青椒鸡丁盖饭",
"青椒牛肉片盖饭",
"五花肉炒花菜盖饭",
"辣子鸡丁盖饭",
"排骨炖土豆盖饭",
"芹菜香干肉丝盖饭",

"咖喱鸡丁盖饭",
"茄子鸡片盖饭",
"木耳炒鸡蛋盖饭",
"尖椒肥肠盖饭",
"豆花肥牛盖饭",
"尖椒干豆腐盖饭",
"干锅排骨盖饭",

"宫保鸡丁盖饭",
"鱼香肉丝盖饭",
"回锅肉盖饭",
"麻婆豆腐盖饭",
"西红柿炒鸡蛋盖饭",
"红烧肉盖饭",
);
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
    $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $location);
    exit;
}
//prevent cache stuff
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
$domainname = "quitphd.com";

function gen_rand_str($length){
    $chars = "0123456789abcdefghijklmnopqrstuvwxyz";//
    $rndstr="";

    $size = strlen( $chars );
    for( $i = 0; $i < $length; $i++ ){
            $rndchar = $chars[rand(0, $size-1)];
            $rndstr = $rndstr . $rndchar;
    }
    return $rndstr;
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

$cookie_id = "userid-judelou";
// $cookie_usrname = "usrname1";
// logout
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['logout'])) {

    setcookie($cookie_id, "", time() - 3600, "/",$domainname,1,1);
    
    $location = 'https://' . $_SERVER['HTTP_HOST'] . "/menu/roll/logout.php";
    // die($location);
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $location);
    exit;
    }
}
?>
<html>
<body>
<img src="./yes.jpg" width=100><br><br>
<?php
if(!isset($_COOKIE[$cookie_id])) {
    $cookie_value = gen_rand_str(6);
    $choice=$food_lst[crc32($cookie_value)%(sizeof($food_lst))];
    //we set 66400 instead of 86400, slightly less than 24 hrs
    setcookie($cookie_id, $cookie_value, time() + (66400 * 1), "/",$domainname,1,1); // 86400 = 1 day
    echo "帮你选了：". $choice ." <br>"
    . "您今天吃的喜欢嘛？ (<strong>". $cookie_value. "</strong>).<br>"
    . "请吃，24小时之后再来选项才会刷新<br>";
} else {
    $cookie_value =$_COOKIE[$cookie_id];
    $choice=$food_lst[crc32($cookie_value)%(sizeof($food_lst))];
    echo "您已经选过餐了: ". $choice ." <br>";
    echo "您的ID是：(<strong>". $cookie_value . "</strong>)<br>";
    echo "请吃，24小时之后再来选项才会刷新<br>";
}

// if(!isset($_COOKIE[$cookie_usrname])) {
//     echo "We don't have your name yet.<br>";
// } else {
//      echo "---Hello, <strong>" . $_COOKIE[$cookie_usrname] . "</strong>!";
// }

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     if(isset($_POST[$cookie_usrname])){
//         $usrname = test_input($_POST[$cookie_usrname]);
//         setcookie($cookie_usrname, $usrname, time() + (86400 * 30), "/",$domainname,1,1); // 86400 = 1 day
//         header('Location: '. htmlspecialchars($_SERVER["PHP_SELF"]));//redirect
//         exit;
//     }
// }


?>
<a href="../">返回主菜单</a>

<form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="post">
<input type="hidden" name="logout" value=<?php echo gen_rand_str(5);?>><br>
<input type="submit" value="我真的想再roll求求了!!">
</form>




</body>
</html>