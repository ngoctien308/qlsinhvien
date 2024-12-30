<?php
// Connect db
$host = 'localhost:3307'; // Địa chỉ MySQL server (thường là localhost)
$username = 'root';  // Tên đăng nhập MySQL
$password = '';      // Mật khẩu MySQL (để trống nếu mặc định)
$dbname = 'qlsv'; // Tên cơ sở dữ liệu

// Tạo kết nối
$conn = new mysqli($host, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
//  else {
//     echo "Kết nối thành công!";
// }
?>

<nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Quản lí sinh viên</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarColor01">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="http://localhost/qlsinhvien/index.php">Trang chủ
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="http://localhost/qlsinhvien/student_info/index.php">Sinh viên</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="http://localhost/qlsinhvien/learning_result/index.php">Kết quả học tập</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="http://localhost/qlsinhvien/subject_registration/index.php">Đăng kí môn học</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="http://localhost/qlsinhvien/tuition/index.php">Học phí</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="http://localhost/qlsinhvien/timetable/index.php">Thời khóa biểu</a>
        </li>
      </ul>
    </div>
  </div>
</nav>