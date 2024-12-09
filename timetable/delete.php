<?php
include('../includes/head.php');
include('../includes/header.php');

$conn->query("delete from thoikhoabieu where id = ".$_GET['id']);
header('location: ./detail.php?sinhvienId='.$_GET['sinhvienId']);
?>