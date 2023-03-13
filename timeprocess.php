<?php

include('./link.php');

$sql = $db->prepare('insert into usertime (name, state, succend) values(:name, :state, :succend)');


if (isset($_SESSION['user'])) {
    $sql->bindValue('name', $_SESSION['user']['username']);
    $sql->bindValue('state', "登入");
    $sql->bindValue('succend', 1);
} else {
    if (empty($_SESSION['loser']) == true) {
        $loser = "未填寫";
    } else {
        $loser = $_SESSION['loser'];
    }
    $sql->bindValue('name', $loser);
    $sql->bindValue('state', "登入");
    $sql->bindValue('succend', 0);
    var_dump($loser);
}
$sql->execute();
//unset($_SESSION['user']);
header('location:./index.php');