<!DOCTYPE html>
<html>
<head>
  <link rel="shortcut icon" href="mangowhite.png">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <title>Mango</title>
  <style>
  body {
    margin: 0px;
    background: black fixed;
  }
  </style>

<style>
    #owl-demo .item{
      margin: 3px;
    }
    #owl-demo .item img{
      display: block;
      width: 100%;
      height: 290px;
    }
</style>


<!-- Important Owl stylesheet -->
<link rel="stylesheet" href="owl-carousel/owl.carousel.css">

<!-- Default Theme -->
<link rel="stylesheet" href="owl-carousel/owl.theme.css">

<!--  jQuery 1.7+  -->
<script src="jquery-1.9.1.min.js"></script>

<!-- Include js plugin -->
<script src="assets/owl-carousel/owl.carousel.js"></script>
<link href="js/jquery-ui.min.css" rel="stylesheet">
<script src="js/jquery-ui.min.js"> </script>
<script src="js/jquery.form.min.js"> </script>
<script src="js/jquery.blockUI.js"> </script>

<script>
$(function() {

	$('a.more-detail, a.pro-name, a.pro-name-bestseller').click(function() {
		var id = $(this).attr('data-id');
		$.ajax({
			type: 'post',
			url: 'product-load.php',
			data: {'id': id},
			dataType: 'html',
			beforeSend: function() {
				$.blockUI({message:'<h3>กำลังโหลดข้อมูล...</h3>'});
			},
			success: function(result) {
				$.unblockUI();
				$('#dialog').html(result);
				$('#dialog').dialog({
					title: 'รายละเอียดสินค้า',
					modal: true,
					width: 'auto',
					position: { my: "center top", at: "center top+70px", of: window}
				});
				$('.ui-dialog-titlebar-close').focus();
			},
			complete: function() {
				$.unblockUI();
			}
		});
	});

	//ใช้ on() เพราะปุ่มในไดอะล็อกถูกโหลดมาทีหลังเพจ
	$(document).on('click', 'button#dialog-add-cart', function() {
		if(!$.isNumeric($('#dialog-quantity').val())) {
			alert('กรุณาใส่จำนวนสินค้าเป็นตัวเลข');
			return false;
		}
		var err = false;
		$('#dialog select').each(function(index, value) {
			if($(this).children('option:selected').index()==0) {  //ถ้าไม่ได้เลือกคุณลักษณะ
				alert('กรุณาเลือก: ' + $(this).val());
				err = true;
				return false;
			}
		});

		if(err) {
			return;
		}

		$.ajax({
			type: 'post',
			url: 'cart-add.php',
			data: $('#dialog-form').serializeArray(),
			dataType: 'html',
			beforeSend: function() {
				$('#dialog').block({message:'<h3>กำลังหยิบใส่รถเข็น...</h3>'});
			},
			success: function(result) {
				if(result.length > 0) {
					$('#dialog').unblock();
					alert(result);
				}
				else {
				cartCount();
				$('#dialog').block({message:'<h3>เพิ่มสินค้าในรถเข็นแล้ว...</h3>', timeout:2000, showOverlay:false,
				 							css: {padding:'2px 20px', background:'#ffc', color:'green', width: 'auto'}});
				}
			}
		});
	});

	$('button#order').click(function() {  //เมื่อคลิกปุ่มสั่งซื้อที่อยู่ตรงรถเข็น
		location.href = "order-cart.php";
	});

	cartCount(); //ให้อ่านข้อมูลในรถเข็นมาแสดงทันทีที่เปิดเพจ (อาจเปิดไปเพจอื่นแล้วกลับมาที่หน้าหลักอีก)

});

function cartCount() {  //ฟังก์ชั่นสำหรับอ่านข้อมูลในรถเข็น
	$.ajax({
		type: 'post',
		url: 'cart-count.php',
		dataType: 'html',
		success: function(result) {
			$('#cart-count').html(result);
		}
	});
}
</script>


<script>
    $(document).ready(function() {

      $("#owl-demo").owlCarousel({

          autoPlay: 3000, //Set AutoPlay to 3 seconds

          items : 4,
          itemsDesktop : [1199,3],
          itemsDesktopSmall : [979,3]


      });

    });

</script>
</head>
<body>
  <?php include "1t.php"; ?>
  <?php
  session_start();
  ob_start();
  ?>
