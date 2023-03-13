<?php

include('./link.php');

if ($_POST['captcha_server'] == $_POST['captcha_user']) {
    $sql = $db->prepare('select * from users where username=:user');
    $sql->bindValue('user', $_POST['user']);
    $sql->execute();
    $query = $sql->fetch();

    if ($query) {
        if ($query['password'] == $_POST['password']) {
            $_SESSION['user'] = $query;
            echo "<script>location.href='captcha_twice.html';</script>";
//            echo "<script>location.href='timeprocess.php';</script>";
        } else {
            $_SESSION['num'] += 1;
            echo "<script>alert('密碼錯誤')</script>";
        }
    } else {
        $_SESSION['num'] += 1;
        echo "<script>alert('帳號錯誤')</script>";
    }
} else {
    $_SESSION['num'] += 1;
    echo "<script>alert('驗證碼錯誤')</script>";
}

if ($_SESSION['num'] >= 3) {
    echo "<script>alert('錯誤已滿三次')</script>";
    $_SESSION['num'] = 0;
}

$_SESSION['loser'] = $_POST['user'];
echo "<script>location.href='./timeprocess.php';</script>";
