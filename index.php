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

require_once("struct/header.php");
require_once("struct/body.php");


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

require_once("struct/body_both.php");

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

echo "<br />";
require_once("struct/footer.php");
?>
