<?php
include('../includes/head.php');
include('../includes/header.php');
$conn->query("delete from thoikhoabieu where sinhvienId=".$_GET['sinhvienId']);
$conn->query("delete from diemso where sinhvienId=".$_GET['sinhvienId']);
$conn->query("delete from thanhtoan where sinhvienId=".$_GET['sinhvienId']);
$conn->query("delete from dangkimonhoc where sinhvienId=".$_GET['sinhvienId']);
$conn->query("delete from sinhvien where id=".$_GET['sinhvienId']);
header('location: ./index.php');
?>