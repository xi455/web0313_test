<?php
include('../link.php');

var_dump($_POST);
if (isset($_FILES['image'])) {
    $imagename = date("YmdHis");
    $imagepath = "./images/$imagename.png";
    move_uploaded_file($_FILES['image']['tmp_name'], "." . $imagepath);

    $sql = $db->prepare('insert into layouts (name, date, link, description, price, image, layouts) values (:name, :date, :link, :description, :price, :image, :layout)');

    $sql->bindValue('name', $_POST['name']);
    $sql->bindValue('date', $_POST['date']);
    $sql->bindValue('link', $_POST['link']);
    $sql->bindValue('description', $_POST['description']);
    $sql->bindValue('price', $_POST['price']);
    $sql->bindValue('image', $imagepath);
    $sql->bindValue('layout', $_POST['layout']);

    $sql->execute();
    header('location:./index.php');
}

