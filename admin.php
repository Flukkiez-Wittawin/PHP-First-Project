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
<link rel="stylesheet" href="admin_controls/admin_style.css">
<link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-material-ui/material-ui.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แอดมิน</title>
</head>
<body>
    <?php
    // ดึง table จากหน้า admin_all_user_table.php

    include 'admin_controls/admin_all_user_table.php'
    ?>
    <style>
      body {
    overflow-y: scroll ;

  }
  ::-webkit-scrollbar
  {
  	width: 0px;
  	background-color: #F5F5F5;
  }
    </style>
</body>
</html>