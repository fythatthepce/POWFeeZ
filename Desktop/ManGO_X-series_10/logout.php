<?php
session_start();
session_destroy();

//ลบคุกกี้การเข้าสู่ระบบ
$expire = time() - 3600;
setcookie('email', '', $expire);
setcookie('pswd', '', $expire);

//ให้ใช้เฮดเดอร์ refresh เพื่อหน่วงเวลาให้
//PHP สามารถส่งข้อมูลกลับมายังเบราเซอร์ได้
header("refresh: 0; url=index2.php");
?>
<!doctype html>
<html>
<head>
	<title>ManGo</title>
	<link rel="shortcut icon" href="mangog.png">
<meta charset="utf-8">
<style>
	body {
		cursor: wait;
		text-align: center;
	}
	h3.green {
		color: black;
	}
</style>
</head>

<body>
	<?php
	echo '<script language="javascript">';
	echo 'alert("ท่านออกจากระบบแล้ว")';
	echo '</script>';
	?>

</body>
</html>
