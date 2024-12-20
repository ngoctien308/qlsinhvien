<?php
include('../includes/head.php');
include('../includes/header.php');

// Lấy thông tin sinh viên
$sinhvienId = $_GET['sinhvienId'];
$svQuery = $conn->query("SELECT * FROM sinhvien WHERE id = " . $sinhvienId);
$sv = $svQuery->fetch_assoc();

// Lấy danh sách các môn học và thông tin số tiền một tín
$monhocQuery = $conn->query(
    "SELECT dangkimonhoc.monhocId as dangkimonhocId, sinhvien.ten as tensv, sinhvien.lop, monhoc.ten as tenmonhoc, dangkimonhoc.sotien1tin 
    FROM dangkimonhoc
    INNER JOIN sinhvien ON sinhvien.id = dangkimonhoc.sinhvienId
    INNER JOIN monhoc ON monhoc.id = dangkimonhoc.monhocId
    WHERE sinhvienId = " . $sinhvienId
);

// Cập nhật số tiền 1 tín nếu có yêu cầu POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dangkimonhocId = $_POST['dangkimonhocId'];
    $sotien1tin = $_POST['sotien1tin'];

    $conn->query("UPDATE dangkimonhoc SET sotien1tin = $sotien1tin WHERE monhocId = $dangkimonhocId");
    header("Location: update.php?sinhvienId=" . $sinhvienId); // Refresh trang sau khi cập nhật
}
?>

<div class="container">
    <h1 class="mt-2">Cập nhật số tiền 1 tín cho sinh viên: <?php echo htmlspecialchars($sv['ten']); ?></h1>
    <h3>Lớp: <?php echo htmlspecialchars($sv['lop']); ?></h3>

    <table class="table table-hover">
        <thead>
            <tr class="table-active">
                <th scope="col">Tên môn học</th>
                <th scope="col">Số tiền 1 tín</th>
                <th scope="col">Tùy chọn</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($monhocQuery->num_rows > 0) {
                while ($monhoc = $monhocQuery->fetch_assoc()) {
                    echo '<tr>
                        <td>' . htmlspecialchars($monhoc['tenmonhoc']) . '</td>
                        <td>
                            <form method="post" class="d-flex align-items-center gap-2">
                                <input type="hidden" name="dangkimonhocId" value="' . $monhoc['dangkimonhocId'] . '">
                                <input type="number" name="sotien1tin" value="' . htmlspecialchars($monhoc['sotien1tin']) . '" class="form-control" style="width: 120px;">
                                <button class="btn btn-success btn-sm">Cập nhật</button>
                            </form>
                        </td>
                    </tr>';
                }
            } else {
                echo '<tr><td colspan="3" class="text-center">Không có môn học nào được đăng ký</td></tr>';
            }
            ?>
        </tbody>
    </table>
    <a href="index.php" class="btn btn-primary">Quay về</a>
</div>