

<?php
$my_server_img = 'https://d1wwy9ao3iinzu.cloudfront.net/img/banner/PC/acpc_home_banner12_edit.jpg';
$img = imagecreatefromjpeg($my_server_img);
$path = 'images_saved/';
imagejpeg($img, $path);
?>

