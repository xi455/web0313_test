<?php

include ('../link.php');

$sql = $db->prepare('update settime set time=:time');
$sql->bindValue('time',intval($_POST['time']));

$sql->execute();
header('location:./index.php');
//var_dump(intval($_POST['time']));
