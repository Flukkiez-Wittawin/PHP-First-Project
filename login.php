<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ</title>
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
  // ในส่วนนี้จะเป็นหน้า login โดยใช้ sweetalert2 เป็นหน้าเติมรหัส
    Swal.fire({
  title: 'เข้าสู่ระบบ',
  html: `
  <form method="post" action="login.php">
  <input type="email" name="email" class="swal2-input" placeholder="Email" required>
  <input type="password" name="password" class="swal2-input" placeholder="Password" required>
  <br><br>
  <button type="submit" class="loginbtt" name="login">Login</button><br>
  <p>ยังไม่มีรหัสใช่หรือไม่ <a href="register.php">Register</a>
</form>
  `,
  confirmButtonText: 'Sign in',
  showConfirmButton: false,
  focusConfirm: false,
  allowOutsideClick : false,
})

</script>

<?php
// ถ้ากด login จะเข้าสู่ระบบ และ ส่งข้อมูล POST หรือ ที่กรอก ต่างๆ
if(isset($_POST['login'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];
  

// เชื่อม database
  $db = mysqli_connect('localhost', 'root', '', 'database');



// เลือก email จาก users
  $query = "SELECT * FROM users WHERE email='$email'";
  $result = mysqli_query($db, $query);

  if(mysqli_num_rows($result) == 1) {
    // ถ้าข้อมูลของ  user มีในระบบ
    $row = mysqli_fetch_assoc($result);

    $name = $row['name']; // ดึงข้อมูล name จาก sql
    $group = $row['group']; // ดึงข้อมูล group จาก sql

    $hashed_password = $row['password']; // ดึงข้อมูล password จาก sql
    // ปลดรหัส hash ให้ตรงเพื่อยืนยัน password
    if (password_verify($password, $hashed_password)) {
       // เริ่ม session
        session_start();
       
        
        $_SESSION['email'] = $email; // ใส่ session ตามตัวแปร
        $_SESSION['name'] = $name;// ใส่ session ตามตัวแปร
        $_SESSION['group'] = $group;// ใส่ session ตามตัวแปร

    

        header('location: index.php'); // ไปหน้า index หรือ หน้าหลัก
        exit();
    }
    
  } else {
    //  ถ้า email ไม่มีในระบบ จะ refresh หน้า

    echo "Invalid email.";
    sleep(0.5);
    header("Location: $_SERVER[PHP_SELF]");
    exit();
  }
}


?>

    
</body>
</html>


