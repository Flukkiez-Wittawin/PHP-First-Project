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
include '../notify/line_notify.php';
session_start();


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
      <input type="text" name="username" class='swal2-input' value="<?php echo $_SESSION['name'];?>" readonly disabled>
      <label for="username">ราคา :</label>
      <input type="number" name='pricemoney' class='swal2-input' value="<?php echo $_GET['price_value'];?>" readonly disabled>
      <p>QR CODE Payment <br> สแกนจ่ายได้เลย : </p>
      <center>
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
      <button type="submit" name='submit' onclick="confirmSubmit()">ยืนยัน</button><br>
      <button onclick="window.location.href = '../index.php';">ยกเลิก</button>
  </div>
  </div>
  
</div>

<?php

function Upload_File () {

  $firstname_lastname = $_POST['firstname_lastname'];
  // $fileToUpload= $_POST['fileToUpload'];
  $date = $_POST['date'];
  $time= $_POST['time'];
  if (
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
    $targetDir = "slip/";
  $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

  if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] == 0) {

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

      if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif") {
          $uploadOk = 0;
      }

      if ($uploadOk == 1) {
          $random_number = rand(1, 1000000000000000);
          $newName = $firstname_lastname.$random_number.".".$imageFileType;
          $targetFile = $targetDir . $newName;
          line_notify($_SESSION['name'], $_GET['price_value'], $_FILES["fileToUpload"]["tmp_name"]);
          echo "<script>
          window.location.href = '../index.php';
          </script>";
          if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {} 
          else {
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