<?php
//Переменные для подключения к базе
$db_host = 'localhost';
$db_name = 'guestbook';
$db_user = 'root';
$db_pass = '';
//Соединение с базой
$db_connect = mysql_connect($db_host, $db_user, $db_pass);
if(!$db_connect){
	exit('No connect to MYSQL server');
}
//Выбор таблицы
$dbuse = mysql_select_db($db_name, $db_connect);
if(!$dbuse){
	exit('No DATABASE connection');
}