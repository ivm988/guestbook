<?php
//Количество выводимых на странице записей
$num = 3;
$page = $_GET['page'];
//Запрос количества записей в таблице
$result00 = mysql_query("SELECT COUNT(*) FROM messages");
$temp = mysql_fetch_array($result00);
$posts = $temp[0];
//Количество страниц пагинации
$total = (($posts - 1) / $num) + 1;
$total =  intval($total);
$page = intval($page);
if(empty($page) or $page < 0){
    $page = 1;
}
if($page > $total){
    $page = $total;
}
$start = $page * $num - $num;       
        
$result = mysql_query("SELECT * FROM messages ORDER BY id DESC LIMIT $start, $num");


    if ($page != 1) $prevpage = '<li><a href='. ($page - 1) .'><span aria-hidden="true">&laquo;</span></a></li>';

    if ($page != $total) $nextpage = '<li><a href='. ($page + 1) .'><span aria-hidden="true">&raquo;</span></a></li>';


    if($page - 5 > 0) $page5left = '<li><a href='. ($page - 5) .'>'. ($page - 5) .'</a></li>';
    if($page - 4 > 0) $page4left = '<li><a href='. ($page - 4) .'>'. ($page - 4) .'</a></li>';
    if($page - 3 > 0) $page3left = '<li><a href='. ($page - 3) .'>'. ($page - 3) .'</a></li>';
    if($page - 2 > 0) $page2left = '<li><a href='. ($page - 2) .'>'. ($page - 2) .'</a></li>';
    if($page - 1 > 0) $page1left = '<li><a href='. ($page - 1) .'>'. ($page - 1) .'</a></li>';

    if($page + 5 <= $total) $page5right = '<li><a href='. ($page + 5) .'>'. ($page + 5) .'</a></li>';
    if($page + 4 <= $total) $page4right = '<li><a href='. ($page + 4) .'>'. ($page + 4) .'</a></li>';
    if($page + 3 <= $total) $page3right = '<li><a href='. ($page + 3) .'>'. ($page + 3) .'</a></li>';
    if($page + 2 <= $total) $page2right = '<li><a href='. ($page + 2) .'>'. ($page + 2) .'</a></li>';
    if($page + 1 <= $total) $page1right = '<li><a href='. ($page + 1) .'>'. ($page + 1) .'</a></li>';

?>