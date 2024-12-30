<?php 
include('../includes/head.php');
include('../includes/header.php');
$sinhvienQuery = $conn->query('select * from sinhvien');
?>


<div class='container'>
    <h1 class='mt-2'>Kết quả học tập</h1>

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
            if ($sinhvienQuery->num_rows > 0) {
                while ($sv = $sinhvienQuery->fetch_assoc()) {
                    echo '<tr>
                        <td>'. $sv['ten'] .'</td>  
                        <td>'. $sv['lop'] .'</td>
                        <td><a href="./detail.php?sinhvienId='.$sv['id'].'" class="btn btn-primary">Xem chi tiết</a></td>
                        </tr>';
                }
            }
        ?>
    </tbody>
    </table>
</div>
