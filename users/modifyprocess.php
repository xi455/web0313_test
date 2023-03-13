<?php


include ('../link.php');

$sql = $db->prepare('update users set username=:user, password=:password, role=:role where id=:id');
$sql->bindValue('user', $_POST['user']);
$sql->bindValue('password', $_POST['password']);
$sql->bindValue('role', $_POST['role']);
$sql->bindValue('id', $_POST['id']);

$sql->execute();
header('location:./index.php');