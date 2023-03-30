<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าสมัครสมาชิก</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>

<style>
    body {
  background-image: url("https://media.discordapp.net/attachments/1042762590411038791/1059463965337473104/desktop-backgrounds-nawpic-28.jpg?width=788&height=473");
  background-size: cover;
  background-position: center;
}

</style>

<script>
  // ใช้ sweetalert2 ในการเป็ form หลักในการสมัคร
    Swal.fire({
  title: 'สมัครสมาชิก',
  html: `
  <form action="register.php" method="post">

    <input class="swal2-input" type="text" name="username" id="username" placeholder='ชื่อ'>
    

    <input class="swal2-input" type="email" name="email" id="email" placeholder='อีเมล'>

    <input class="swal2-input" type="password" name="password" id="password" placeholder='Password'>
    
    <input class="swal2-input" type="password" name="confirm_password" id="confirm_password"  placeholder='ยืนยัน Password'>
    <br><br>
    <button class="loginbtt" type="submit" name="register">Register</button>
</form>
<p>มีรหัสอยู่แล้วใช่หรือไม่ <a href="login.php">เข้าสู่ระบบ</a>

  `,
  confirmButtonText: 'Sign in',
  showConfirmButton: false,
  focusConfirm: false,
  allowOutsideClick : false,
})

</script>

<?php
// ถ้ากดยืนยันการสมัคร
if (isset($_POST['register'])) {

    $name = $_POST['username']; // ดึงข้อความจากช่อง username ของ form
    $email = $_POST['email']; // ดึงข้อความจากช่อง email ของ form
    $password = $_POST['password']; // ดึงข้อความจากช่อง password ของ form
    $confirm_password = $_POST['confirm_password']; // ดึงข้อความจากช่อง confirm_password ของ form
    
    // ถ้าไม่เติมลงในช่อง
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
      echo "<script>
              Swal.fire({
                icon: 'error',
                title: 'แจ้งเตือน',
                text: 'โปรดใส่ข้อความ',
                showConfirmButton: false,
                
              });
              setTimeout(() => {
                history.back();
        
            }, 1000);
            </script>";
    } else {
// เชื่อม sql
      $conn = new mysqli("localhost", "root", "", "database");
    
// เช็คว่า มีชื่อ หรือ email ซ้ำ หรือไม่
      $sql = "SELECT COUNT(*) AS count FROM users WHERE name = '$name' OR email = '$email'";
      $result = $conn->query($sql);
      $row = $result->fetch_assoc();
    
      if ($row['count'] > 0) {
// ถ้ามี จะแสดง sweetalert2
        echo "<script>
                Swal.fire({
                  icon: 'error',
                  title: 'แจ้งเตือน',
                  text: 'ชื่อ และอีเมล มีอยู่แล้ว',
                  showConfirmButton: false,
                });

                setTimeout(() => {
                    history.back();
            
                }, 1000);
              </script>";
              

      } else {
// เชื่อม sql
        $connection = mysqli_connect('localhost', 'root', '', 'database');
// เปลี่ยน จากตัวอักษรเป็น hash
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
// เพิ่มข้อมูลเข้า sql
        $query = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed_password')";
        mysqli_query($connection, $query);
    
// กลับไปหน้า login
        header("Location: login.php");
        exit();
        
        
      }
    
       
    }
}
    
    ?>

</body>
</html>
