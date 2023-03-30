<link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-material-ui/material-ui.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>


<body>
<?php
// เชื่อมต่อ database
$db = mysqli_connect('localhost', 'root', '', 'database');


$id = $_GET['id'];// เอาค่าของตัวแปรที่ส่งมา คือ ID

$incolumntable = $_GET['group'];// เอาค่าของตัวแปรที่ส่งมา คือ group

// อัพเดท ค่า ว่า เป็น user หรือ admin ตาม id
$query="UPDATE `users` SET `group` = '$incolumntable' WHERE `id` = '$id';
";
$result = mysqli_query($db, $query);


if  ($result) {
  // ถ้า ไม่มีข้อผิดพลาด จะแสดงตามส่วนนี้
  echo "
<script>
let timerInterval
Swal.fire({
  icon: 'success',
  title: 'ดำเนินการสำเร็จ',
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
</script>
";
}
else 
{
  // ถ้า มีข้อผิดพลาด จะแสดงตามส่วนนี้
echo "
<script>
let timerInterval
Swal.fire({
  icon: 'error',
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
</script>
";
}
mysqli_close($db);
?>
</body>