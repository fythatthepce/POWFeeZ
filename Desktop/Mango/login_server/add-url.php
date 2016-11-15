<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Mango</title>

</head>

<body>
<?php
if($_POST) {
 	//$link = @mysqli_connect("localhost", "root", "abc456", "pmj")
 	//			or die(mysqli_connect_error()."</body></html>");
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

	$title = $_POST['title'];
	$content = $_POST['content'];
	$url = $_POST['url'];
	$picture = $_POST['picture'];

	$sql = "INSERT INTO sitesearch VALUES('', '$title', '$url', '$content' , '$picture')";
	$r = mysqli_query($link, $sql);
	if($r) {
		echo "<h3>เพิ่ม URL ลงในฐานข้อมูลแล้ว</h3>";
	}
	mysqli_close($link);
}
?>
<form method="post">
  <div id="top">Admin Page :เพิ่มข้อมูลสินค้าในระบบค้นหาสินค้า</div>
	<input type="text" name="title" placeholder="ชื่อสินค้า" required>
	 <br><br><br>
    <textarea name="content" placeholder="รายอะเอียดสินค้า"></textarea>
		<br><br><br>
    <textarea name="url" placeholder="url ของเพจ...ต้องขึ้นต้นด้วย http:// หรือ https://"></textarea>
		<br><br><br>
		<textarea name="picture" placeholder="url รูปจาก google drive เปลี่ยนจาก open?id เป็น uc?id"></textarea>
		<br><br><br>
  <div id="bottom">

	<button id="back" type="button" onclick="location='index2.php'">ย้อนกลับ</button>
	<button id="submit">ส่งข้อมูล</button><br class="clear">
</div>
</form>
</body>
</html>
