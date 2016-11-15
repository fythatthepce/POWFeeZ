<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <style>
   body, html{
   height: 100%;
   background-repeat: no-repeat;
   background-color: #d3d3d3;
   font-family: 'Oxygen', sans-serif;
  }

  .main{
    margin-top: 70px;
  }

  h1.title {
    font-size: 50px;
    font-family: 'Passion One', cursive;
    font-weight: 400;
  }

  hr{
    width: 10%;
    color: #fff;
  }

  .form-group{
    margin-bottom: 15px;
  }

  label{
    margin-bottom: 15px;
  }

  input,
  input::-webkit-input-placeholder {
  font-size: 11px;
  padding-top: 3px;
  }

  .main-login{
  background-color: #fff;
  /* shadows and rounded borders */
  -moz-border-radius: 2px;
  -webkit-border-radius: 2px;
  border-radius: 2px;
  -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
  -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
  box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);

  }

  .main-center{
    margin-top: 30px;
    margin: 0 auto;
    max-width: 330px;
    padding: 40px 40px;

  }

  .login-button{
    margin-top: 5px;
  }

  .login-register{
    font-size: 11px;
    text-align: center;
  }
</style>

</head>
   <body>
<?php
     //connect Database
     $servername = "localhost";
     $username = "root";
     $password = "mango592016";
     $dbname = "mangostore";

     $link = mysqli_connect($servername,$username,$password,$dbname);
     if(!$link)
     {
       die("Fail to connect Database: " . mysqli_connect_error());
     }
      //Change character set to utf8
      mysqli_set_charset($link,"utf8");

     //Check POST
     if($_POST){
       //---- define for check data----
       $email = $_POST['email'];
       $pwd = $_POST['password'];
       $pwd2 = $_POST['password2'];
       //$cap = $_POST['captcha'];
       //$set_cap = $_SESSION['captcha'];


       //---- check Data ----
       $err = "";
       if($pwd !== $pwd2) {
         $err .= "<li>ใส่รหัสผ่านทั้งสองครั้งไม่ตรงกัน</li>";
       }

       if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
         $err .= "<li>อีเมลไม่ถูกต้องตามรูปแบบ</li>";
       }

       //ตรวจสอบว่าอีเมลนี้ใช้สมัครไปแล้วหรือยัง ใน member table
       $sql = "SELECT COUNT(*) FROM member WHERE email = '$email'";
       $rs = mysqli_query($link, $sql);
       $data = mysqli_fetch_array($rs);
       if($data[0] != 0) {
         $err  .= "<li>อีเมลนี้เป็นสมาชิกอยู่แล้ว</li>";
       }


       if($err != "") {
         echo '<div>';
         echo '<h3>เกิดข้อผิดพลาดดังนี้คือ</h3>';
         echo "<ul class=\"red\">$err</ul>";
         echo '</div>';
         echo "<a href='home.php'>กลับสู้หน้าสมัครสมาชิก</a>";
       }

       else{
      //---- send data ----
       $verify = mt_rand(100000, 999999);   //verify code

       mysqli_query($link,"SELECT * FROM member");
       mysqli_query($link,"INSERT INTO member (fname,lname,email,pass,address,phone,verify)
       VALUES('$_POST[fname]','$_POST[lname]','$_POST[email]','$_POST[password]','$_POST[address]','$_POST[phone]','$verify')");

       //send email
       $to = "<$email>";
       $subject = "Mango store service";
       $txt = "Verification codes : $verify";
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

		     echo "<h3>จัดเก็บข้อมูลของท่านเรียบร้อยแล้ว</h3><br>";
		     echo "เราได้จัดส่งรหัสการยืนยันไปทางอีเมลที่ท่านใช้สมัครแล้ว<br>";
		     echo 'กรุณานำรหัสดังกล่าวมายืนยันหลังจากล็อกอินเข้าสู่ระบบตามปกติ</a><br><br>';
		     echo '<a href="home.php">กลับหน้าหลัก</a>';;
	  	   mysqli_close($link);
		     exit('</body></html>');
    }
      mysqli_close($link);
  }
 ?>

<!--------- HTML -------->

  <!----- HTML POST FORM --->
 <form method="post" id="form1">

   <div class="container">
 <div class="row main">
   <div class="panel-heading">
            <div class="panel-title text-center">
               <h1 class="title">Mango Register</h1>
               <hr />
             </div>
         </div>
   <div class="main-login main-center">
     <form class="form-horizontal" method="post" action="#">

       <div class="form-group">
         <label for="fname" class="cols-sm-2 control-label">Your First Name</label>
         <div class="cols-sm-10">
           <div class="input-group">
             <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
             <input type="text" class="form-control" name="fname" id="name"  placeholder="Enter your First Name"/>
           </div>
         </div>
       </div>


       <div class="form-group">
         <label for="lname" class="cols-sm-2 control-label">Your Last Name</label>
         <div class="cols-sm-10">
           <div class="input-group">
             <span class="input-group-addon"><i class="fa fa-users fa" aria-hidden="true"></i></span>
             <input type="text" class="form-control" name="lname" id="username"  placeholder="Enter your Last Name"/>
           </div>
         </div>
       </div>


       <div class="form-group">
         <label for="email" class="cols-sm-2 control-label">Your Email</label>
         <div class="cols-sm-10">
           <div class="input-group">
             <span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
             <input type="text" class="form-control" name="email" id="email"  placeholder="Enter your Email"/>
           </div>
         </div>
       </div>


       <div class="form-group">
         <label for="password" class="cols-sm-2 control-label">Passwords</label>
         <div class="cols-sm-10">
           <div class="input-group">
             <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
             <input type="password" class="form-control" name="password" id="password"  placeholder="Enter your Passwords"/>
           </div>
         </div>
       </div>

       <div class="form-group">
         <label for="password2" class="cols-sm-2 control-label">Confirm Passwords</label>
         <div class="cols-sm-10">
           <div class="input-group">
             <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
             <input type="password" class="form-control" name="password2" id="confirm"  placeholder="Confirm your Passwords"/>
           </div>
         </div>
       </div>

       <div class="form-group">
         <label for="address" class="cols-sm-2 control-label">Your Address</label>
         <div class="cols-sm-10">
           <div class="input-group">
             <span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
             <input type="text" class="form-control" name="address" id="email"  placeholder="Enter your Address"/>
           </div>
         </div>
       </div>

       <div class="form-group">
         <label for="phone" class="cols-sm-2 control-label">Your Phone Number</label>
         <div class="cols-sm-10">
           <div class="input-group">
             <span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
             <input type="text" class="form-control" name="phone" id="email"  placeholder="Enter your Phone Number"/>
           </div>
         </div>
       </div>


       <div class="form-group">
         <div class="cols-sm-10">
           <span>
           <label>
              <input type="checkbox" name="accept" required>ยอมรับเงื่อนไขของเว็บไซต์
          </label>
         </div>
       </div>


       <div class="form-group ">
         <button type="submit" form="form1" value="สมัครสมาชิก" class="btn btn-primary btn-lg btn-block login-button">สมัครสมาชิก</button>
       </div>
       <div class="login-register">
               <a href="#">เข้าสู่ระบบ</a>
            </div>
     </form>
   </div>
 </div>
</div>

</form>
<!---- END FORM ---->

     <p><a href="home.php">กลับสู่หน้าหลัก</a></p>
  </body>
</html>