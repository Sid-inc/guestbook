<?php
session_start();
require_once("dbconnect.php");

$error = 0;

$link = db_connect();
$user = htmlspecialchars($_POST['user']);
$email = htmlspecialchars($_POST['email']);
$url = htmlspecialchars($_POST['url']);
$message = htmlspecialchars($_POST['message']);
$browser = $_SERVER['HTTP_USER_AGENT'];
$ip = $_SERVER['REMOTE_ADDR'];
$date = date("Y-m-d");
$capchainput = htmlspecialchars($_POST['capchainput']);

if (!preg_match('|^[A-Z0-9]+$|i', $user)) {
    $error = 1;
    $_SESSION["error_user"] = "Некорректное имя пользователя";
    $_SESSION["user"] = $user;
}

if ((strlen($user)<3) || (strlen($user)>12)){
    $error = 1;
    $_SESSION["error_user"] = "Длина имени от 3 до 12 символов";
    $_SESSION["user"] = $user;
}

if (!preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i", $email)) {
    $error = 1;
    $_SESSION["error_email"] = "Некорректный E-mail адрес";
    $_SESSION["email"] = $email;
}
if ($url <> ""){
    if (!preg_match('/^(http:\/\/|https:\/\/)?[0-9a-zA-Zа-яА-ЯёЁ]{1,3}+[.][0-9a-zA-Zа-яА-ЯёЁ]+[.][0-9a-zA-Zа-яА-ЯёЁ]{2,6}+$/', $url)) {
        $error = 1;
        $_SESSION["error_url"] = "Некорректный url";
        $_SESSION["url"] = $url;
    }
}

if (strlen($message)<3){
    $error = 1;
    $_SESSION["error_message"] = "Длина сообщения не менее 3х символов";
    $_SESSION["message"] = $message;
}

if ($_SESSION["capcha"] <> md5($capchainput)){
    $error = 1;
    $_SESSION["error_capcha"] = "Неверный код";
}

$_SESSION['data_send'] = 1;

if ($error <> 1){
    $result = $link->query("INSERT INTO `records` (`indexx`, `ip`, `brouser`, `user`, `email`, `homepage`, `message`, `date`) VALUES (NULL, '".$ip."', '".$browser."', '".$user."', '".$email."', '".$url."', '".$message."', '".$date."')");
}

header('Location:../index.php');

exit;

?>