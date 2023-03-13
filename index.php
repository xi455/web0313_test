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

    .inp {
        width: 30%;
        border: 1px solid #333;
        border-radius: 5px;
        padding: 5px 10px;
    }

    form {
        text-align: center;
        border-bottom: 1px solid #333;
    }

    .layouts {
        width: 300px;
        border: 1px solid #333;
        border-radius: 5px;
        padding: 5px 10px;
        margin: 5px;
    }

    .layout_div {
        border: 1px solid #333;
        border-radius: 5px;
        padding: 5px 10px;
        margin: 5px;
        text-align: center;
    }

    img {
        width: 100%;
        border-radius: 5px;
    }

    .container {
        padding: 5px 10px;
        display: flex;
        justify-content: space-evenly;
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

<div class="menu">
    <form action="" method="GET">
        <input class="inp" type="text" name="price_min" placeholder="price min">
        <input class="inp" type="text" name="price_max" placeholder="price max">
        <button class="btn">搜尋</button>
    </form>
</div>

<div class="container">
    <?php
    $price_min = $_GET['price_min'] ?? "0";
    $price_max = $_GET['price_max'] ?? "1000";
    $sql = $db->prepare("select * from layouts where price between $price_min and $price_max");
    $sql->execute();
    $query = $sql->fetchAll();

    foreach ($query as $item) {
        $layout = json_decode($item["layouts"]);
        ?>
        <div class="layouts">
            <?php
            if ($_SESSION['user']['role'] == "超級管理者" || $_SESSION['user']['role'] == "一般管理者") {
                ?>
                <a href="./layout_edit.php?id=<?php echo $item["id"] ?>">修改</a>
                <?php
            }
            ?>
            <?php
            foreach ($layout as $data) {
                if ($data === "image") {
                    ?>
                    <img src="<?php echo $item[$data] ?>" alt="image">
                    <?php
                } else {
                    ?>
                    <div class="layout_div"><?php echo $data . ":" . $item["$data"] ?></div>
                    <?php
                }
            }
            ?>
        </div>
        <?php
    }
    ?>

</div>
</body>
</html>