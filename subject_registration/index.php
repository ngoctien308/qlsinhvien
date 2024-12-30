<?php 
include('../includes/head.php');
include('../includes/header.php');

$svQuery = $conn->query('select * from sinhvien');
?>


<div class='container mt-2'>
    <h1>Xem thông tin đăng kí học tập</h1>
    <table class="table">
        <thead>
            <tr>
            <th scope="col">Tên</th>
            <th scope="col">Lớp</th>
            <th scope="col">Tùy chọn</th>
            </tr>
        </thead>
        <tbody>
            <?php
                if ($svQuery->num_rows > 0) {
                    while ($sv = $svQuery->fetch_assoc()) {
                        echo '<tr>
                            <td>'.$sv['ten'].'</td>
                            <td>'.$sv['lop'].'</td>
                            <td><a class="btn btn-primary" href="./detail.php?sinhvienId='.$sv['id'].'">Xem chi tiết</a></td>
                            </tr>';
                    }
                }
            ?>
            
        </tbody>
    </table>
</div>
