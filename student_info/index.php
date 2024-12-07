<?php require_once 'pdo.php';
    $sql = "Select * from sinhvien where 1 ";
    $data = pdo_query($sql);
  
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
    <?php foreach($data as $index => $item) :?>
    <tr>
      <th scope="row"><?=$index + 1?></th>
      <td><?=$item['ten']?></td>
      <td><?=$item['ma_sv']?></td>
      <td><?=$item['ngay_sinh']?></td>
      <td><?=$item['gioi_tinh'] == 1 ? "Nam" : "Nữ"?></td>
      <td><?=$item['diachi']?></td>
      <td><?=$item['email']?></td>
      <td><?=$item['sdt']?></td>
      <td><a href="edit_sv.php?id=<?php echo $item["id"] ?>" class="btn btn-primary">Sửa</a></td>
      
    </tr>
    <?php endforeach ?>
  </tbody>
</table>
 <a href=" http://localhost:3000/index.php " class="btn btn-secondary">Quay về trang chủ</a>

    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>