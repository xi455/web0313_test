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

    .menu > .active {
        background-color: #bbb;
    }

    .layouts {
        border: 1px solid #333;
        border-radius: 5px;
        padding: 5px 10px;
    }

    .select_layout {
        border: 1px solid #333;
        border-radius: 5px;
        padding: 5px 10px;
        margin: 5px;
    }

    .select_layout.active {
        background-color: #bbb;
    }

    .layout_btn {
        border: 1px solid #333;
        border-radius: 5px;
        text-align: center;
        padding: 5px 10px;
        margin: 5px;
    }

    label {
        display: block;
    }

    .layout_preview {
        border: 1px solid #333;
        border-radius: 5px;
        width: 200px;
        margin: 5px;
    }

    img {
        width: 100%;
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
    <h1>coffer layouts</h1>

    <button class="btn" onclick="location.href='./'">返回</button>
</div>

<div id="app">
    <div class="menu">
        <button class="btn" v-for="(value,key) in pages" :key="value" :class="{active:page === value}"
                @click="page = value">{{key}}
        </button>
    </div>

    <div class="layouts" v-show="page === 0" style="display: flex">
        <div v-for="(value,index) in layouts"
             :key="index"
             class="select_layout"
             :class="{active:SelectLayout === index}"
             @click="SelectLayout = index">
            <div v-for="(v,i) in value"
                 class="layout_btn"
                 :key="v"
                 :data-index="index"
                 :data-key="i"
                 draggable="true"
                 @dragstart="onDrag"
                 @dragover.prevent=""
                 @drop="onDrop"

            >{{v}}
            </div>
        </div>
    </div>

    <?php
        $sql = $db->prepare('select * from layouts where id=:id');
        $sql->bindValue('id', $_GET['id']);
        $sql->execute();
        $query = $sql->fetch();
    ?>

    <div class="layouts" v-show="page === 1">
        <form action="layout_editprocess.php" method="post" enctype="multipart/form-data">
            <label for="">圖片</label>
            <input type="file" name="image" @change="onupload">
            <label for="">姓名</label>
            <input type="text" name="name" v-model="payload.name">
            <label for="">日期</label>
            <input type="date" name="date" v-model="payload.date">
            <label for="">連結</label>
            <input type="text" name="link" v-model="payload.link">
            <label for="">介紹</label>
            <textarea name="description" v-model="payload.description" id="" cols="30" rows="10"></textarea>
            <!--        <input type="text" name="description" >-->
            <label for="">價格</label>
            <input type="number" name="price" v-model="payload.price">
            <input type="hidden" name="layout" class="layout_1">
            <input type="hidden" name="id" value="<?php echo $query['id']?>">
        </form>
    </div>

    <div class="layouts" v-show="page === 2">
        <div class="layout_preview" v-for="key in layouts[SelectLayout]" v-html="preview(key)"></div>
    </div>

    <div class="layouts" v-show="page === 3">
        <button class="btn" @click="onSub">送出</button>
    </div>
</div>

</body>

<script src="./js/vue.js"></script>
<script src="./js/jquery.js"></script>

<script>
    const app = Vue.createApp({
        data() {
            return {
                page: 1,
                pages: {
                    "選擇版型": 0,
                    "賣家資料": 1,
                    "預覽": 2,
                    "送出": 3,
                },

                layouts: [
                    [
                        "image",
                        "name",
                        "date",
                        "link",
                        "description",
                        "price",
                    ],
                    [
                        "date",
                        "image",
                        "name",
                        "price",
                        "link",
                        "description",
                    ]
                ],

                layoutData: {
                    "image": "圖片",
                    "name": "姓名",
                    "date": "日期",
                    "link": "連結",
                    "description": "介紹",
                    "price": "價格",
                },

                payload: {
                    "image": "",
                    "name": "<?php echo $query['name']?>" ?? "",
                    "date": "<?php echo $query['date']?>" ?? "",
                    "link": "<?php echo $query['link']?>" ?? "",
                    "description": "<?php echo $query['description']?>" ?? "",
                    "price": "<?php echo $query['price']?>" ?? "",
                },

                SelectLayout: 0,
                dragIndex: "",
                dragKey: "",
            }
        },
        methods: {
            onDrag(e) {
                this.dragIndex = e.target.dataset.index
                this.dragKey = e.target.dataset.key
            },
            onDrop(e) {
                const dropIndex = e.target.dataset.index
                const dropKey = e.target.dataset.key

                if (dropIndex === this.dragIndex) {
                    [this.layouts[this.dragIndex][this.dragKey], this.layouts[dropIndex][dropKey]] = [this.layouts[dropIndex][dropKey], this.layouts[this.dragIndex][this.dragKey]]
                }
            },
            onupload(e) {
                let file = e.target.files[0]
                let reader = new FileReader()
                reader.readAsDataURL(file)
                reader.onload = () => {
                    this.payload.image = reader.result
                }
            },
            preview(key) {
                if (key === "image") {
                    return `<img src='${this.payload[key]}' alt="image">`
                } else if (key === "price") {
                    return `價格:${this.payload[key]}`
                }
                return this.payload[key]
            },
            onSub() {
                if (confirm("是否送出")) {
                    $('.layout_1').attr('value', JSON.stringify(this.layouts[this.SelectLayout]))
                    $('form').submit();
                    alert("送出成功")
                }
            }
        }
    })

    app.mount("#app")
</script>
</html>