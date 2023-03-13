<?php

include ('../link.php');

$sql = $db->prepare('insert into users (username, password, role) values(:user, :password, :role)');
$sql->bindValue('user', $_POST['user']);
$sql->bindValue('password', $_POST['password']);
$sql->bindValue('role', $_POST['role']);
$sql->execute();

header('location:./index.php');