<br><br><br><br>
  <?php
  include "dblink.php";


  //ตรวจสอบว่าเก็บข้อมูลการเข้าสู่ระบบไว้ในคุกกี้ หรือไม่
  //ถ้ามี ให้กำหนดให้ตัวแปรได้เลย เพื่อให้เทียบเท่ากับการโพสต์ขั้นมาจากฟอร์ม
  if(isset($_COOKIE['email']) && isset($_COOKIE['pswd'])) {
  	$_POST['email'] = $_COOKIE['email'];
  	$_POST['pswd'] = $_COOKIE['pswd'];
  }

  if($_POST) {
  	$email = $_POST['email'];
  	$pswd = $_POST['pswd'];

  	$sql = "SELECT * FROM customers
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

  		 $_SESSION['user'] = $data['firstname'];
  		 $_SESSION['email'] = $data['email'];
  	}
  }
  mysqli_close($link);
  ?>
  <aside>
  	<section id="top">
  <?php
  	 if(!isset($_SESSION['user'])) {
  ?>
      <?php echo $err; ?>



   <?php
   	}
   	else {
  ?>
        <p><font color = "white"><span class="glyphicon glyphicon-user"> <?php echo "สวัสดีคุณ".$_SESSION['user']; ?></span></font></p>
  <?php
  	}
  ?>
  	</section>
  </aside>

  </body>
  </html>

  <?php ob_end_flush(); ?>
  <br><br><br><br><br><br><br><br>
  <div id="owl-demo">

    <div class="item"><a href="http://notefeez.servegame.com:8080/x1.php?braid=1&braname=Apple"><img src="images/applelogo3.jpg" alt="Owl Image"></div></a>
    <div class="item"><a href="http://notefeez.servegame.com:8080/x1.php?braid=100&braname=Asus"><img src="images/asuslogo2.jpg" alt="Owl Image"></div></a>
    <div class="item"><a href="http://notefeez.servegame.com:8080/x1.php?braid=101&braname=Acer"><img src="images/acerlogo.jpg" alt="Owl Image"></div></a>
    <div class="item"><a href="http://notefeez.servegame.com:8080/x1.php?braid=101&braname=MSI"><img src="images/msilogo.png" alt="Owl Image"></div></a>
    <div class="item"><a href="http://notefeez.servegame.com:8080/x1.php?braid=104&braname=Dell"><img src="images/delllogo.jpg" alt="Owl Image"></div></a>
    <div class="item"><a href="http://notefeez.servegame.com:8080/x1.php?braid=105&braname=Hp"><img src="images/hplogo.png" alt="Owl Image"></div></a>
    <div class="item"><a href="http://notefeez.servegame.com:8080/x1.php?braid=106&braname=Toshiba"><img src="images/toshibalogo.jpg" alt="Owl Image"></div></a>
    <div class="item"><a href="http://notefeez.servegame.com:8080/x1.php?braid=107&braname=Samsung"><img src="images/samsunglogo.jpg" alt="Owl Image"></div></a>
    <div class="item"><a href="http://notefeez.servegame.com:8080/x1.php?braid=108&braname=Cisco"><img src="images/ciscologo.jpg" alt="Owl Image"></div></a>
    <div class="item"><a href="http://notefeez.servegame.com:8080/x1.php?braid=110&braname=Dlink"><img src="images/dlinklogo.png" alt="Owl Image"></div></a>
    <div class="item"><a href="http://notefeez.servegame.com:8080/x1.php?braid=111&braname=microsoft"><img src="images/microsoftlogo.jpg" alt="Owl Image"></div></a>
    <div class="item"><a href="http://notefeez.servegame.com:8080/x1.php?braid=112&braname=lenovo"><img src="images/lenovologo.jpg" alt="Owl Image"></div></a>
    <div class="item"><a href="http://notefeez.servegame.com:8080/x1.php?braid=113&braname=razer"><img src="images/razerlogo.jpg" alt="Owl Image"></div></a>
    <div class="item"><a href="http://notefeez.servegame.com:8080/x1.php?braid=114&braname=sony"><img src="images/sonylogo.gif" alt="Owl Image"></div></a>

    <div class="item"><a href="http://notefeez.servegame.com:8080/x1.php?braid=115&braname=lg"><img src="images/lglogo.png" alt="Owl Image"></div></a>
    <div class="item"><a href="http://notefeez.servegame.com:8080/x1.php?braid=116&braname=kingston"><img src="images/kingstonlogo.jpg" alt="Owl Image"></div></a>
    <div class="item"><a href="http://notefeez.servegame.com:8080/x1.php?braid=117&braname=sandisk"><img src="images/sandisklogo.jpeg" alt="Owl Image"></div></a>
    <div class="item"><a href="http://notefeez.servegame.com:8080/x1.php?braid=118&braname=wd"><img src="images/wdlogo.png" alt="Owl Image"></div></a>
    <div class="item"><a href="http://notefeez.servegame.com:8080/x1.php?braid=119&braname=seagate"><img src="images/seagatelogo.png" alt="Owl Image"></div></a>
    <div class="item"><a href="http://notefeez.servegame.com:8080/x1.php?braid=120&braname=canon"><img src="images/canonlogo.jpg" alt="Owl Image"></div></a>
    <div class="item"><a href="http://notefeez.servegame.com:8080/x1.php?braid=121&braname=epson"><img src="images/epsonlogo.jpg" alt="Owl Image"></div></a>
  </div>
<br><br><br><br><br><br><br><br>
<?php include "foot.php" ?>
</body>
</html>
