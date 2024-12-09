<?php
require_once 'pdo.php';

$error = "";
$success = "";

// Xử lý khi form được submit
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $ten = $_POST['ten'] ?? '';
    $ma_sv = $_POST['ma_sv'] ?? '';
    $ngay_sinh = $_POST['ngay_sinh'] ?? '';
    $gioi_tinh = $_POST['gioi_tinh'] ?? '';
    $diachi = $_POST['diachi'] ?? '';
    $email = $_POST['email'] ?? '';
    $sdt = $_POST['sdt'] ?? '';

    // Kiểm tra các trường bắt buộc
    if (empty($ten) || empty($ma_sv) || empty($ngay_sinh)) {
        $error = "Tên, mã sinh viên và ngày sinh là bắt buộc.";
    } else {
        try {
            // Thêm dữ liệu vào cơ sở dữ liệu
            $sql = "INSERT INTO sinhvien (ten, ma_sv, ngay_sinh, gioi_tinh, diachi, email, sdt) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            pdo_execute($sql, $ten, $ma_sv, $ngay_sinh, $gioi_tinh, $diachi, $email, $sdt);
            $success = "Thêm sinh viên thành công!";
        } catch (PDOException $e) {
            $error = "Lỗi thêm dữ liệu: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sinh viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="text-center">
            <h2>Thêm sinh viên mới</h2>
        </div>

        <!-- Thông báo lỗi hoặc thành công -->
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <!-- Form thêm sinh viên -->
        <form method="POST" action="add_sv.php">
            <div class="mb-3">
                <label for="ten" class="form-label">Tên sinh viên</label>
                <input type="text" class="form-control" id="ten" name="ten" required>
            </div>
            <div class="mb-3">
                <label for="ma_sv" class="form-label">Mã sinh viên</label>
                <input type="text" class="form-control" id="ma_sv" name="ma_sv" required>
            </div>
            <div class="mb-3">
                <label for="ngay_sinh" class="form-label">Ngày sinh</label>
                <input type="date" class="form-control" id="ngay_sinh" name="ngay_sinh" required>
            </div>
            <div class="mb-3">
                <label for="gioi_tinh" class="form-label">Giới tính</label>
                <select class="form-select" id="gioi_tinh" name="gioi_tinh">
                    <option value="1">Nam</option>
                    <option value="0">Nữ</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="diachi" class="form-label">Quê quán</label>
                <input type="text" class="form-control" id="diachi" name="diachi">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="mb-3">
                <label for="sdt" class="form-label">Số điện thoại</label>
                <input type="text" class="form-control" id="sdt" name="sdt">
            </div>
            <button type="submit" class="btn btn-primary">Thêm sinh viên</button>
            <a href="index.php" class="btn btn-secondary">Quay lại danh sách</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>
