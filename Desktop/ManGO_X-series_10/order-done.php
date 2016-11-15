<?php
session_start();
if(!$_POST) {
	exit;
}
?>
<!doctype html>
<html>
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link href="js/jquery-ui.min.css" rel="stylesheet">
	<script src="js/jquery-2.1.1.min.js"> </script>
	<script src="js/jquery-ui.min.js"> </script>
	<script src="js/jquery.form.min.js"> </script>
	<script src="js/jquery.blockUI.js"> </script>
	<title>ManGo</title>
	<link rel="shortcut icon" href="mangog.png">
<style>
	@import "global-order.css";

	body {
		margin: 0px;

	}

	div#panel {
		font-size: 16px;
		margin: 30px auto 30px 100px;
		color: navy;
		text-align: left;
	}
	div#panel > img {
		width: 64px;
		margin-right: 20px;
		float: left;
		vertical-align: top;
	}
	div#panel > div#text-done {
		float: left;
		width: 550px;
	}
	div#panel > div#text-done > span {
		font-size: 18px;
		color: green;
	}
	div#panel > div#text-done > div#order-detail {
		font-size: 14px !important;
	}
</style>
<script src="js/jquery-2.1.1.min.js"> </script>
<script>
$(function() {
	$('button#index').click(function() {
		location.href = "index2.php";
	});
});
</script>
</head>
<body>
	<?php
	 include "topbar_ordercart.php";
	 include "dblink.php";
	?>
	<br>
	<br>
	<br>
<div id="container">
<h1 style="text-align: center;"><img src="images/basket-icon.png" class="logo2" style="width:70px;height:70px"><b><c  style="color:black;"> Your Bucket</c></b></h1>

<br>
	<div class="progress">
			<div class="progress-bar progress-bar-danger progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:100%">
				 100% Complete (success)
			</div>
	</div>


<div id="content">
<?php
include "dblink.php";
$cust_id = $_POST['cust_id'];
$email = $_POST['email'];
$pswd = $_POST['pswd'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$zone = $_POST['zone'];

$sql = "REPLACE INTO customers VALUES(
			'$cust_id', '$email', '$pswd', '$firstname', '$lastname', '$address', '$phone')";
mysqli_query($link, $sql);
//ถ้าเป็นลูกค้าใหม่ให้อ่านค่า id ของข้อมูลที่พึ่งเพิ่มลงในตาราง customers
//ทั้งนี้หากเป็นลูกค้าเก่า จะมีค่า id เดิมโพสต์มากับฟอร์มแล้ว
if(empty($cust_id)) {
	$cust_id = mysqli_insert_id($link);
}
//สร้างรายการสั่งซื้อของลูกค้าคนนี้
$sql = "INSERT INTO orders VALUES('$firstname','$lastname','$address','$zone','','$cust_id', NOW(), 'no', 'no')";
$r = mysqli_query($link, $sql);
$order_id = mysqli_insert_id($link);

$sid = session_id();
$sql = "SELECT * FROM cart WHERE session_id = '$sid'";
$r = mysqli_query($link, $sql);

//นำข้อมูลจากตาราง cart มาเพิ่มลงในตาราง  order_details ทีละแถวจนครบ
while($cart = mysqli_fetch_array($r)) {
	$pro_id = $cart['pro_id'];
	$quan = $cart['quantity'];
	$attr = $cart['attribute'];
	$sql = "INSERT INTO order_details VALUES(
	 			'', '$order_id', '$pro_id', '$attr', '$quan')";
	mysqli_query($link, $sql);

}
//หลังจากคัดลอกข้อมูลของลูกค้ารายนั้นจากตาราง cart ไปจัดเก็บแล้ว ก็ลบข้อมูลในตาราง cart ทิ้ง
$sql = "DELETE FROM cart WHERE session_id = '$sid'";
mysqli_query($link, $sql);

$sql = "SELECT * FROM orders WHERE  order_id = '$order_id'";
$mo = mysqli_query($link, $sql);
//$datax = mysqli_fetch_array($mo);
while($datax = mysqli_fetch_array($mo))
{
  if(mysqli_num_rows($mo) != 0)
	{

    //send email
		$to = "<$email>";
		$subject = "Mango store service";
		$txt = "รหัสการสั่งซื้อของท่าน : $datax[4] ขอบคุณที่ใช้บริการทางเราจะรีบส่งสินค้าทันทีเมื่อท่านแจ้งการชำระเงินเรียบร้อยแล้ว โดยท่านสามารถแจ้งชำระเงินได้ที่ http://mango.servehttp.com:8080/order-paid.php";
		$headers = "From:noreply@mango.com" . "\r\n" .
 	"CC:noreply@mango.com";

	$flgSend = mail($to,$subject,$txt,$headers);
	if($flgSend)
	{
		echo " ";
	}
	else
	{
		echo "Mail cannot send.";
	}

	echo "<h5><c style=\"font-size:170%;\">จัดเก็บข้อมูลการสั่งซื้อของท่านเรียบร้อยแล้ว</c></h5><br>";
	echo "<h5>เราได้จัดส่งรหัสการสั่งซื้อไปทางอีเมลที่ท่านใช้สมัครแล้ว</h5><br>";
	echo '<h5>เมื่อท่านโอนเงินแล้วกรุณานำรหัสดังกล่าวมากรอกหน้าชำระสินค้า</h5></a><br><br>';

	echo "<br><br><h5><h77><a class=\"btn btn-danger\" href=\"index2.php\" role = \"button\">กลับหน้าหลัก</h5></a></h77>";
	//echo '<a href="index2.php">กลับหน้าหลัก</a>';
	mysqli_close($link);
	exit('</body></html>');
 }
}


mysqli_close($link);
$amount = $_SESSION['amount'];
?>
	<div id="panel">
		<img src="images/check.png">
    	<div id="text-done">
    		<span>การสั่งซื้อเสร็จเรียบร้อย</span><br><br>
            <div id="order-detail">
 				รายละเอียดการชำระค่าสินค้า มีดังนี้<br><br>
				<b>รหัสการสั่งซื้อ:</b> <?php echo $order_id; ?> <br>
				<b>รวมเป็นเงินทั้งสิ้น:</b> <?php echo $amount; ?>  บาท <br>
				<b>การโอนเงิน:</b><br>
				- ธนาคาร กรุงไทย สาขา kmitl ชื่อบัญชี mangostore หมายเลข 797-2-30953-7 <br><br>

 				หลังการโอนเงิน ให้เข้ามาที่หน้าแรกของเว็บไซต์แล้วคลิกที่ปุ่ม "แจ้งการโอนเงิน"<br>
 				กรุณาชำระเงินภายใน 7 วัน มิฉะนั้นข้อมูลการสั่งซื้อของท่านอาจจะถูกยกเลิก<br><br>

				ท่านสามารถตรวจสอบข้อมูลต่างๆเกี่ยวกับการสั่งซื้อสินค้าของท่าน เช่น
				รหัสการสั่งซื้อ, สถานะการโอนเงิน, การจัดส่ง โดยเข้ามาที่หน้าแรกของเว็บไซต์แล้วคลิกที่ปุ่ม "ประวัติการสั่งซื้อ"<br><br>

				ขอขอบพระคุณที่สั่งซื้อสินค้าจากเรา
        "mango store customer service"
    		</div>
    </div>
    <br class="clear">
</div>
</div>
<div id="bottom">
<button id="index">&laquo; หน้าแรก</button>
</div>
</div>


</body>
</html>
