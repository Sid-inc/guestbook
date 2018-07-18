<form action="modules/addrecord.php" method="post">
<?php
    echo '<p>Имя пользователя* ';
    if (!empty($_SESSION["error_user"])) {
        echo '<h4 class="error">'.$_SESSION["error_user"].'</h4>';
    }
    echo '<input ';
    if ((!empty($_SESSION["error"])) && ($_SESSION["error"]=1)) {
        echo 'value="'.$_SESSION["user"].'"';
    }    
    echo 'class="txtfield" type="text" name="user" placeholder="Логин" /></p>';
    echo '<p>Адрес электронной почты* ';
    if (!empty($_SESSION["error_email"])) {
        echo '<h4 class="error">'.$_SESSION["error_email"].'</h4>';
    }
    echo '<input ';
    if ((!empty($_SESSION["error"])) && ($_SESSION["error"]=1)) {
       echo 'value="'.$_SESSION["email"].'"';
    }
    echo 'class="txtfield" type="text" name="email" placeholder="E-mail"/></p>';
    echo '<p>Ссылка на домашнюю страницу ';
    if (!empty($_SESSION["error_url"])) {
        echo '<h4 class="error">'.$_SESSION["error_url"].'</h4>';
    }
    echo '<input ';
    if ((!empty($_SESSION["error"])) && ($_SESSION["error"]=1)) {
        echo 'value="'.$_SESSION["url"].'"';   
    }
    echo 'class="txtfield" type="text" name="url" placeholder="http://"/></p>';
    echo 'Сообщение* ';
    if (!empty($_SESSION["error_message"])) {
        echo '<h4 class="error">'.$_SESSION["error_message"].'</h4>';
    }
    echo '<textarea name="message">';
    if ((!empty($_SESSION["error"])) && ($_SESSION["error"]=1)) {
        echo $_SESSION["message"];  
    }   
    echo '</textarea>';
    echo '<p>Введите текст с картинки* ';
    if (!empty($_SESSION["error_capcha"])) {
        echo '<h4 class="error">'.$_SESSION["error_capcha"].'</h4>';
    }
    echo '</p>';
    echo '<p><img id="capcha" src="img/capcha.png"> <input id="capchafield" type="text" name="capchainput"/></p>';
    echo '<p><input id="sendbtn" type="submit" name="send" value="Отправить"/></p>';
?>
</form>
