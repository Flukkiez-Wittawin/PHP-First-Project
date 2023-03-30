<?php
// เริ่ม session
session_start();
// ทำลาย หรือ ออก session
session_destroy();

// กลับหน้า ล็อกอิน
header('location: login.php');

?>