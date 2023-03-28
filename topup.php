<?php
$variable =array(
  'navbar',
);
foreach ($variable as $include_function) {
  include 'bar/'.$include_function.'.php';
};


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เติมเงิน</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="style/topup.css">

</head>
<body>



<?php
session_start();


if(!isset($_SESSION['email'])) {
  header('location: login.php');
}

echo "<script>
const Toast = Swal.mixin({
    toast: true,
    position: 'center',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,

  })
  
  Toast.fire({
    icon: 'success',
    title: 'ยินดีต้อนรับ ".$_SESSION['name']." เข้าสู่หน้าเติมเงิน'
  })
  </script>


  ";
  

?>

<script>


</script>


<div class="form-wrapper">
    <form class="topup_form">
    <ul class='topup_ul'>
        <a id='promptpay'><li class="list-item">Promptpay พร้อมเพย์</li></a>
        <li class="list-item">TrueMoney Wallet (Coming Soon)</li>
        <li class="list-item">ช่วยเหลือ</li>
    </ul>
    </form>
</div>

<script>
  document.getElementById('promptpay').addEventListener('click', function() {

  Swal.fire({
    title: 'ใส่จำนวนเงินที่ต้องการจะเติม',
    input: 'number',
    inputAttributes: {
      min: 0,
      step: 1
    },
    showCancelButton: true,
    confirmButtonText: 'ยืนยัน',
    cancelButtonText: 'ยกเลิก',
    showLoaderOnConfirm: true,
    allowOutsideClick: () => !Swal.isLoading(),
    preConfirm: (number) => {

      if (!number) {
        Swal.fire({
          icon: 'error',
          title: 'แจ้งเตือน',
          text: 'โปรดใส่จำนวนเงิน',
        })
      }
      else
      {
        window.location.href = 'topup/promptpay.php?price_value=' + number;
      }
    }
  });
});
</script>



</body>
</html>