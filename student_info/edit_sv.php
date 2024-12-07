<?php require_once "pdo.php" ;
    $id = $_GET["id"];
    $sql = "select * from sinhvien where id = ?";
    $data= pdo_query_one($sql,$id);
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $ten = $_POST["ten"];
        $ma_sv = $_POST["ma_sv"];
        $ngay_sinh = $_POST["ngaysinh"];
        $sdt = $_POST["sdt"];
        $email = $_POST["email"];
        $diachi = $_POST["diachi"];
        $gioi_tinh = $_POST["gioi_tinh"];
    
        // Câu lệnh SQL cập nhật
        $sql_update = "UPDATE sinhvien SET ten = ?, ma_sv = ?, ngay_sinh = ?, sdt = ?, email = ?, diachi = ?, gioi_tinh = ? WHERE id = ?";
        pdo_execute($sql_update, $ten, $ma_sv, $ngay_sinh, $sdt, $email, $diachi, $gioi_tinh, $id);
    
        // Chuyển hướng sau khi cập nhật thành công
        header("Location: index.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Sửa thông tin sinh viên</h2>
    <form action="edit_sv.php?id=<?=$id?>" method="POST">
        <div class="form-group mb-3">
            <label for="name1">Tên sinh viên</label>
            <input type="text" id="name1" name="ten" value="<?=$data["ten"]?>" class="form-control" placeholder="Nhập tên sinh viên">
        </div>
        <div class="form-group mb-3">
            <label for="name2">Mã sinh viên</label>
            <input type="text" id="name2" name="ma_sv" value="<?=$data["ma_sv"]?>" class="form-control" placeholder="Nhập lớp">
        </div>
        <div class="form-group mb-3">
            <label for="name3">Ngày sinh</label>
            <input type="date" id="name3" name="ngaysinh" value="<?=$data["ngay_sinh"]?>" class="form-control" placeholder="Nhập ngày sinh">
        </div>
        <div class="form-group mb-3">
            <label for="name4">Số điện thoại</label>
            <input type="text" id="name4" name="sdt"  value="<?=$data["sdt"]?>"class="form-control" placeholder="Nhập số điện thoại">
        </div>
        <div class="form-group mb-3">
            <label for="name5">Email</label>
            <input type="email" id="name5" name="email" value="<?=$data["email"]?>" class="form-control" placeholder="Nhập email">
        </div>
        <div class="form-group mb-3">
            <label for="name6">Địa chỉ</label>
            <input type="text" id="name6" name="diachi" value="<?=$data["diachi"]?>" class="form-control" placeholder="Nhập địa chỉ">
        </div>
        <div class="form-group mb-3">
            <label for="name6">Giới tính</label>
             <select name="gioi_tinh" class="form-select" id="gioi_tinh">
                <option value="">Giới tính</option>
                <option value="1" <?=$data["gioi_tinh"]==1 ? "selected" :""?> value="1">Giới tính nam</option>
                <option value="2" <?=$data["gioi_tinh"]==2 ? "selected" :""?> value="2">Giới tính nữ</option>
             </select>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Lưu thông tin</button>
            <button type="reset" class="btn btn-secondary">Làm mới</button>
        </div>
    </form>
</div>

  
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>