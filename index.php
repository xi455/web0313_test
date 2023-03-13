<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<style>
    .header {
        border-bottom: 1px solid #333;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .btn {
        border: 1px solid #333;
        border-radius: 5px;
        padding: 5px 10px;
        margin: 5px;
    }
</style>
<body>
<?php
include('./link.php');

if (isset($_SESSION['user']) == false) {
    header('location:./login.html');
}
?>

<div class="header">
    <h1>coffer main</h1>

    <?php
    if ($_SESSION['user']['role'] == "超級管理者" || $_SESSION['user']['role'] == "一般管理者") {
        ?>
        <button class="btn" onclick="location.href='users'">帳戶管理</button>
        <button class="btn" onclick="location.href='layouts'">商品上架</button>
        <?php
    }
    ?>

    <button class="btn" onclick="location.href='./timeprocess.php?logout=logout'">登出</button>
</div>
</body>
</html>