<?php 
include('../includes/head.php');
include('../includes/header.php');

$diemSoHientai = $conn->query("select * from diemso where id=".$_GET['id'])->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $diemCC = $_POST['diemCC'];
  $diemGK = $_POST['diemGK'];
  $diemCK = $_POST['diemCK'];
  $tongdiem = $diemCC*0.1+$diemGK*0.3+$diemCK*0.6;
  if($tongdiem >= 4) {
      $trangthai = 1;
  } else $trangthai = 0;

  $conn->query("update diemso set diemCC=".$diemCC.",diemGK=".$diemGK.",diemCK=".$diemCK.",trangthai=".$trangthai." where id=".$_GET['id']);
  header('location: ./detail.php?sinhvienId='.$_GET['sinhvienId']);
}

?>

<div class='container'>
    <form method='post'>
      <div>
          <label>Điểm CC</label>
          <input required name='diemCC' value='<?php echo $diemSoHientai['diemCC']; ?>' class='form-control' placeholder='Điểm CC' />
      </div>
      <div>
          <label>Điểm GK</label>
          <input required name='diemGK' value='<?php echo $diemSoHientai['diemGK']; ?>' class='form-control' placeholder='Điểm GK' />
      </div>
      <div>
          <label>Điểm CK</label>
          <input required name='diemCK' value='<?php echo $diemSoHientai['diemCK']; ?>' class='form-control' placeholder='Điểm CK' />
      </div>            
      <button class="btn btn-primary" data-bs-dismiss="modal">Sửa</button>
    </form>
</div>