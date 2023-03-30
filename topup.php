<?php
// ดึง navbar จากหน้าอื่นเข้ามา
$variable =array(
  'navbar',

);
// ตรงนี้ ถ้ามีหน้าที่อยู่ในโฟลเดอร์ เดียวกัน จะดึงเข้ามา โดยใช้ foreach ในการสร้าง variable
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
// เริ่ม session
session_start();

// เด้งออกไปหน้า login เมื่อยังไม่ login
if(!isset($_SESSION['email'])) {
  header('location: login.php');
}
// แจ้งเตือนว่าเข้าสู่หน้าเติมเงิน
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

<!-- ปุ้มต่างๆ ที่จะเข้าหน้าเติมเงินต่างๆ -->
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
  //  เมือคลิกที่ปุ่ม promtpay จะแสดง sweetalert2 ที่มีข้อความ
  // ว่า ใส่จำนวนเงินที่ต้องการจะเติม
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
// ถ้าไม่ใส่จำนวนเงิน
      if (!number) {
        Swal.fire({
          icon: 'error',
          title: 'แจ้งเตือน',
          text: 'โปรดใส่จำนวนเงิน',
        })
      }
      else 
      // ถ้าจำนวนเงินน้อยกว่า 10
      if (number < 10) {
        Swal.fire({
          icon: 'error',
          title: 'แจ้งเตือน',
          text: 'ขั้นต่ำ 10 บาท น้ะจ๊ะ',
        })
      }
      else
      {
        // ถ้าถูกตามเงื่อนไขจะไปหน้าเติมเงิน
        window.location.href = 'topup/promptpay.php?price_value=' + number;
      }
    }
  });
});
</script>



</body>
</html>