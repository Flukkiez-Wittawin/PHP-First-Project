<?php
$variable =array(
  'navbar',

);
foreach ($variable as $include_function) {
  include 'bar/'.$include_function.'.php';
};


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าหลัก</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
</head>
<body>
  
<div class='contan'>
  <img draggable="false" id='Projectimages' style="margin:10px 20px;" width="500" src="">
  <h1 id='Project_All' style="margin:10px 23px; color:white;">PROJECT NAME : <br> 
  <span style="color:white;" id='Projectname'>Name</span></h1>
</div>


<script>
    $(`#Projectimages`).hide();
    $(`#Projectimages`).hide();
    $(`#Project_All`).hide();
  </script>
<?php
session_start();




if(!isset($_SESSION['email'])) {
  header('location: login.php');
}

echo "<script>
const Toast = Swal.mixin({
    toast: true,
    position: 'center',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,

  })
  
  Toast.fire({
    icon: 'success',
    title: 'ยินดีต้อนรับ ".$_SESSION['name']."'
  })
  </script>";


?>



<div class="form-wrapper">
    <form class="topup_form">
    <ul class="topup_ul">
      <?php
      function getsql_point () {
        echo '<li class="list-item" onclick="go_control(`profile/web_owners_profile`)" style="font-size:22px;">Personal information of web owners</li>';
        echo '<li class="list-item" onclick="go_control(`profile/user_profile`)">Profile</li>';
        $db = mysqli_connect('localhost', 'root', '', 'database');
      
      
      
      
        $query = "SELECT * FROM users WHERE email='".$_SESSION['email']."'";
        $result = mysqli_query($db, $query);
      
        if(mysqli_num_rows($result) == 1) {
          $row = mysqli_fetch_assoc($result);
          $point = $row['point'];
          
          if ($point >= 1000000) {
            $point = $point/1000000 . 'M';
            echo '<li class="list-item" onclick="
            Swal.fire(
              `จำนวนเงินคงเหลือ`,
              `คุณเหลือเงินจำนวน '.$row['point'].' บาท`,
              `success`
            )
            ">มีเงินเหลืออยู่ '.$point.' บาท</li>';
          }
          elseif ($point >= 1000) {
            $point = $point/1000 . 'K';
            echo '<li class="list-item" onclick="
            Swal.fire(
              `จำนวนเงินคงเหลือ`,
              `คุณเหลือเงินจำนวน '.$row['point'].' บาท`,
              `success`
            )
            ">มีเงินเหลืออยู่ '.$point.' บาท</li>';
          } 
          else
          {
            echo '<li class="list-item" onclick="
            Swal.fire(
              `จำนวนเงินคงเหลือ`,
              `คุณเหลือเงินจำนวน '.$row['point'].' บาท`,
              `success`
            )
            ">มีเงินเหลืออยู่ '.$point.' บาท</li>';
          }

          
        }
      };

      function getsql_project () {
        $db = mysqli_connect('localhost', 'root', '', 'database');
      
        $query = "SELECT * FROM data_project ";
        $result = mysqli_query($db, $query);
      
        if(mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            echo '<li class="list-item">โปรเจ็คที่ '.$row['id'].'</li>';
          }
        }
        else {
          echo '<li class="list-item">ไม่มีโปรเจ็คในตอนนี้</li>';
        }
      };
      function menulist () {
        getsql_point ();
        getsql_project ();
      };
      
      
      if ($_SESSION['group'] == 'user') {
        menulist ();
      }
      elseif ($_SESSION['group'] == 'admin') {
        echo '<li class="list-item" onclick="go_control(`admin`)">ADMIN Controls</li>';
        menulist ();
      }
      
      ?>
    </ul>
    </form>
</div>

<script>
  go_control = (page) => {

    Swal.fire({
      title: 'ยืนยันที่จะไปหน้าต่อไปใช่ไหม',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'ยืนยัน',
      cancelButtonText: 'ยกเลิก'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = `${page}.php`;
      }
    })

  }
</script>

<style>
  .contan {
    /* position: absolute;
    transform: translate(-50%,-50%); */

    background: linear-gradient(90deg, #1cb5e04f 0%, #0044ff52 100%);
    width: 70%;
    height: 80%;
    border-radius: 10px;
    border:1px solid #f5f5f531;
    box-shadow: 0px 0px 5px inset white;
    float: right;
    margin:20px 15px;
    overflow-y: scroll ;
  }
  
.form-wrapper {
    overflow-y: scroll ;
    height: 90%;
  }
  .form-wrapper::-webkit-scrollbar
  {
  	width: 0px;
  	background-color: #F5F5F5;
  }
  body {
    overflow: hidden;
  }
  .list-item {
    font-family: Mitr, sans-serif;
    text-align: center;
    color: #ffffff;
    font-size: 30px;
    font-weight: bold;
    padding: 50px;
    width: 70%;
    background-color: rgb(53, 55, 58);
    border-radius: 5px;
    transition: 1s;
    margin: 5px -37px;
    left:0%;
    list-style: none;
    

  }

  a {text-decoration: none;}

  .list-item:hover {
    transition:1s;
    opacity:0.9;
    cursor: pointer;
    box-shadow: 0px 0px 1000px inset grey;
  }
</style>


</body>
</html>