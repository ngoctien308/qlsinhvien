<?php
include('../includes/head.php');
include('../includes/header.php');

$svQuery = $conn->query("select * from sinhvien where id = ".$_GET['sinhvienId']);
$sv = $svQuery->fetch_assoc();

$tkbQuery=$conn->query('select thoikhoabieu.*, monhoc.ten as "tenmonhoc" from thoikhoabieu inner join monhoc on monhoc.id=monhocId where sinhvienId='.$_GET['sinhvienId']);

$monhocQuery = $conn->query("select * from monhoc");

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $monhocId = $_POST['monhocId'];
    $sinhvienId = $_GET['sinhvienId'];
    $ngay = $_POST['ngay'];
    $tietbd = $_POST['tietbd'];
    $tietkt = $_POST['tietkt'];
    $conn->query("insert into thoikhoabieu (monhocId, sinhvienId, tietbd, tietkt, ngay) values(".$monhocId.",".$sinhvienId.",".$tietbd.",".$tietkt.",'".$ngay."')");
    header("Refresh: 1");
}
?>


<div class='container'>
    <h1 class='mt-2'>Thời khóa biểu của sinh viên <?php echo $sv['ten']; ?></h1>
    <button class="btn btn-info mb-2"  data-bs-toggle="modal" data-bs-target="#addmodal">Thêm lịch học</button>
    <table class="table table-hover">
    <thead>
        <tr class='table-active'>
            <th>Ngày</th>
            <th>Môn Học</th>
            <th>Tiết Bắt Đầu</th>
            <th>Tiết Kết Thúc</th>
            <th colspan="2">Tùy chọn</th>
        </tr>
    </thead>
    <tbody>
        <?php
             if ($tkbQuery->num_rows > 0) {
                while ($tkb = $tkbQuery->fetch_assoc()) {                   
                    echo '<tr>
                        <td>'. $tkb['ngay'] .'</td>
                        <td>'. $tkb['tenmonhoc'] .'</td>
                        <td>'. $tkb['tietbd'] .'</td>
                        <td>'. $tkb['tietkt'] .'</td>                       
                        <td><a href="./edit.php?id='.$tkb['id'].'" class="btn btn-warning" >Sửa</a></td>                      
                        <td><a href="./delete.php?id='.$tkb['id'].'&sinhvienId='.$tkb['sinhvienId'].'" class="btn btn-danger">Xóa</a></td>                      
                        </tr>';
                }
            }
        ?>
    </tbody>
    </table>

    <!-- Add Modal -->
<div class="modal fade" id="addmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Thêm lịch học</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method='post'>
            <div>
                <label  class='form-label'>Ngày học</label>
                <input type="date" class='form-control' name='ngay'>
            </div>
            <div>
                <label class='form-label'>Môn học</label>
                <select class='form-control' name='monhocId'>
                    <?php
                        if($monhocQuery->num_rows > 0) {
                            while ($monhoc = $monhocQuery->fetch_assoc()) {                   
                                echo '<option value="'.$monhoc['id'].'">'.$monhoc['ten'].'</option>';
                            }
                        }
                    ?>
                </select>
            </div>
            <div>
                <label  class='form-label'>Tiết bắt đầu</label>
                <input type="number" class='form-control' name='tietbd'>
            </div>
            <div>
                <label  class='form-label'>Tiết kết thúc</label>
                <input type="number" class='form-control' name='tietkt'>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" name='btnthem' class="btn btn-primary">Thêm</button>
        </div>
    </form>
    </div>
  </div>
</div>
    
</div>