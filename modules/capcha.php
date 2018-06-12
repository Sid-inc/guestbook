<?php

function capcha_code_gen() {
    $symbolarray = array ('a','b','c','d','e','f','h','k','m','n','o','p','s','t','w','x','z','2','3','4','5','6','7','8','9');
    $for_capcha_string = '';
    for ($i = 1; $i <= 6; $i++) {
        $for_capcha_string = $for_capcha_string.$symbolarray[rand(0, 24)];    
    } 
    return $for_capcha_string;
}

function capcha_gen() {
    $img = imagecreate(100,40);

    $black = ImageColorAllocate( $img, 255, 255, 255 );
    $red = ImageColorAllocate( $img, 255, 0, 0 );
    $font = 'D:\xampp\htdocs\guestbook.ru\modules\font\arial.ttf';
    $text = capcha_code_gen();

    for ($i = 1; $i < 15; $i++) {
    
        $color = ImageColorAllocate( $img, rand(0, 255), rand(0, 255), rand(0, 255) );
        imagesetthickness($img, rand(1, 4));
        ImageLine( $img, rand(1, 99), rand(1, 39), rand(1, 99), rand(1, 39), $color );

    }
    for ($j = 0; $j <= 5; $j++) {
        $color = ImageColorAllocate( $img, 255, 0, 0 );
        imagettftext($img, rand(18, 22), rand(-10,10), 10+$j*14, rand(28, 32), $color, $font, $text[$j]);
    }

    //header('Content-type: image/png' );

    ImageGif( $img, "img/capcha.png"); 

    return md5($text);

}

?>