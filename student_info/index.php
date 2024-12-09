<?php 
require_once 'pdo.php';

// Lấy dữ liệu danh sách sinh viên
$sql = "SELECT * FROM sinhvien";
$data = pdo_query($sql);

// Xử lý xóa sinh viên
if (isset($_GET["delete_id"])) {
    $delete_id = $_GET["delete_id"];

    // Xóa các bản ghi liên quan trong bảng dangkimonhoc trước
    $sql_delete_child = "DELETE FROM dangkimonhoc WHERE sinhvienId = ?";
    pdo_execute($sql_delete_child, $delete_id);

    // Sau đó, xóa sinh viên trong bảng sinhvien
    $sql_delete = "DELETE FROM sinhvien WHERE id = ?";
    pdo_execute($sql_delete, $delete_id);

    // Chuyển hướng về lại trang danh sách sau khi xóa
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sinh viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="text-center">
            <h2>Quản lý thông tin sinh viên</h2>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tên</th>
                    <th scope="col">Mã sinh viên</th>
                    <th scope="col">Ngày sinh</th>
                    <th scope="col">Giới tính</th>
                    <th scope="col">Quê quán</th>
                    <th scope="col">Email</th>
                    <th scope="col">SDT</th>
                    <th scope="col">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data as $index => $item): ?>
                <tr>
                    <th scope="row"><?= $index + 1 ?></th>
                    <td><?= htmlspecialchars($item['ten']) ?></td>
                    <td><?= htmlspecialchars($item['ma_sv']) ?></td>
                    <td><?= htmlspecialchars($item['ngay_sinh']) ?></td>
                    <td><?= $item['gioi_tinh'] == 1 ? "Nam" : "Nữ" ?></td>
                    <td><?= htmlspecialchars($item['diachi']) ?></td>
                    <td><?= htmlspecialchars($item['email']) ?></td>
                    <td><?= htmlspecialchars($item['sdt']) ?></td>
                    <td>
                        <a href="edit_sv.php?id=<?= $item['id'] ?>" class="btn btn-primary btn-sm">Sửa</a>
                        <a href="?delete_id=<?= $item['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa sinh viên này?')">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="d-flex justify-content-between mt-4">
            <a href="add_sv.php" class="btn btn-success">Thêm sinh viên</a>
            <a href="http://localhost:3000/index.php" class="btn btn-secondary">Quay về trang chủ</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
