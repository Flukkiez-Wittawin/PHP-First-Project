<!-- หน้านี้จะเป็นหน้าเติมเงิน -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>พร้อมเพย์</title>
    <link rel="stylesheet" href="promptpay.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-material-ui/material-ui.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    
</head>
<body>

<?php
// ดึง function line_notify
include '../notify/line_notify.php';
// เรื่ม session เมื่อ login
session_start();

// เด้งออกไปหน้า login เมื่อยังไม่ login
if(!isset($_SESSION['email'])) {
  echo '<script> window.location.href = "../index.php" </script>';
}

?>


<div class="container">
  <div class='form'>
  <form method="post" id="myForm" enctype="multipart/form-data">
    <h2>หน้าเติมเงิน</h2>
    <div class="form-group">
      <label for="username">Username :</label>
      <!-- ดึงข้อมูลจาก session ของ name -->
      <input type="text" name="username" class='swal2-input' value="<?php echo $_SESSION['name'];?>" readonly disabled>
      <label for="username">ราคา :</label>
      <!-- ดึงข้อมูลจาก get ของ ราคา หรือ price_value -->
      <input type="number" name='pricemoney' class='swal2-input' value="<?php echo $_GET['price_value'];?>" readonly disabled>
      <p>QR CODE Payment <br> สแกนจ่ายได้เลย : </p>
      <center>
        <!-- ดึงข้อมูลจาก get ของ ราคา หรือ price_value เพื่อมาทำเป็น qrcode จ่ายเงิน และใช้ url qrcode ของพร้อมเพย์ -->
        <img draggable="false" width="200" src="https://promptpay.io/0952875776/<?php echo $_GET['price_value'];?>.png">
      </center>
    </div>
    <div class="form-group">
      <label for="username">ชื่อ - นามสกุล :</label>
      <input type="text" name='firstname_lastname' class='swal2-input'>
    </div>
    <div class="form-group">
      <label for="password">สลิป :</label>
      <input type="file" name="fileToUpload" id="file-input" class='swal2-file'>
      <br>
      <img draggable="false" width="400" id="preview-image" src="#" alt="สลิป">
    </div>
    <div class="form-group">
      <label for="username">วัน - เวลา :</label>
      <input type="date"  name='date' id="file-input" class='swal2-input'>
      <input type="time"  name='time' id="file-input" class='swal2-input'>
    </div>
  </form>
  <div class="form-group" >
    <!-- confirmSubmit คือ การส่งค่า -->
      <button type="submit" name='submit' onclick="confirmSubmit()">ยืนยัน</button><br>
      <button onclick="window.location.href = '../index.php';">ยกเลิก</button>
  </div>
  </div>
  
</div>

<?php
// ในส่วนนี้คือการ อัพโหลดไฟล์ รูปภาพไปใน โฟลเดอ slip
function Upload_File () {

  $firstname_lastname = $_POST['firstname_lastname']; // ดึงข้อมูลจาก form
  // $fileToUpload= $_POST['fileToUpload'];
  $date = $_POST['date']; // ดึงข้อมูลจาก form
  $time= $_POST['time']; // ดึงข้อมูลจาก form
  if (
    // ถ้าช่องใดช่องนึงว่างจะขึ้นโปรดเติมช่องว่าง
    empty($firstname_lastname) ||
    empty($date) || empty($time)
  ) {
    echo "<script>
    Swal.fire({
      title: 'โปรดเติมช่องที่ว่าง',
      icon: 'error',
      showConfirmButton: false,
      timer: 1500
    })
   </script>";
  }
  else
  {
    $targetDir = "slip/"; // โฟลเดอที่ต้องการให้อัพโหลด
  $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

  if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] == 0) {

    // ถ้าไฟล์ที่อัพโหลดมีอยู่แล้วจะขึ้นตามนนี้
      if (file_exists($targetFile)) {
        echo "<script>
                  Swal.fire({
                    title: 'มีไฟล์อยู่แล้ว',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 1500
                  })
              </script>";
          $uploadOk = 0;
      }

      // โฟลเดอห้ามใหญ่เกินไป
      if ($_FILES["fileToUpload"]["size"] > 5000000) {
        echo "
        <script>
            Swal.fire({
              title: 'ไฟล์ใหญ่เกินไป',
              icon: 'error',
              showConfirmButton: false,
              timer: 1500
            })
        </script>";
          $uploadOk = 0;
      }

      // เช็คชนิดของไฟล์
      if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif") {
          $uploadOk = 0;
      }

      if ($uploadOk == 1) {
        // rand จะเป็นการ random ตัวเลข คล้ายๆ math.random เหมือน lua
          $random_number = rand(1, 1000000000000000);
          $newName = $firstname_lastname.$random_number.".".$imageFileType; // ตั้งชื่อไฟล์ แต่ในการตั้งชื่อ ได้ทำการ random เพื่อไม่ให้ไฟล์ซ้ำกัน
          $targetFile = $targetDir . $newName;
          // ในส่วนนี้จะเป็น function การส่งเข้า ไลน์ คือ รูปภาพ และ ราคา และ ชื่อ
          line_notify($_SESSION['name'], $_GET['price_value'], $_FILES["fileToUpload"]["tmp_name"]);
          echo "<script>
          window.location.href = '../index.php';
          </script>";
          if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {} 
          else {
            // ถ้ามีข้อผิดพลาดจะแสดง sweetalert2 โช ข้อความ ข้อผิดพลาด
            echo "
            <script>
              Swal.fire({
                title: 'มีข้อผิดพลาด',
                icon: 'error',
                showConfirmButton: false,
                timer: 1500
              })
            </script>";
          }
      }
  } else {
    // ถ้ามีข้อผิดพลาดจะแสดง sweetalert2 โช ข้อความ ข้อผิดพลาด
      echo "
      <script>
        Swal.fire({
          title: 'มีข้อผิดพลาด',
          icon: 'error',
          showConfirmButton: false,
          timer: 1500
        })
      </script>";
  }
  }

}
?>


<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  Upload_File();

}
  


?>

<script>
  function confirmSubmit() {
    Swal.fire({
    title: 'ยืนยันการส่งฟอร์ม',
    text: 'คุณต้องการที่จะส่งฟอร์มนี้ใช่หรือไม่?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'ยืนยัน',
    cancelButtonText: 'ยกเลิก',
  }).then((result) => {

    if (result.isConfirmed) {
 
      document.getElementById("myForm").submit();
    }
  })

  }
</script>





<script>

    $('#preview-image').hide();
    var fileInput = document.getElementById('file-input');
    var previewImage = document.getElementById('preview-image');

    fileInput.addEventListener('change', function() {
        var file = this.files[0];
        var reader = new FileReader();

        reader.addEventListener('load', function() {
            previewImage.src = reader.result;
        });

        reader.readAsDataURL(file);

        $('#preview-image').fadeIn();
    });

    function confirmSubmist() {
      event.preventDefault();
      Swal.fire({
      title: 'ยืนยันใช่หรือไม่',
      text: "คุณยืนยันที่ส่งใช่หรือไม่",
      icon: 'warning',
      showCancelButton: true,

      confirmButtonText: 'ยืนยัน'
      }).then((result) => {
        if (result.isConfirmed) {

          document.querySelector('form').submit();
        }
      })
    
    };
</script>


</body>
</html>