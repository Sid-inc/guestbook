<form action="modules/addrecord.php" method="post">
    <p>Имя пользователя* <h4 class="error"><?=$_SESSION["error_user"]?></h4><input class="txtfield" type="text" name="user" placeholder="Логин" value="<?=$_SESSION["user"]?>"/></p>
    <p>Адрес электронной почты* <h4 class="error"><?=$_SESSION["error_email"]?></h4><input class="txtfield" type="text" name="email" placeholder="E-mail" value="<?=$_SESSION["email"]?>"/></p>
    <p>Ссылка на домашнюю страницу <h4 class="error"><?=$_SESSION["error_url"]?></h4><input class="txtfield" type="text" name="url" placeholder="http://" value="<?=$_SESSION["url"]?>"/></p>
    Сообщение* <h4 class="error"><?=$_SESSION["error_message"]?></h4><textarea name="message"><?=$_SESSION["message"]?></textarea>
    <p>Введите текст с картинки* <h4 class="error"><?=$_SESSION["error_capcha"]?></h4></p>
    <p><img id="capcha" src="img/capcha.png"> <input id="capchafield" type="text" name="capchainput"/></p>
    <p><input id="sendbtn" type="submit" name="send" value="Отправить"/></p>
</form>