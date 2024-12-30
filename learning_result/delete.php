<?php
include('../includes/head.php');
include('../includes/header.php');
$conn->query("delete from diemso where id = " . $_GET['id']);
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>