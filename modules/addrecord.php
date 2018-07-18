<?php
session_start();
require_once("dbconnect.php");

$_SESSION['error'] = 0;
$link = db_connect();
$user = htmlspecialchars($_POST['user']);
$email = htmlspecialchars($_POST['email']);
$url = htmlspecialchars($_POST['url']);
$message = htmlspecialchars($_POST['message']);
$browser = $_SERVER['HTTP_USER_AGENT'];
$ip = $_SERVER['REMOTE_ADDR'];
$date = date("Y-m-d");
$capchainput = htmlspecialchars($_POST['capchainput']);

$_SESSION["error_user"] = "";
$_SESSION["error_email"] = "";
$_SESSION["error_url"] = "";
$_SESSION["error_message"] = "";
$_SESSION["error_capcha"] = "";

if (!preg_match('|^[A-Z0-9]+$|i', $user)) {
    $_SESSION['error'] = 1;
    $_SESSION["error_user"] = "Некорректное имя пользователя";
}

if ((strlen($user)<3) || (strlen($user)>12)){
    $_SESSION['error'] = 1;
    $_SESSION["error_user"] = "Длина имени от 3 до 12 символов";
}

if (!preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i", $email)) {
    $_SESSION['error'] = 1;
    $_SESSION["error_email"] = "Некорректный E-mail адрес";
}
if ($url <> ""){
    if (!preg_match('/^(http:\/\/|https:\/\/)?[0-9a-zA-Zа-яА-ЯёЁ]{1,3}+[.][0-9a-zA-Zа-яА-ЯёЁ]+[.][0-9a-zA-Zа-яА-ЯёЁ]{2,6}+$/', $url)) {
        $_SESSION['error'] = 1;
        $_SESSION["error_url"] = "Некорректный url";
    }
}

if (strlen($message)<3){
    $_SESSION['error'] = 1;
    $_SESSION["error_message"] = "Длина сообщения не менее 3х символов";
}

if ($_SESSION["capcha"] <> md5($capchainput)){
    $_SESSION['error'] = 1;
    $_SESSION["error_capcha"] = "Неверный код";
}


if ($_SESSION['error'] <> 1){
    $result = $link->query("INSERT INTO `records` (`indexx`, `ip`, `brouser`, `user`, `email`, `homepage`, `message`, `date`) VALUES (NULL, '".$ip."', '".$browser."', '".$user."', '".$email."', '".$url."', '".$message."', '".$date."')");
    unset($_SESSION["user"]);
    unset($_SESSION["email"]);
    unset($_SESSION["url"]);
    unset($_SESSION["message"]);
    echo $ip."</br>".$browser."</br>".$user."</br>".$email."</br>".$url."</br>".$message."</br>".$date;
} else {
    $_SESSION["user"] = $user;
    $_SESSION["email"] = $email;
    $_SESSION["url"] = $url;
    $_SESSION["message"] = $message;
}

header('Location:../index.php');

exit;

?>