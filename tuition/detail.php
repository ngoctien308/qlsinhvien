<?php 
include('../includes/head.php');
include('../includes/header.php');

$svQuery = $conn->query("select * from sinhvien where id = ".$_GET['sinhvienId']);
$sv = $svQuery->fetch_assoc();

$thongtinsql = "select sinhvien.ten as 'tensv', sinhvien.lop, monhoc.ten as 'tenmonhoc', monhoc.sotinchi, dangkimonhoc.sotien1tin, dangkimonhoc.daThanhToan from dangkimonhoc inner join sinhvien on sinhvien.id=sinhvienId inner join monhoc on monhoc.id=monhocId where sinhvienId = ".$_GET['sinhvienId'];
$thongtinQuery = $conn->query($thongtinsql);

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn -> query("update dangkimonhoc set daThanhToan=1 where sinhvienId=".$_GET['sinhvienId']);
    header("Refresh: 1");
}
?>


<div class='container'>
    <h1 class='mt-2'>Thông tin Học phí của sinh viên <?php echo $sv['ten'] ?> </h1>
    <table class="table table-hover">
    <thead>
        <tr class='table-active'>
        <th scope="col">Tên sinh viên</th>
        <th scope="col">Lớp</th>
        <th scope="col">Tên môn học</th>
        <th scope="col">Số tín chỉ</th>
        <th scope="col">Số tiền 1 tín</th>
        <th scope="col">Tổng tiền</th>
        <th scope="col">Trạng thái</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if ($thongtinQuery->num_rows > 0) {
                while ($thongtin = $thongtinQuery->fetch_assoc()) {
                    $daThanhtoan = 'Chưa thanh toán';
                    if($thongtin['daThanhToan'] == 1) {
                        $daThanhtoan = 'Đã thanh toán';
                    }

                    echo '<tr>
                        <td>'. $thongtin['tensv'] .'</td>
                        <td>'. $thongtin['lop'] .'</td>
                        <td>'. $thongtin['tenmonhoc'] .'</td>
                        <td>'. $thongtin['sotinchi'] .'</td>
                        <td>'. $thongtin['sotien1tin'] .'</td>
                        <td>'. $thongtin['sotien1tin'] * $thongtin['sotinchi'] .'</td>
                        <td>'. $daThanhtoan .'</td>                        
                        </tr>';
                }
            }
        ?>
    </tbody>
    </table>
    <form method='post'><button class='btn btn-warning'>Thanh toán</button></form>
</div>