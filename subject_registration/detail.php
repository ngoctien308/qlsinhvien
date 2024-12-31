<?php
include('../includes/head.php');
include('../includes/header.php');

// Kiểm tra và lấy sinhvienId từ URL
if (!isset($_GET['sinhvienId']) || !is_numeric($_GET['sinhvienId'])) {
    die("ID sinh viên không hợp lệ hoặc không được cung cấp!");
}

$sinhvienId = (int)$_GET['sinhvienId'];

// Kiểm tra sự tồn tại của hockiId trong URL
$hockiId = isset($_GET['hockiId']) && is_numeric($_GET['hockiId']) ? (int)$_GET['hockiId'] : null;

// Lấy thông tin sinh viên
$svQuery = $conn->query("SELECT * FROM sinhvien WHERE id = $sinhvienId");
if ($svQuery->num_rows == 0) {
    die("Không tìm thấy sinh viên với ID: $sinhvienId");
}
$sv = $svQuery->fetch_assoc();

// Xử lý form thêm môn học
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_course'])) {
    if (!$hockiId) {
        $error_message = 'Vui lòng chọn đúng học kỳ hiện tại để đăng ký!';
    } else {
        $monhocId = $_POST['monhocId'];
        $giangvienId = $_POST['giangvienId'];

        // Lấy thông tin môn học
        $monQuery = $conn->query("SELECT monhoc.sotinchi, monhoc.tenmonhoc FROM monhoc
            WHERE monhoc.id = $monhocId");

        if ($monQuery->num_rows > 0) {
            $mon = $monQuery->fetch_assoc();
            $sotinchi = $mon['sotinchi'];

            // Thêm môn học mới vào bảng dangkimonhoc
            if (empty($monhocId) || empty($giangvienId)) {
                $error_message = 'Vui lòng chọn giảng viên dạy học!';
            } else{
            try {
                $insertQuery = "INSERT INTO dangkimonhoc (sinhvienId, monhocId, hockiId, giangvienId) 
                            VALUES ($sinhvienId, $monhocId, $hockiId, $giangvienId)";
                if ($conn->query($insertQuery)) {
                    $success_message = 'Thêm môn học thành công!';
                } else {
                    $error_message = 'Lỗi khi thêm môn học: ' . $conn->error;
                }
            } catch (Exception $e) {
                echo '<script>alert("Có lỗi xảy ra: '.$e->getMessage().'")</script>';
            }           
            

            if($conn->query("select * from thanhtoan where sinhvienId=".$_GET['sinhvienId'])->num_rows == 0) {
                $conn->query("insert into thanhtoan (sinhvienId) values(".$_GET['sinhvienId'].")");
            } else {
                $conn->query("update thanhtoan set daThanhToan=0 where sinhvienId=".$_GET['sinhvienId']);
            }
        }
    } else {
        $error_message = 'Vui lòng chọn môn học!';
    }
}
}

// Xử lý xóa môn học
if (isset($_POST['delete_course']) && isset($_POST['dangkiId'])) {
    $dangkiId = (int)$_POST['dangkiId'];

    // Xóa môn học khỏi bảng qldangkmonhoc
    $deleteQuery = "DELETE FROM dangkimonhoc WHERE id = $dangkiId";
    if ($conn->query($deleteQuery)) {
        $success_message = 'Xóa môn học thành công!';
    } else {
        $error_message = 'Lỗi khi xóa môn học: ' . $conn->error;
    }
}

// Truy vấn lấy dữ liệu môn học của sinh viên theo học kỳ (nếu có chọn học kỳ)
if (isset($_GET['hockiId']) && is_numeric($_GET['hockiId'])) {
    $hockiId = (int)$_GET['hockiId'];

    // Truy vấn lấy dữ liệu các môn học đã đăng ký
    $monQuery = $conn->query(
        "SELECT dangkimonhoc.id, monhoc.tenmonhoc AS tenmon, monhoc.sotinchi, giangvien.tengiangvien, dangkimonhoc.thoigian
         FROM monhoc
         JOIN dangkimonhoc ON dangkimonhoc.monhocId = monhoc.id
         LEFT JOIN giangvien ON giangvien.id = dangkimonhoc.giangvienId
         WHERE dangkimonhoc.sinhvienId = $sinhvienId AND dangkimonhoc.hockiId = $hockiId"
    );
    
} else {
    $hockiId = null;
    $monQuery = null;
}


