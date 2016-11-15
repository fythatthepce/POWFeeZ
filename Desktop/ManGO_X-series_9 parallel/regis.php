<html>
<head>
    <meta charset="utf-8">
    <title>PHP Email Verification Script Using PDO</title>
</head>
<body>
  <?php
      require_once 'dblink.php';
      if(isset($_POST['register'])){





          $regular_expression = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/';
          $user_fname = $_POST['user_fname'];
          $user_lname = $_POST['user_lname'];
          $user_address = $_POST['user_address'];
          $user_phone = $_POST['user_phone'];
          $user_password  = $link->real_escape_string($_POST['user_password']);
          $user_passcheck  = $link->real_escape_string($_POST['user_passcheck']);





          if(preg_match($regular_expression, $user_email)){


            $err = "";
            if($user_password !== $user_passcheck) {
              $err .= "<li>ใส่รหัสผ่านทั้งสองครั้งไม่ตรงกัน</li>";
            }


            $user_email  	= trim($link->real_escape_string($_POST['user_email']));

            if(!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
              $err .= "<li>อีเมลไม่ถูกต้องตามรูปแบบ</li>";
            }
            
              $checkEmailId = "SELECT id FROM tbl_users_registration WHERE email_id = '".$user_email."'";
              $resEmail=$link->query($checkEmailId);
              $rows_returned = $resEmail->num_rows;
              if($rows_returned > 0){
                  $msg = 'The email is already taken, please try new.';
              }else{
                  $activation_key =md5($user_email.time());
                  $salt = 'randomstring'; //generate random string
                  $hashed_value = md5($salt.$user_password);
                  $sqlInsertUser = $link->query("INSERT INTO tbl_users_registration (email_id, password,fname,lname,address,phone,activation_key) VALUES('$user_email','$hashed_value','$user_fname','$user_lname','$user_address','$user_phone','$activation_key')");

                  /*** Script for send email start here ***/
                  $body='Please verify your email : http://mango.servehttp.com:8080/activate_account.php?key='.$activation_key;

                  //send email
                  $to = "<$user_email>";
                  $subject = "Mango store service";
                  $txt = "$body";
                  $headers = "From:noreply@mango.com" . "\r\n" .
                   "CC:noreply@mango.com";

                  $flgSend = mail($to,$subject,$txt,$headers);
                  if($flgSend)
                  {
                    echo "ทำการส่งรหัสยืนยันเรียบร้อย...";
                  }
                 else
                 {
                    echo "Mail cannot send.";
                 }

              }
          }
       }
  ?>

    <div class='web'>
        <form class="myform" action="regis.php" method="post">
            <?php if(isset($msg)) echo $msg; ?>
            <div class='input'>Email: <div><input type="text" name="user_email" required/></div>
            <div class='input'>Password: <input type="password" name="user_password" required/></div>
            <div class='input'>Password again: <input type="password" name="user_passcheck" required/></div>


            <div class='input'>Firstname: <div><input type="text" name="user_fname" required/></div>
            <div class='input'>Lastname: <div><input type="text" name="user_lname" required/></div>
           <div class='input'>Address: <div><input type="text" name="user_address" required/></div>
           <div class='input'>Phone: <div><input type="text" name="user_phone" required/></div>




            <input type="submit" value="register" name="register" Class="btn" />
        </form>
    </div>
</body>
</html>
