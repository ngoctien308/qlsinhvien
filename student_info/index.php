<?php 
include('../includes/head.php');
include('../includes/header.php');

$result = $conn->query('select * from sinhvien');

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten = $_POST['ten'];
    $diachi = $_POST['diachi'];
    $lop = $_POST['lop'];
    $email = $_POST['email'];
    $sdt = $_POST['sdt'];
    $conn->query("insert into sinhvien (ten, diachi, lop, email, sdt) values('".$ten."','".$diachi."','".$lop."','".$email."','".$sdt."')");
    header("Refresh: 1");
}

?>

<div class='container'>
    <h1 class='mt-2'>Sinh viên</h1>
    <button type="button" class="btn btn-info mb-2" data-bs-toggle="modal" data-bs-target="#exampleModal">Thêm mới sinh viên</button>
    <table class="table table-hover">
    <thead>
        <tr class='table-active'>
        <th scope="col">ID</th>
        <th scope="col">Tên sinh viên</th>
        <th scope="col">Lớp</th>
        <th scope="col">Địa chỉ</th>
        <th scope="col">Email</th>
        <th scope="col">SDT</th>
        <th scope="col" colspan="2">Tùy chọn</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>
                        <th scope="row">'. $row['id'] .'</th>
                        <td>'. $row['ten'] .'</td>
                        <td>'. $row['lop'] .'</td>
                        <td>'. $row['diachi'] .'</td>
                        <td>'. $row['email'] .'</td>
                        <td>'. $row['sdt'] .'</td>
                        <td><a href="./edit.php?sinhvienId='.$row['id'].'" type="button" class="btn btn-warning">Sửa</a></td>
                        <td><a href="./delete.php?sinhvienId='.$row['id'].'" type="button" class="btn btn-danger">Xóa</a></td>
                        </tr>';
                }
            }
        ?>

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method='post'>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tên sinh viên</label>
                        <input name='ten' class="form-control" placeholder="Tên sinh viên">
                    </div>                
                    <div class="mb-3">
                        <label class="form-label">Lớp</label>
                        <input name='lop' class="form-control" placeholder="Lớp">
                    </div>                
                    <div class="mb-3">
                        <label class="form-label">Địa chỉ</label>
                        <input name='diachi' class="form-control" placeholder="Địa chỉ">
                    </div>                
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input name='email'class="form-control" type='email' placeholder="Email">
                    </div>                
                    <div class="mb-3">
                        <label class="form-label">Sdt</label>
                        <input name='sdt'class="form-control" placeholder="Sdt">
                    </div>                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button name='btnThem' type="submit" class="btn btn-primary">Thêm</button>
                </div>
            </form>
            </div>
        </div>
        </div>
    </tbody>
    </table>
</div>
