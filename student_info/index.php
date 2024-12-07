<?php 
include('../includes/head.php');
include('../includes/header.php');

$result = $conn->query('select * from sinhvien');
?>

<div class='container'>
    <h1 class='mt-2'>Sinh viên</h1>
    <button type="button" class="btn btn-info mb-2">Thêm mới sinh viên</button>
    <table class="table table-hover">
    <thead>
        <tr class='table-active'>
        <th scope="col">ID</th>
        <th scope="col">Tên sinh viên</th>
        <th scope="col">Lớp</th>
        <th scope="col">Địa chỉ</th>
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
                        <td>'. $row['sdt'] .'</td>
                        <td><button type="button" class="btn btn-warning">Sửa</button></td>
                        <td><button type="button" class="btn btn-danger">Xóa</button></td>
                        </tr>';
                }
            }
        ?>
    </tbody>
    </table>
</div>
