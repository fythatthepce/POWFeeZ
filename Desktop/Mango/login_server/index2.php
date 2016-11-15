<?php
session_start();
ob_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Mango</title>

</head>

<body>
<?php
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




//ตรวจสอบว่าเก็บข้อมูลการเข้าสู่ระบบไว้ในคุกกี้ หรือไม่
//ถ้ามี ให้กำหนดให้ตัวแปรได้เลย เพื่อให้เทียบเท่ากับการโพสต์ขั้นมาจากฟอร์ม
if(isset($_COOKIE['email']) && isset($_COOKIE['pswd'])) {
	$_POST['email'] = $_COOKIE['email'];
	$_POST['pswd'] = $_COOKIE['pswd'];
}

if($_POST) {
	$email = $_POST['email'];
	$pswd = $_POST['pswd'];

	$sql = "SELECT * FROM member
		 		WHERE  email = '$email' AND password = '$pswd'";

	$rs = mysqli_query($link, $sql);
	$data = mysqli_fetch_array($rs);
	if(mysqli_num_rows($rs) == 0) {
		$err  = '<span class="err">ท่านใส่อีเมล<br>หรือรหัสผ่านไม่ถูกต้อง</span>';
	}
	else {
		if(!empty($data['verify'])) {
			mysqli_close($link);
			header("location: verify.php");
			ob_end_flush();
			exit;
		}

		if($_POST['save_account']) {
			$expire = time() + 30*24*60*60;
			setcookie("email", "$email");
			setcookie("pswd", "$pswd");
		}

		 $_SESSION['user'] = $data['name'];
		 $_SESSION['email'] = $data['email'];


	}
}
mysqli_close($link);
?>
<aside>
	<h1>Mango-login</h1>
	<section id="top">
<?php
	 if(!isset($_SESSION['user'])) {
?>
    <?php echo $err; ?>
   	<fieldset><legend>สมาชิกเข้าสู่ระบบ</legend>
	<form id="login" method="post">
    	 <a href="new-member.php">สมัครสมาชิก</a> |
         <a href="verify.php">ยืนยันการสมัคร</a><br>
  		<input type="email" name="email" placeholder="อีเมล" required><br>
    	<input type="password" name="pswd" placeholder="รหัสผ่าน" required><br>
        <input type="checkbox" name="save_account">
        <span>เก็บข้อมูลไว้ในเครื่องนี้</span><br>
         <a href="forget-password.php" id="forget">ลืมรหัสผ่าน</a>
         <br>
         <br>
    	<button>เข้าสู่ระบบ</button>
    </form>
    </fieldset>
 <?php
 	}
 	else {
?>
	<fieldset><legend>ท่านเข้าสู่ระบบแล้ว</legend>
    	<?php echo $_SESSION['user']; ?><br><br>
    	<a href="logout.php">ออกจากระบบ</a>
	</fieldset>
<?php
	}
?>
	</section>
    <section id="bottom">
    <a href="admin.php">Administrator Login</a>
    </section>
</aside>

<br>
<p>Search...</p>
<form method="get">
<input type="text" name="q" maxlength="30" value="<?php echo stripslashes($_GET['q']); ?>" required>
    <button>ค้นหา</button>
</form>
<?php
  include "search2.php";
?>

</body>
</html>
<?php ob_end_flush(); ?>
