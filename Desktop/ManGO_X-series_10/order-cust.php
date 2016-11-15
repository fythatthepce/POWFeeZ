<?php
session_start();
if(!$_POST) {
	exit;
}
?>
<!doctype html>
<html>
<head>
<title>ManGo</title>
<link rel="shortcut icon" href="mangog.png">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link href="js/jquery-ui.min.css" rel="stylesheet">

<style>
	@import "global-order.css";

	body {
		margin: 0px;

	}

	form {
		margin: 20px auto;
		width: 95%;
		border: solid 0px;
		font-size: 12px;
		color: black;
	}
	form  > * {
		font: 14px tahoma;
		padding: 3px;
	}
	input {
		width: 200px;
	}
	textarea {
		width: 417px;
		height: 40px;
		resize: none;
		overflow: auto;
	}
	input, select, textarea {
		margin: 3px;
		background: #ffc;
		border: solid 1px gray;
	}
	[name=phone] {
		width: 200px;
	}
	label {
		font-size: 12px;
		color: black;
		display: inline-block;
	}
	select {
		width: 207px;
	}
	h2.warning {
		text-align: left !important;
	}
	span#forget-pswd {
		width: 425px;
		display: block;
		text-align: right;
		margin: -5px 0px 10px 0px;
	}
	span#forget-pswd a {
		font-size: 12px;
	}
</style>
<script src="js/jquery-2.1.1.min.js"> </script>
<script src="js/jquery.blockUI.js"> </script>
<script>
$(function() {
	$('button#cust-info').click(function() {
		$('form').submit();
	});

	$('button#confirm').click(function() {
		if(!confirm('ยืนยันการสั่งซื้อ')) {
			return false;
		}
		$.ajax({
			url: 'order-check-email.php',
			data: $('[name=email],[name=cust_id]').serializeArray(),
			dataType:'html',
			type: 'post',
			beforeSend: function() {
				$.blockUI({message:'<h3>กำลังตรวจสอบอีเมล...</h3>'});
			},
			success: function(result) {
				if(result.length > 0) {
					alert(result);
				}
				else {
					$('form').attr('action', "order-done.php");
					$('button[type=submit]').click();
				}
			},
			complete: function() {
				$.unblockUI();
			}
		});
	});

	$('button#index').click(function() {
		location.href = "index2.php";
	});

	$('button#back').click(function() {
		location.href = "order-cart.php";
	})

});
</script>


</head>
<body>

<?php	include "topbar_ordercart.php"; ?>
<div id="container">

<h1 style="text-align: center;"><img src="images/basket-icon.png" class="logo2" style="width:70px;height:70px"><b><c  style="color:black;"> Your Bucket</c></b></h1>

<br>
	<div class="progress">
			<div class="progress-bar progress-bar-danger progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:80%">
				 80% (ข้อมูลลูกค้า)
			</div>
	</div>


<div id="content">
<form method="post">

<?php
include "dblink.php";
//check login
session_start();
if(!isset($_SESSION['user'])) {
	header("location: login.php");
	exit;
}
//end check login

$data = array();
if($_POST['email']) {
	$email = $_POST['email'];
	$pswd = $_POST['pswd'];

	$sql = "SELECT * FROM customers WHERE email = '$email' AND password = '$pswd'";
	$r = mysqli_query($link, $sql);
	if(mysqli_num_rows($r)==0) {
		echo '<h2 class="warning">ไม่พบข้อมูล  ท่านอาจใส่อีเมลหรือรหัสผ่านผิด</h2>';
	}
	else {
		$data = mysqli_fetch_array($r);
	}
}
?>

<!-- ถ้าเป็นลูกค้าเก่าที่โพสต์อีเมลและรหัสผ่านเข้ามาถูกต้อง ข้อมูลในตัวแปร $data จะถูกนำไปเติมลงในฟอร์ม
 	  แต่หากเป็นลูกค้าใหม่ หรือกรณีใส่อีเมล/รหัสผ่านผิด ตัวแปร $data จะเป็นค่าว่างจึงไม่มีข้อมูลเติมลงในฟอร์ม -->

 <img src="d.png" height="100" width="300" align="middle"><br>

	<span>กรุณาใส่ข้อมูลของท่านให้ครบสมบูรณ์และชัดเจน สำหรับการจัดส่งสินค้า</span><br>
    <input type="hidden" name="cust_id" value="<?php echo $data['cust_id'];?>">
	<input type="email" name="email" placeholder="อีเมล *" required value="<?php echo $data['email'];?>">
    <input type="password" name="pswd" placeholder="รหัสผ่าน *" maxlength="20" required value="<?php echo $data['password'];?>">
    <button type="button" id="cust-info">ใช้ข้อมูลเดิม</button>

    <label><c  style="color:red;">*ถ้าเคยสั่งซื้อสินค้า ให้ใส่อีเมลและรหัสผ่าน </c><br>&nbsp;&nbsp;<c  style="color:red;">แล้วคลิกที่ปุ่มนี้ หากต้องการใช้ข้อมูลเดิม</c></label>
    <br>
		<br>
    <input type="text" name="firstname" placeholder="ชื่อ *" required value="<?php echo $data['firstname'];?>">
    <input type="text" name="lastname" placeholder="นามสกุล *" required value="<?php echo $data['lastname'];?>"><br>
    <br>
	  <textarea name="address" placeholder="ที่อยู่ *" required><?php echo $data['address'];?></textarea><br>

		<br>
		<input type="text" name="zone" placeholder="จังหวัด *" required value="<?php echo $data['zone'];?>">
    <br><br>

		<input type="text" name="phone" placeholder="เบอร์โทรศัพท์ *" required value="<?php echo $data['phone'];?>">
    <br>
		<br>



		 <select name="payment">
    	<option>โอนผ่านธนาคาร</option>
     </select>
     <button type="submit" style="display:none;"></button>
</form>
</div>

<br>
<button id="back"  class="btn btn-warning">&laquo; ย้อนกลับ</button>
<button id="confirm"  class="btn btn-danger">ยืนยันการสั่งซื้อ &raquo;</button>

</div>
<?php include "cartscript.php"; ?>
</body>
</html>
<?php mysqli_close($link); ?>
