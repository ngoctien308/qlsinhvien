<?php
include('../includes/head.php');
include('../includes/header.php');

$sv = $conn->query("select * from sinhvien where id=".$_GET['sinhvienId'])->fetch_assoc();

$monhocQuery = $conn->query("select distinct monhoc.id, monhoc.tenmonhoc from dangkimonhoc inner join monhoc on monhoc.id=dangkimonhoc.monhocId where sinhvienId=".$_GET['sinhvienId']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $diemCC = $_POST['diemCC'];
    $diemGK = $_POST['diemGK'];
    $diemCK = $_POST['diemCK'];
    try {
        if($diemCC < 0 || $diemCC > 10 || $diemGK < 0 || $diemGK > 10 || $diemCK < 0 || $diemCK > 10) {
            throw new Exception("Điểm phải nằm trong khoảng từ 1 đến 10.");
        }

        $tongdiem = $diemCC*0.1+$diemGK*0.3+$diemCK*0.6;
        if($tongdiem >= 4) {
            $trangthai = 1;
        } else $trangthai = 0;

        $conn->query("insert into diemso (diemCC,diemGK,diemCK,trangthai,sinhvienId,monhocId)
        values(".$diemCC.",".$diemGK.",".$diemCK.",".$trangthai.",".$_GET['sinhvienId'].",".$_POST['monhocId'].")
        ");
        header("Refresh: 1");
    } catch (Exception $e) {
        echo '<script>alert("Có lỗi xảy ra: '.$e->getMessage().'")</script>';
    } 
}

$diemsoQuery = $conn->query("select diemso.*,monhoc.tenmonhoc from diemso
inner join monhoc on monhoc.id=diemso.monhocId
where sinhvienId=".$_GET['sinhvienId']);

?>

<div class='container mt-2'>
    <h1>Thông tin kết quả học tập của sinh viên <?php echo $sv['ten']; ?></h1>
    <h1>Lớp: <?php echo $sv['lop']; ?></h1>

    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Thêm điểm
    </button>

    <table class="table table-hover mt-2">
        <thead>
            <tr class='table-active'>
                <th scope="col">Tên môn</th>
                <th scope="col">Học kì</th>
                <th scope="col">Điểm CC</th>
                <th scope="col">Điểm GK</th>
                <th scope="col">Điểm CK</th>
                <th scope="col">Tổng điểm</th>
                <th scope="col">Trạng thái</th>
                <th scope="col" colspan="2">Tùy chọn</th>
            </tr>
        </thead>
        <tbody>
            <?php
                if ($diemsoQuery->num_rows > 0) {
                    while ($diemso = $diemsoQuery->fetch_assoc()) {
                        $tongdiem = $diemso['diemCC'] * 0.1 + $diemso['diemGK']*0.3 + $diemso['diemCK'] * 0.6;
                        $trangthai;
                        if($tongdiem >= 4) {
                            $trangthai = 'Đã hoàn thành';
                        } else {
                            $trangthai = 'Chưa hoàn thành';
                        }
                        $hocki = $conn->query("select * from dangkimonhoc inner join hocki on hocki.id=dangkimonhoc.hockiId where sinhvienId=".$_GET['sinhvienId']." and monhocId=".$diemso['monhocId'])->fetch_assoc();

                        echo '<tr><td scope="col">'.$diemso['tenmonhoc'].'</td>
                                <td scope="col">'.$hocki['tenhocki'].'</td>
                                <td scope="col">'.$diemso['diemCC'].'</td>
                                <td scope="col">'.$diemso['diemGK'].'</td>
                                <td scope="col">'.$diemso['diemCK'].'</td>
                                <td scope="col">'.$tongdiem.'</td>
                                <td scope="col">'.$trangthai.'</td>
                                <td><a href="./edit.php?id='.$diemso['id'].'&sinhvienId='.$diemso['sinhvienId'].'" type="button" class="btn btn-warning">Sửa</a></td>
                                <td><a href="./delete.php?id='.$diemso['id'].'" type="button" class="btn btn-danger">Xóa</a></td></tr>
                        ';
                    }
                }
            ?>
        </tbody>
    </table>

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
                        <label>Điểm CC</label>
                        <input required name='diemCC' class='form-control' placeholder='Điểm CC' />
                    </div>
                    <div>
                        <label>Điểm GK</label>
                        <input required name='diemGK' class='form-control' placeholder='Điểm GK' />
                    </div>
                    <div>
                        <label>Điểm CK</label>
                        <input required name='diemCK' class='form-control' placeholder='Điểm CK' />
                    </div>                    
                    <div>
                        <label>Môn học</label>
                        <select class='form-control' name='monhocId'>
                            <?php
                                if($monhocQuery->num_rows > 0) {
                                    while ($monhoc = $monhocQuery->fetch_assoc()) {  
                                        echo '<option value="'.$monhoc['id'].'">'.$monhoc['tenmonhoc'].'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <button class="btn btn-primary" data-bs-dismiss="modal">Thêm</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>
</div>