<?php


include ('../link.php');

$sql = $db->prepare('delete from users where id=:id');
$sql->bindValue('id', $_GET['id']);
$sql->execute();

header('location:./index.php');