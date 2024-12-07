<?php 
include('../includes/head.php');
include('../includes/header.php');
$result = $conn->query('select * from sinhvien');
?>


<div class='container'>
    <h1 class='mt-2'>Các môn đã đăng kí</h1>
    <table class="table table-hover">
    <thead>
        <tr class='table-active'>
        <th scope="col">Tên sinh viên</th>
        <th scope="col">Lớp</th>
        <th scope="col" colspan="2">Tùy chọn</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>
                        <td>'. $row['ten'] .'</td>
                        <td>'. $row['lop'] .'</td>
                        <td><button type="button" class="btn btn-primary">Xem chi tiết</button></td>
                        </tr>';
                }
            }
        ?>
    </tbody>
    </table>
</div>
