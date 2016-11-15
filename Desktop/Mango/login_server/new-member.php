<?php session_start();  ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Mango-shop</title>

</head>

<body>
<?php
if($_POST) {
	//include "dblink.php";

	 //connect Database
     $servername = "localhost";
     $username = "root";
     $pwds = "mango592016";
     $dbname = "mangostore";

     $link = mysqli_connect($servername,$username,$pwds,$dbname);
     if(!$link)
     {
       die("Fail to connect Database: " . mysqli_connect_error());
     }
      //Change character set to utf8
      mysqli_set_charset($link,"utf8");
				
	//post to database			
	$name = $_POST['name'];
	$lname = $_POST['lname'];
	$email = $_POST['email'];	
	$pw1 = $_POST['pswd'];
	$address = $_POST['address'];
	$phone = $_POST['phone'];

    //define for check
	$pw2 = $_POST['pswd2'];



	
	$err = "";
	if($pw1 !== $pw2) {
		$err .= "<li>ใส่รหัสผ่านทั้งสองครั้งไม่ตรงกัน</li>";
	}
	
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$err .= "<li>อีเมลไม่ถูกต้องตามรูปแบบ</li>";
	}
	
	//ตรวจสอบว่าอีเมลนี้ใช้สมัครไปแล้วหรือยัง
	$sql = "SELECT COUNT(*) FROM member WHERE email = '$email'";
	$rs = mysqli_query($link, $sql);
	$data = mysqli_fetch_array($rs);
	if($data[0] != 0) {
		$err  .= "<li>อีเมลนี้เป็นสมาชิกอยู่แล้ว</li>";
	}		
	
	if($_POST['captcha'] !== $_SESSION['captcha']) {
		$err .= "<li>ใส่อักขระไม่ตรงกับในภาพ</li>";
	}

	//ถ้ามีข้อผิดพลาดอะไรบ้าง ก็แสดงออกไปทั้งหมด
	if($err != "") {
		echo '<div>';
		echo '<h3 class="red">เกิดข้อผิดพลาดดังนี้คือ</h3>';
		echo "<ul class=\"red\">$err</ul>";
		echo '</div>';
	}
	else {	//ถ้าไม่มีข้อผิดพลาด
		$rand = mt_rand(100000, 999999);	  //verify code
		$sql = "INSERT INTO member VALUES(
					'', '$name', '$lname', '$email', '$pw1', '$address' , '$phone','$rand')";  //ใส่ข้อมูลจากตัวแปรลงตามช่อง
	
		mysqli_query($link, $sql);
		
		
       //send email
       $to = "<$email>";
       $subject = "Mango store service";
       $txt = "Verification codes : $rand";
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
         echo '<a href="index2.php">กลับหน้าหลัก</a>';;
         mysqli_close($link);
         exit('</body></html>');
    }
      mysqli_close($link);
  }
 ?>

<h3>สมัครสมาชิก</h3>
<form method="post">

		Firstname: <input type="text" name="name" placeholder="ชื่อของท่าน" /><br><br>

		Lastname: <input type="text" name="lname" placeholder="นามสกุลของท่าน" /><br><br>

		Email: <input type="text" name="email" placeholder="อีเมล์ของท่านสำหรับเป็นล็อกอิน" /><br><br>


	    password: <input type="text" name="pswd" placeholder="รหัสผ่าน" />
                  <input type="text" name="pswd2" placeholder="ใส่รหัสผ่านซ้ำอีกครั้ง" /><br><br>


        Address: <input type="text" name="address" placeholder="ที่อยู่ของท่าน" /><br><br>
        Phone Number: <input type="text" name="phone" placeholder="เบอร์โทรศัพท์ของท่าน" />


      <br>
      <br>

      <?php
	 	include "AntiBotCaptcha/abcaptcha.php";
		captcha_text_length(5);
		captcha_echo();
	 	?>

	   <br>
       <input type="text" name="captcha" placeholder="อักขระในภาพ" required>

      <br>

     <span>
     <label>
         <input type="checkbox" name="accept" required>ยอมรับเงื่อนไขของเว็บไซต์... 
      </label>

      <br>

     <button>สมัครสมาชิก</button><br class="clear">
     </span>
</form>

<p><a href="index2.php">กลับหน้าหลัก</a></p>
</body>
</html>