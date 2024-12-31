<?php 
include('../includes/head.php');
include('../includes/header.php');

$thongtinQuery = $conn->query("select * from thanhtoan
 inner join sinhvien on sinhvien.id=thanhtoan.sinhvienId 
 inner join monhoc on monhoc.id=thanhtoan.monhocId 
 where thanhtoan.sinhvienId=".$_GET['sinhvienId']);
$sotien1tin;

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnThanhToan'])) {
    $conn->query("update thanhtoan set daThanhToan = 1 where sinhvienId=".$_GET['sinhvienId']);
    header("Refresh: 1");
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateSoTien1Tin'])) {
    $conn->query("update thanhtoan set sotien1tin=".$_POST['sotien1tin']);
    header("Refresh: 1");
}
?>

<div class='container mt-2'>
    <table class="table table-hover">
    <thead>
        <tr class='table-active'>
        <th scope="col">Tên sinh viên</th>
        <th scope="col">Lớp</th>
        <th scope="col">Môn</th>
        <th scope="col">Số tín</th>
        <th scope="col">Số tiền 1 tín</th>
        <th scope="col">Học kì</th>
        <th scope="col">Trạng thái</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if ($thongtinQuery->num_rows > 0) {
                $tongtien = 0;
                $tongno = 0;
                while ($thongtin = $thongtinQuery->fetch_assoc()) {                    
                    $sotien1tin = $thongtin['sotien1tin'];
                    $thongtinDaThanhToan;
                    if($thongtin['daThanhToan'] == 0) {
                        $thongtinDaThanhToan = 'Chưa thanh toán';
                    } else 
                    $thongtinDaThanhToan = 'Đã thanh toán';
                    $tongtien += $thongtin['sotien1tin'] * $thongtin['sotinchi'];
                    if($thongtin['daThanhToan'] == 0) {
                        $tongno += $thongtin['sotien1tin'] * $thongtin['sotinchi'];
                    }

                    $hocki = $conn->query("select * from dangkimonhoc 
                    inner join hocki on hocki.id=dangkimonhoc.hockiId
                    where dangkimonhoc.sinhvienId=".$thongtin['sinhvienId']." 
                    and dangkimonhoc.monhocId=".$thongtin['monhocId'])->fetch_assoc();
                    echo '<tr>
                            <td>'.$thongtin['ten'].'</td>
                            <td>'.$thongtin['lop'].'</td>
                            <td>'.$thongtin['tenmonhoc'].'</td>
                            <td>'.$thongtin['sotinchi'].'</td>
                            <td>'.$thongtin['sotien1tin'].'</td>
                            <td>'.$hocki['tenhocki'].'</td>
                            <td>'.$thongtinDaThanhToan.'</td>
                        </tr>';                    
                }
            }
        ?>
        <?php if(isset($tongtien)) {
            echo "<tr class='table-active'>
            <td colspan='6'>Tổng tiền</td>
            <td>".$tongtien."</td>
        </tr>";
        } ?>

        <?php if(isset($tongtien)) {
            echo "<tr class='table-active'>
            <td colspan='6'>Tổng nợ</td>
            <td>".$tongno."</td>
        </tr>";
        } ?>
        
    </tbody>
    </table>

    <?php 
        if($thongtinQuery->num_rows > 0) {
            echo "<div class='d-flex gap-4'>
        <form method='post'>
            <button name='btnThanhToan' class='btn btn-primary'>Thanh toán</button>
        </form>
        <button data-bs-toggle='modal' data-bs-target='#exampleModal' class='btn btn-light'>Cập nhật số tiền 1 tín</button>
    </div>";
        } else {
            echo '<p>Chưa có thông tin.</p>';
        }
    ?>
    
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method='post'>
                    <div>
                        <label>Số tiền 1 tín</label>
                        <input type='number' name='sotien1tin' class='form-control' value="<?php if(isset($sotien1tin)) echo $sotien1tin; ?>" />
                    </div>
                    <button type='submit' name='updateSoTien1Tin' class='btn btn-primary mt-2'>Lưu</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
</div>
</div>
