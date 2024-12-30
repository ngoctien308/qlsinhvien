<?php
include('../includes/head.php');
include('../includes/header.php');
$conn->query("delete from sinhvien where id=".$_GET['sinhvienId']);
header('location: ./index.php');
?>