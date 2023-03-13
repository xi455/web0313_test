<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="../js/jquery-ui.min.css">
    <link rel="stylesheet" href="../js/jquery-ui.structure.min.css">
    <link rel="stylesheet" href="../js/jquery-ui.theme.min.css">
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

    form {
        text-align: center;
        border-bottom: 1px solid #333;
    }

    .inp {
        width: 50%;
        border: 1px solid #333;
        border-radius: 5px;
        padding: 5px 10px;
    }

    .container {
        min-height: 50vh;
        border: 1px solid #333;
        border-radius: 5px;
        margin: 5px;

        overflow: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    td {
        border: 1px solid #333;
    }
</style>
<body>
<?php
include('../link.php');

if (isset($_SESSION['user']) == false) {
    header('location:../login.html');
}
?>

<div class="header">
    <h1>coffer user</h1>

    <?php
    if ($_SESSION['user']['role'] == "超級管理者" || $_SESSION['user']['role'] == "一般管理者") {
        ?>
        <!--        <button class="btn" onclick="location.href='users'">帳戶管理</button>-->
        <button class="btn" onclick="location.href='add.html'">新增</button>
        <button class="btn" onclick="set_time()">時間設定</button>
        <button class="btn" onclick="restart()">重新計時</button>
        <?php
    }
    ?>

    <button class="btn" onclick="location.href='../'">返回</button>
</div>

<div class="menu">
    <form action="" method="GET">
        <input class="inp" type="text" name="select" placeholder="請輸入搜尋關鍵字">

        <select class="btn" name="db_name" id="">
            <option value="id">id</option>
            <option value="username">username</option>
            <option value="password">password</option>
            <option value="role">role</option>
        </select>
        <select class="btn" name="asc_desc" id="">
            <option value="asc">asc</option>
            <option value="desc">desc</option>
            <!--        <option value="password">password</option>-->
            <!--        <option value="role">role</option>-->
        </select>

        <button class="btn">搜尋</button>
    </form>
</div>

<div class="container">
    <table>
        <tr>
            <td>ID</td>
            <td>username</td>
            <td>password</td>
            <td>role</td>
            <td>state</td>
        </tr>

        <?php
        $select = $_GET['select'] ?? "";
        $db_name = $_GET['db_name'] ?? "id";
        $asc_desc = $_GET['asc_desc'] ?? "asc";
        $sql = $db->prepare("select * from users where username like '%$select%' order by $db_name $asc_desc");
        $sql->execute();
        $query = $sql->fetchAll();

        foreach ($query as $data) {
            ?>
            <tr>
                <td><?php echo $data['id'] ?></td>
                <td><?php echo $data['username'] ?></td>
                <td><?php echo $data['password'] ?></td>
                <td><?php echo $data['role'] ?></td>
                <td>
                    <a href="./modify.php?id=<?php echo $data['id'] ?>">操作</a>
                    <a href="./delete.php?id=<?php echo $data['id'] ?>">刪除</a>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>
</body>

<script src="../js/jquery.js"></script>
<script src="../js/jquery-ui.min.js"></script>

<?php
    $sql = $db->prepare('select * from settime');
    $sql->execute();
    $query = $sql->fetch();

//    var_dump($query['time']);
?>
<script>
    let t = <?php echo $query['time']?>;
    let timeout = ""
    let timeintval = ""

    function time_out() {
        timeout = setTimeout(function () {
            console.log('timeout')
            // location.href = "../timeprocess.php?logout=logout";
        }, 5000)
    }

    function time_intval() {
        timeintval = setInterval(function () {
            dialog();
        }, (1000 * t))
    }

    function dialog() {
        $('body').append("<div id='dialog' title='logout'>是否登出</div>")

        time_out();
        $("#dialog").dialog({
            width: 300,
            height: 300,

            buttons: {
                "確定": function () {
                    console.log('true')
                    location.href = "../timeprocess.php?logout=logout"
                    $("#dialog").remove()
                },
                "取消": function () {
                    console.log('false')
                    clearTimeout(timeout)
                    $("#dialog").remove()
                }
            }
        })
    }

    time_intval();

    // dialog();

    function set_time() {
        t = prompt("時間設定")
        if (!t) {
            t = 60
        }

        $.post("settimeprocess.php", {time: t}, function (data){
            console.log(data)
        })

        clearInterval(timeintval);
        time_intval();
    }

    function restart() {
        clearInterval(timeintval);
        time_intval();
    }
</script>
</html>