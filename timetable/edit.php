<?php
include('../includes/head.php');
include('../includes/header.php');

$monhocQuery = $conn->query("select * from monhoc");

$tkbQuery = $conn->query("select thoikhoabieu.*, monhoc.ten as 'tenmonhoc' from thoikhoabieu inner join monhoc on monhoc.id = monhocId where thoikhoabieu.id = ".$_GET['id']);
$tkb = $tkbQuery->fetch_assoc();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $monhocId = $_POST['monhocId'];
    $ngay = $_POST['ngay'];
    $tietbd = $_POST['tietbd'];
    $tietkt = $_POST['tietkt'];
    $conn->query("update thoikhoabieu set ngay='".$ngay."',monhocId=".$monhocId.",tietbd=".$tietbd.",tietkt=".$tietkt." where id=".$_GET['id']);
    header('location: ./detail.php?sinhvienId='.$tkb['sinhvienId']);
}
?>

<div class='container'>
    <form method='post'>
        <div>
            <label  class='form-label'>Ngày học</label>
            <input type="date" class='form-control' name='ngay' value='<?php echo $tkb['ngay'] ?>'>
        </div>
        <div>
            <label class='form-label'>Môn học</label>
            <select class='form-control' name='monhocId'>
                <?php
                    if($monhocQuery->num_rows > 0) {
                        while ($monhoc = $monhocQuery->fetch_assoc()) {                   
                            $selectedString = "";
                            if($tkb['monhocId'] == $monhoc['id']) {
                                $selectedString = "selected";
                            }
                            echo '<option '. $selectedString .' value="'.$monhoc['id'].'">'.$monhoc['ten'].'</option>';
                        }
                    }
                ?>
            </select>
        </div>
        <div>
            <label  class='form-label'>Tiết bắt đầu</label>
            <input type="number" class='form-control' name='tietbd' value='<?php echo $tkb['tietbd'] ?>'>
        </div>
        <div>
            <label  class='form-label'>Tiết kết thúc</label>
            <input type="number" class='form-control' name='tietkt' value='<?php echo $tkb['tietkt'] ?>'>
        </div>
        <button class='mt-2 btn btn-primary'>Cập nhật</button>
    </form>
</div>

           