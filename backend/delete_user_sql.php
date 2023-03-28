<?php
$db = mysqli_connect('localhost', 'root', '', 'database');


$id = $_GET['id'];

$query = "DELETE FROM users WHERE id =$id";
$result = mysqli_query($db, $query);
mysqli_close($db);

if  ($result) {
    echo '<script> window.location.href = "../index.php" </script>';
}
else 
{
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