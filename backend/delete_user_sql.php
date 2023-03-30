<?php
// เชื่อม database
$db = mysqli_connect('localhost', 'root', '', 'database');


$id = $_GET['id'];// เอาค่าของตัวแปรที่ส่งมา คือ ID

$query = "DELETE FROM users WHERE id =$id"; // ลบ sql ของ user ตาม id
$result = mysqli_query($db, $query);
mysqli_close($db);

if  ($result) {
  // ถ้า sql ไม่มีข้อผิดพลาด จะแสดงผลตามที่ set ไว้ในนี้
    echo '<script> window.location.href = "../index.php" </script>';
}
else 
{
  // เถ้า sql มีข้อผิดพลาด จะแสดงผลตามที่ set ไว้ในนี้
echo "

let timerInterval
Swal.fire({
  title: 'มีข้อผิดพลาด',
  html: 'จะปิดใน <b></b> milliseconds.',
  timer: 2000,
  timerProgressBar: true,
  didOpen: () => {
    Swal.showLoading()
    const b = Swal.getHtmlContainer().querySelector('b')
    timerInterval = setInterval(() => {
      b.textContent = Swal.getTimerLeft()
    }, 100)
  },
  willClose: () => {
    clearInterval(timerInterval)
  }
}).then((result) => {

  if (result.dismiss === Swal.DismissReason.timer) {
    window.location.href = '../index.php'
  }
})

";
}
?>