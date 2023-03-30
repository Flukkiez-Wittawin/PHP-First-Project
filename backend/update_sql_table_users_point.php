<link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-material-ui/material-ui.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>


<body>
<?php
$db = mysqli_connect('localhost', 'root', '', 'database');


$id = $_GET['id'];// เอาค่าของตัวแปรที่ส่งมา คือ ID

$incolumntable = $_GET['incolumntable'];// เอาค่าของตัวแปรที่ส่งมา คือ incolumntable หรือ point นั่นเอง
// อัพเดท ค่า point ว่าจะเซ็ทเป็นเท่าไหร่
$query="UPDATE database.users SET point = '$incolumntable' WHERE id = '$id';
";
$result = mysqli_query($db, $query);
mysqli_close($db);

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
?>
</body>