// Truy vấn danh sách môn học có thể đăng ký (không cần thông tin về giảng viên, tín chỉ... vì chúng đã được lưu trong bảng `monhoc`)
$monhocQuery = $conn->query("
   SELECT id, sotinchi, tenmonhoc FROM monhoc;

");
?>


<div class='container'>
    <h1 class='mt-2 text-center'>Chi tiết đăng ký môn học của sinh viên: <?php echo htmlspecialchars($sv['ten']); ?></h1>
    <?php
    $hockiQuery = $conn->query("SELECT * FROM `hocki` ORDER BY `id` ASC");
    ?>
    <!-- Dropdown chọn học kỳ -->
<form method="GET" action="detail.php">
    <input type="hidden" name="sinhvienId" value="<?php echo $sinhvienId; ?>">
    <div class="form-group">
        <label for="hocki">Chọn học kỳ</label>
        <select name="hockiId" id="hocki" class="form-control" onchange="this.form.submit()">
            <option value="">Chọn học kỳ</option>
            <?php while ($hocki = $hockiQuery->fetch_assoc()): ?>
                <option value="<?php echo $hocki['id']; ?>" <?php echo (isset($_GET['hockiId']) && $_GET['hockiId'] == $hocki['id']) ? 'selected' : ''; ?>>
                    <?php echo $hocki['tenhocki']; ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>
</form>

<!-- Hiển thị thông báo nếu không có hockiId -->
<?php if (isset($error_message)): ?>
    <div class="alert alert-warning">
        <?php echo $error_message; ?>
    </div>
<?php endif; ?>


    <!-- Nút thêm môn học -->
    <button type="button" class="btn" style="background-color: #28a745; color: white;" onclick="checkHockiId(<?php echo isset($hockiId) ? $hockiId : 'null'; ?>)">
        Thêm
    </button>

    <script>
        // hàm kiểm tra dữ liệu đầu vào trước khi gửi form
function validateForm() {
    const tenmonhoc = document.getElementById('tenmonhoc').value;
    const giangvien = document.getElementById('giangvien').value;
    const errorMessage = document.getElementById('error-message');

    // Kiểm tra nếu chưa chọn môn học hoặc giảng viên
    if (!tenmonhoc) {
        errorMessage.textContent = 'Vui lòng chọn môn học!';
        errorMessage.classList.remove('d-none');
        return;
    }

    if (!giangvien) {
        errorMessage.textContent = 'Vui lòng chọn giảng viên!';
        errorMessage.classList.remove('d-none');
        return;
    }

    // Xóa thông báo lỗi và submit form nếu hợp lệ
    errorMessage.classList.add('d-none');
    document.getElementById('add-course-form').submit();
}
</script>

<!-- Modal thêm môn học -->
<div class="modal fade" id="addCourseModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm môn học</h5>
            </div>
            <div class="modal-body">
            <div id="error-message" class="alert alert-danger d-none"></div>
            <form id="add-course-form" method="POST">
                    <div class="form-group">
                        <label for="tenmon">Tên môn</label>
                        <select class="form-control" id="tenmonhoc" name="monhocId" onchange="updateCourseDetails()">
                            <option value="">Chọn môn học</option>
                            <?php while ($mon = $monhocQuery->fetch_assoc()): ?>
                                <option value="<?php echo $mon['id']; ?>" 
                                    data-sotinchi="<?php echo $mon['sotinchi']; ?>">
                                    <?php echo $mon['tenmonhoc']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="sotinchi">Số tín chỉ</label>
                        <input type="number" class="form-control" id="sotinchi" name="sotinchi" readonly>
                    </div>

                    <!-- Dropdown Giảng viên -->
                    <div class="form-group">
                        <label for="giangvien">Giảng viên</label>
                        <select class="form-control" id="giangvien" name="giangvienId">
                            <option value="">Chọn giảng viên</option>
                            <?php
                            // Truy vấn lấy danh sách giảng viên
                            $giangvienQuery = $conn->query("SELECT * FROM giangvien");
                            while ($giangvien = $giangvienQuery->fetch_assoc()) {
                                echo "<option value='" . $giangvien['id'] . "'>" . $giangvien['tengiangvien'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <button type="submit" name="add_course" class="btn btn-success">Thêm</button>
                    <button type="button" class="btn btn-primary ml-2" data-dismiss="modal" onclick="$('#addCourseModal').modal('hide');">Đóng</button>
                    </form>
            </div>
        </div>
    </div>
</div>

<script>
    function checkHockiId(hockiId) {
        if (hockiId) {
            $('#addCourseModal').modal('show');
        } else {
            alert('Vui lòng chọn đúng học kỳ hiện tại');
        }
    }
    function updateCourseDetails() {
        var selectedOption = document.getElementById('tenmonhoc').selectedOptions[0];
        document.getElementById('sotinchi').value = selectedOption.getAttribute('data-sotinchi');
    }
</script>

    <!-- Bảng danh sách môn học -->
    <table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Tên môn</th>
            <th>Số tín chỉ</th>
            <th>Giảng viên</th>
            <th>Thời gian đăng ký</th> <!-- Cột Thời gian đăng ký -->
            <th>Chức năng</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($monQuery && $monQuery->num_rows > 0) {
            while ($mon = $monQuery->fetch_assoc()) {
                echo '<form method="POST">';
                echo '<tr>
                    <td>' . htmlspecialchars($mon['tenmon']) . '</td>
                    <td>' . htmlspecialchars($mon['sotinchi']) . '</td>
                    <td>' . htmlspecialchars($mon['tengiangvien']) . '</td>
                    <td>';
                        if (isset($mon['thoigian'])) {
                            echo date("d/m/Y H:i:s", strtotime($mon['thoigian']));
                        } else {
                            echo 'Chưa có thời gian';
                        }
                echo '</td>
                    <td>
                        <input type="hidden" name="dangkiId" value="' . (int)$mon['id'] . '">
                        <button type="submit" name="delete_course" class="btn btn-danger">Xóa</button>
                    </td>
                </tr>';
                echo '</form>';
            }
        } elseif ($monQuery) {
            echo '<tr><td colspan="7" class="text-center">Không có môn học nào</td></tr>';
        } else {
            echo '<tr><td colspan="7" class="text-center">Không có môn học nào</td></tr>';
        }
        ?>
    </tbody>
</table>

</div>

<!-- Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
