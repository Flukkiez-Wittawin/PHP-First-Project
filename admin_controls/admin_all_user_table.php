<br>
<center>


  <!-- ในส่วนนี้จะเป็นตาราง ของ user ทุกคน -->
<table>

<thead>
    <tr>
        <th>ID</th>
        <th>Email</th>
        <th>Username</th>
        <th>Point</th>
        <th>Group</th>
        <th>Delete</th>
    </tr>
</thead>

<tbody>
    
<?php
// ในส่วนนี้คือ การเชื่อมต่อ ข้อมูล database ของ sql
// ในส่วนพวก $row['ตัวแปร'] จะดึงพวก ข้อมูล ตัวแปร ต่างๆใน table ออกมา และแสดงออกมา่ใน <td> ที่ใส่ row วางไว้
// และ
// ในส่วน ปุ่มจะมีการเชื่อม sweetalert2 วางไว้ เพื่อ กดยืนยัน และจะใช้ window.href เข้าช่วย link?ชื่อตัวแปร=ตัวแปรที่ใส่
$db = mysqli_connect('localhost', 'root', '', 'database');



// ในส่วนนี้คือ การดึง ข้อมูล users ของ database ของ sql
$query = "SELECT * FROM users";
$result = mysqli_query($db, $query);

// ในส่วนนี้คือ การเช็คข้อมูลใน sql ถ้ามีมากกว่า 0 จะแสดงขึ้นมา
if(mysqli_num_rows($result) > 0 ) {
while ($row = mysqli_fetch_assoc($result)) {
echo '
<tr>

    <td>'.
    $row['id'].'</td>

    <td>'.$row['email'].'</td>

    <td>'.$row['name'].'
    <button class="btt_replace" onclick="
    Swal.fire({
        title: `ยืนยันที่จะเปลี่ยนข้อมูล name`,
        text: `จะเปลี่ยนข้อมูลของ user ใช่หรือไม่`,
        icon: `warning`,
        showCancelButton: true,
        confirmButtonText: `ยืนยัน`,
        cancelButtonText: `ยกเลิก`,
      }).then((result) => {
        if (result.isConfirmed) {
          update_name('.$row['id'].')
        }
      })

    ">แก้ไข</button>
    </td>
    <td>'.$row['point'].' 
    <button class="btt_replace" onclick="
    Swal.fire({
        title: `ยืนยันที่จะเปลี่ยนข้อมูล point`,
        text: `จะเปลี่ยนข้อมูลของ user ใช่หรือไม่`,
        icon: `warning`,
        showCancelButton: true,
        confirmButtonText: `ยืนยัน`,
        cancelButtonText: `ยกเลิก`,
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire({
            title: `ใส่จำนวนเงินที่ต้องการเปลี่ยน`,
            input: `number`,
            inputAttributes: {
              min: 0,
              max: 100000000000,
            },
            showCancelButton: true,
            confirmButtonText: `Submit`,
            cancelButtonText: `Cancel`,
          }).then((result) => {
            if (result.isConfirmed) {
              const number = result.value;
              update_point(number,'.$row['id'].')
            }
          });
        }
      })

    ">แก้ไข</button>
    </td>

    <td>'.$row['group'].' 
    <button class="btt_replace" onclick="
    Swal.fire({
        title: `ยืนยันที่จะเปลี่ยนข้อมูล group`,
        text: `จะเปลี่ยนข้อมูลของ user ใช่หรือไม่`,
        icon: `warning`,
        showCancelButton: true,
        confirmButtonText: `ยืนยัน`,
        cancelButtonText: `ยกเลิก`,
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire({
            title: `เปลี่ยนสถานะของ user`,
            input: `select`,
            inputOptions: {
              admin: `ADMIN`,
              user: `USER`,
            },
            inputPlaceholder: `โปรดเลือก`,
            showCancelButton: true,
            cancelButtonText: `ยกเลิก`,
            confirmButtonText: `ยืนยัน`
          }).then((result) => {
            if (result.isConfirmed) {
              const selectedOption = result.value;
              if (!selectedOption) {
                Swal.fire(`โปรดเลือก`)
              }
              else
              {
                update_group('.$row['id'].', selectedOption)
              }
              
            }
          });
        }
      })

    ">แก้ไข</button>
    </td>

    <td>
    <center>
      <button class="btt" onclick="
        Swal.fire({
            title: `ยืนยันที่จะลบข้อมูลใช่หรือไม่`,
            text: `จะลบข้อมูลของ user ใช่หรือไม่`,
            icon: `warning`,
            showCancelButton: true,
            confirmButtonText: `ยืนยัน`,
            cancelButtonText: `ยกเลิก`,
          }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `../flukky_project/backend/delete_user_sql.php?id='.$row['id'].'`;
            }
          })

        ">ลบ
      </button>
    </center>
    </td>
</tr>
';
}
}

?>

<script>
// $id = $_GET['id'];
// $columtable = $_GET['columtable'];
// $incolumntable = $_GET['incolumntable'];

// ในส่วน คือส่วนที่จะใช้ function เข้าไปในปุ่มเพื่อไปหน้าต่อไป

update_point = (incolumntable, id) => {
window.location.href = `../flukky_project/backend/update_sql_table_users_point.php?id=${id}&incolumntable=${incolumntable}`;
}

update_group = (id, selectedOption) => {
window.location.href = `../flukky_project/backend/update_sql_table_users_group.php?id=${id}&group=${selectedOption}`;
}


update_name = (id) => {
  // ในส่วน คือส่วนที่จะให้เลือกระหว่าง user กับ admin เป็นปุ่มๆไว้เพื่อให้ง่าย
Swal.fire({
title: `เปลี่ยนชื่อ user`,
html: `<input type="text" id="newnickname" class="swal2-input" placeholder="Name">`,
confirmButtonText: `ยืนยัน`,
focusConfirm: false,
preConfirm: () => {
const name = Swal.getPopup().querySelector(`#newnickname`).value
if (!name) {
  Swal.showValidationMessage(`Please enter name`)
}
if (name.length > 15) {
  Swal.showValidationMessage(`ชื่อยาวเกินไป`)
}
return { name: name}
}
}).then((result) => {
window.location.href = `../flukky_project/backend/update_sql_table_users_username.php?id=${id}&name=${result.value.name}`;
})
}

</script>
        
    
</tbody>

</table>


</center>
