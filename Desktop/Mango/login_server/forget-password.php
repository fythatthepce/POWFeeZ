<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Mango-feez</title>

</head>

<body>
<?php
if($_POST) {
	//include "dblink.php";
     //include "new-member.php";


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


    $email = $_POST['email'];
	$err = "";
	$msg = "";
	
	//$sql = "SELECT password FROM member WHERE email='$email'";
	$sql = "SELECT * FROM member  
		 		WHERE  email = '$email'";

    $rs = mysqli_query($link, $sql);
	$data = mysqli_fetch_array($rs);
	if(mysqli_num_rows($rs) == 0) {
		$err  = 'ท่านใส่อีเมลไม่ถูกต้อง';
	}	
		
	else {

	   //send email
       $to = "<$email>";
       $subject = "Mango store service";
       $txt = "Password : $data[4]";     //เนื่องจาก password อยู่ช่องที่ 3 ในตาราง table จึงต้อง data[3]

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

	if($err != "") {
		echo "<div><h3 class=\"red\">$err</h3></div>";
	}
	else if($msg != "") {
		echo "<h3>$msg</h3><br>";
		echo '<a href="index2.php">กลับหน้าหลัก</a>';
		mysqli_close($link);
		exit('</body></html>');
	}
	mysqli_close($link);
}
?>
<h3>ลืมรหัสผ่าน</h3>
<form method="post">
		<input type="text" name="email" placeholder="อีเมลที่ท่านใช้สมัครสมาชิก" required><br>
      	<span>
     		<button>ส่งข้อมูล</button><br class="clear">
     	</span>
</form>
<p><a href="index2.php">กลับหน้าหลัก</a></p>
</body>
</html>