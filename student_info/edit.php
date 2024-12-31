<?php
include('../includes/head.php');
include('../includes/header.php');

$sv = $conn->query("select * from sinhvien where id = ".$_GET['sinhvienId'])->fetch_assoc();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten = $_POST['ten'];
    $diachi = $_POST['diachi'];
    $lop = $_POST['lop'];
    $email = $_POST['email'];
    $sdt = $_POST['sdt'];
    try {
        $checkEmail = $conn->query("select * from sinhvien where email='".$_POST['email']."'");        
        $conn->query("update sinhvien set ten='".$ten."',diachi='".$diachi."',email='".$email."',sdt='".$sdt."',lop='".$lop."' where id=".$_GET['sinhvienId']);
        header('location: ./index.php');
    } catch (Exception $e) {
        echo '<script>alert("Có lỗi xảy ra: '.$e->getMessage().'")</script>';
    } 
}
?>

<div class='container'>
    <form method='post'>
        <div class='mb-2'>
            <label>Tên sinh viên</label>
            <input class='form-control' name='ten' value="<?php echo $sv['ten'];  ?>" />
        <div>
        <div class='mb-2'>
            <label>Địa chỉ</label>
            <input class='form-control' name='diachi' value="<?php echo $sv['diachi'];  ?>" />
        <div>
        <div class='mb-2'>
            <label>Email</label>
            <input class='form-control' name='email' value="<?php echo $sv['email'];  ?>" />
        <div>
        <div class='mb-2'>
            <label>Lớp</label>
            <input class='form-control' name='lop' value="<?php echo $sv['lop'];  ?>" />
        <div>
        <div class='mb-2'>
            <label>SDT</label>
            <input class='form-control' name='sdt' value="<?php echo $sv['sdt'];  ?>" />
        <div>
        <button class='mt-2 btn btn-primary'>Cập nhật</button>
    </form>
</div>

           