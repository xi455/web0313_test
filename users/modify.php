<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>

<style>
    .header {
        text-align: center;
        border-bottom: 1px solid #333;
    }

    .container {
        min-height: 50vh;
        border: 1px solid #333;
        margin-top: 10px;

        display: flex;
        justify-content: center;
        align-items: center;
    }

    form {
        border: 1px solid #333;
        border-radius: 5px;
        padding: 5px 10px;
    }

    h2{
        text-align: center;
    }

    .inp{
        border: 1px solid #333;
        border-radius: 5px;
        padding: 5px 10px;
    }

    .btn{
        border: 1px solid #333;
        border-radius: 5px;
        padding: 5px 10px;
    }
</style>
<body>

<?php
    include ('../link.php');

    $sql = $db->prepare('select * from users where id=:id');
    $sql->bindValue('id',$_GET['id']);
    $sql->execute();

    $query = $sql->fetch();
?>

<div class="header">
    <h1>coffee</h1>
</div>

<div class="container">
    <form action="./modifyprocess.php" method="post">
        <h2>modify</h2>
        <p>
            帳號: <input type="text" class="inp" name="user" value="<?php echo $query['username']?>" placeholder="請輸入帳號">
        </p>
        <p>
            密碼: <input type="text" class="inp" name="password" value="<?php echo $query['password']?>" placeholder="請輸入密碼">
        </p>

        <!--    <div class="captcha" style="text-align: center"></div>-->

        <!--    <p>-->
        <!--      驗證: <input type="text" class="inp" name="captcha_user" placeholder="請輸入驗證碼">-->
        <!--      <input type="hidden" name="captcha_server" class="captcha_server">-->
        <!--    </p>-->

        <p>
            權限: <select class="inp" name="role" id="">
                <option value="會員">會員</option>
                <option value="一般管理者">一般管理者</option>
                <!--        <option value="會員">超級管理</option>-->
            </select>
        </p>

        <p style="text-align: center">
            <!--      <button type="button" class="btn" onclick="restart()">刷新</button>-->
            <input type="hidden" name="id" value="<?php echo $query['id']?>">
            <input type="submit" class="btn" value="送出">
            <input type="reset" class="btn" value="重設">
        </p>
    </form>
</div>

</body>
</html>