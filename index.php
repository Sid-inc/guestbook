<?php
session_start();
require_once("modules/dbconnect.php");
require_once("modules/capcha.php");
$link = db_connect();
$_SESSION["capcha"] = capcha_gen();
$order = "";
$current_page="1";
$show_page_limit = 25;
$records_count = $link->query("SELECT COUNT(1) FROM records");
$records_count = mysqli_fetch_array($records_count);
$records_count = $records_count[0];

if (isset($_GET["page"])){
    $_SESSION["current_page"]=$_GET["page"];
}
if (isset($_SESSION["current_page"])){
    $current_page=$_SESSION["current_page"];
}

if (isset($_GET["order"])){
    if ($_GET["order"] == "user_down"){
        $order = " ORDER BY user ";
    }
    if ($_GET["order"] == "user_up"){
        $order = " ORDER BY user DESC";
    }
    if ($_GET["order"] == "email_down"){
        $order = " ORDER BY email ASC";
    }
    if ($_GET["order"] == "email_up"){
        $order = " ORDER BY email DESC";
    }
    if ($_GET["order"] == "date_down"){
        $order = " ORDER BY date ASC";
    }
    if ($_GET["order"] == "date_up"){
        $order = " ORDER BY date DESC";
    }
} else {
    $order = " ORDER BY date DESC";
}

if (!isset($_SESSION['data_send'])){
    $_SESSION['data_send'] = "";
}

if ($_SESSION['data_send'] == ""){
    $_SESSION["error_user"] = "";
    $_SESSION["error_email"] = "";
    $_SESSION["error_url"] = "";
    $_SESSION["error_message"] = "";
    $_SESSION["error_capcha"] = "";
    $_SESSION["user"] = "";
    $_SESSION["email"] = "";
    $_SESSION["url"] = "";
    $_SESSION["message"] = "";
}

?>

<!DOCTYPE html>
<html>
    <head>
         <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
         <link rel="stylesheet" href="css/style.css?v=<?=md5(date('his'))?>">
         <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
         <title>Гостева книга</title>
    </head>
<body>
    <div id="header"><h1>guestbook</h1></div><br />
<div id="messages">
<table border="1">
    <caption>Сообщения пользователей</caption>
    <tr>
        <th>Имя пользователя <a href="index.php?order=user_down"><img src="img/str_up.png"></a> <a href="index.php?order=user_up"><img src="img/str_down.png"></a></th>
        <th>Элетронная почта <a href="index.php?order=email_down"><img src="img/str_up.png"></a> <a href="index.php?order=email_up"><img src="img/str_down.png"></a></th>
        <th>Дата <a href="index.php?order=date_down"><img src="img/str_up.png"></a> <a href="index.php?order=date_up"><img src="img/str_down.png"></a></th>
        <th>Сообщение</th>
    </tr>
<?php

if ($result = $link->query("SELECT user, email, date, message FROM records".$order." LIMIT ".($current_page-1)*$show_page_limit.", ".$show_page_limit)) {
    while (($rec = $result->fetch_assoc()) != false){
?>
        <tr>
        <td id="user"><?=$rec['user']?></td>
        <td id="email"><?=$rec['email']?></td>
        <td id="datemessage"><?=$rec['date']?></td>
        <td id="message"><?=$rec['message']?></td>
        </tr>
<?php    }

    $result->close();
}
?>
</table>
</div><br />

<?php
if ($records_count > $show_page_limit) {
 echo '<div align="center" id="page_numbers">';
 if ($current_page <> "1") {
     echo '<a href="index.php?page=1"><< </a>';
     echo '<a href="index.php?page='.($current_page-1).'">'.($current_page-1).'</a> ';
 }
 echo "[$current_page] ";
 
 if ($current_page < ceil((float)$records_count/(float)$show_page_limit)) {
     echo '<a href="index.php?page='.($current_page+1).'">'.($current_page+1).'</a> ';
     echo '<a href="index.php?page='.ceil((float)$records_count/(float)$show_page_limit).'"> >></a>';
 }
 echo '</div>';
}

require_once ("msgform.php");
$_SESSION['data_send'] = "";
?>
<br />
<div id="footer"></div>
</body>
</html>