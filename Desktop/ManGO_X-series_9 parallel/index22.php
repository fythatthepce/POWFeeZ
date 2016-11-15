<!DOCTYPE html>
<html>
<head>
  <link rel="shortcut icon" href="mangog.png">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <title>ManGo</title>
  <style>
    @import "global-order.css";

    body {
      margin: 0px;
      background: black fixed;
    }
    #owl-demo .item{
      margin: 3px;
    }
    #owl-demo .item img{
      display: block;
      width: 100%;
      height: 290px;
    }
</style>

<style>
        @import url(http://fonts.googleapis.com/css?family=Roboto);

        /****** LOGIN MODAL ******/
        .loginmodal-container {
        padding: 30px;
        max-width: 350px;
        width: 100% !important;
        background-color: #F7F7F7;
        margin: 0 auto;
        border-radius: 2px;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        font-family: roboto;
        }

        .loginmodal-container h1 {
        text-align: center;
        font-size: 1.8em;
        font-family: roboto;
        }

        .loginmodal-container input[type=submit] {
        width: 100%;
        display: block;
        margin-bottom: 10px;
        position: relative;
        }

        .loginmodal-container input[type=text], input[type=password] {
        height: 44px;
        font-size: 16px;
        width: 100%;
        margin-bottom: 10px;
        -webkit-appearance: none;
        background: #fff;
        border: 1px solid #d9d9d9;
        border-top: 1px solid #c0c0c0;
        /* border-radius: 2px; */
        padding: 0 8px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        }

        .loginmodal-container input[type=text]:hover, input[type=password]:hover {
        border: 1px solid #b9b9b9;
        border-top: 1px solid #a0a0a0;
        -moz-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
        -webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
        box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
        }

        .loginmodal {
        text-align: center;
        font-size: 14px;
        font-family: 'Arial', sans-serif;
        font-weight: 700;
        height: 36px;
        padding: 0 8px;
        /* border-radius: 3px; */
        /* -webkit-user-select: none;
        user-select: none; */
        }

        .loginmodal-submit {
        /* border: 1px solid #3079ed; */
        border: 0px;
        color: #fff;
        text-shadow: 0 1px rgba(0,0,0,0.1);
        background-color: red;
        padding: 17px 0px;
        font-family: roboto;
        font-size: 14px;
        /* background-image: -webkit-gradient(linear, 0 0, 0 100%,   from(#4d90fe), to(#4787ed)); */
        }

        .loginmodal-submit:hover {
        /* border: 1px solid #2f5bb7; */
        border: 0px;
        text-shadow: 0 1px rgba(0,0,0,0.3);
        background-color: #357ae8;
        /* background-image: -webkit-gradient(linear, 0 0, 0 100%,   from(#4d90fe), to(#357ae8)); */
        }

        .loginmodal-container a {
        text-decoration: none;
        color: #666;
        font-weight: 400;
        text-align: center;
        display: inline-block;
        opacity: 0.6;
        transition: opacity ease 0.5s;
        }

        .login-help{
        font-size: 12px;
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
				$('#dialog').block({message:'<font size="2">กำลังหยิบใส่รถเข็น...</font>'});
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
  <?php include "topbar2.php"; ?>

  <?php
  session_start();
  ob_start();
  ?>
<br><br><br><br>
  <?php
  include "dblink.php";
  ?>
  <?php ob_end_flush(); ?>

  <div id="owl-demo">

    <div class="item"><a href="http://notefeez.servegame.com:8080/x1.php?braid=1&braname=Apple"><img src="images/applelogo3.jpg" alt="Owl Image"></div></a>
    <div class="item"><a href="http://notefeez.servegame.com:8080/x1.php?braid=100&braname=Asus"><img src="images/asuslogo2.jpg" alt="Owl Image"></div></a>
    <div class="item"><a href="http://notefeez.servegame.com:8080/x1.php?braid=101&braname=Acer"><img src="images/acerlogo.jpg" alt="Owl Image"></div></a>
    <div class="item"><a href="http://notefeez.servegame.com:8080/x1.php?braid=102&braname=MSI"><img src="images/msilogo.png" alt="Owl Image"></div></a>
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
    <div class="item"><a href="http://notefeez.servegame.com:8080/x1.php?braid=125&braname=logitech"><img src="images/logilogo.jpg" alt="Owl Image"></div></a>

  </div>




  <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    	  <div class="modal-dialog">
				<div class="loginmodal-container">
					<img src="mangog.png" alt="mango.com" style="float:left;width:100px;height:100px;"><h1><p style="float:left;">ManGO</p></h1>
          <br>


				  <form method="post">
    					<input type="text" name="email" placeholder="Username">
    					<input type="password" name="pswd" placeholder="Password">
              <input type="checkbox" name="save_account">
              <span>เก็บข้อมูลไว้ในเครื่องนี้</span><br><br>
    					<input type="submit" name="login" class="login loginmodal-submit" value="Login">
				  </form>

				  <div class="login-help">
					<h5><a href="new-member.php">Register</a> - <a href="forget-password.php">Forgot Password</a></h5>
				  </div>
				</div>
			</div>
		  </div>
<br><br><br><br><br><br><br><br><br><br>
<?php include "foot.php" ?>
</body>
</html>
