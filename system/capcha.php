<?php
//Посылаем HTTP заголовок
header('Content-Type: text/html, image/png');
//Список символов в капче
$all = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789";
session_start();
//Количество символов в строке
$cnt = strlen($all) - 1;
srand((double)microtime()*1000000);
//Случайный выбор символов
for($i=0; $i < 4; $i++){
	$string .= $all[rand(0, $cnt)];
}
//Сохранение символов
$_SESSION['capcha'] = $string;
//Шрифт
$dir = 'fonts/cour.ttf';
//Размеры капчи
$image = imagecreatetruecolor(250, 50);
//Цвет текста
$color = imagecolorallocate($image, 0, 0, 0);
//Цвет фона
$bg = imagecolorallocate($image, 255, 255, 255);
imagefilledrectangle($image,0,0,399,99,$bg);
imagettftext ($image, 30, 0, 10, 40, $color, $dir, $_SESSION['capcha']);
imagepng($image);
imagedestroy($image);
