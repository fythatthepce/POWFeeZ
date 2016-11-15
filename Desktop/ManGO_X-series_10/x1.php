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
  </style>

  <style>
        @import "loginwindowcss.css";
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

<style>
	body {
		margin: 0px;
		background: white fixed;
	}
	body > * {
		font-family: tahoma;
	}
	#fixed-container {
		position: fixed;
		width: 100%;
		height: 80px;
		z-index: 1000;
	}
	table {
		margin: auto;
		border-collapse: collapse;
		min-width: 1000px;
	}
	#table-top {
		margin: auto;
		background: #CCD462;
	}
	#table-top td {
		border-bottom: solid 1px gray;
	}
	#table-bottom {
		position: relative;
		top: -100px;

	}
	#table-bottom td {
		padding-top: 2px;
	}
	td {
		vertical-align: top;
	}
	#table-top tr {
		border-left: solid 1px powderblue;
		border-right: solid 1px powderblue;
	}
	#td-logo, #td-aside-left, #td-cart, #td-aside-right {
		width: 150px;
	}
	#td-logo {
		background: url('') center center no-repeat;
		border-left: solid 1px gray;
	}
	#td-toolbar, #td-content {
		width: 650px;
	}
	#td-cart {
		text-align: center;
		vertical-align: top;
		font-size: 16px;
		color: brown;
		padding-top: 5px;
		border-bottom: solid 1px gray;
		border-right: solid 1px gray;
	}
	#td-aside-left {
		background: #555;
		border-left: solid 1px gray;
	}



	#td-aside-right {
		background: lavender;
		border-right: solid 1px gray;
	}
	#td-footer {
		border-top: solid 1px gray;
		padding: 5px;
		text-align: center;
		color: navy;
		font-size: 12px;
	}
	a {
		color: blue;
		text-decoration: none;
	}
	a:hover {
		color: red;
	}


	#td-toolbar a {
		display: inline-block;
		text-align: center;
		padding: 5px 10px 2px 5px;
		text-decoration: none;
		border: solid 1px inherit;
	}
	#td-toolbar a:hover {
		background: #B09E9E;
	}
	#td-toolbar a img {
		height: 32px;
		width: 32px;
		border: none;
	}
	#img-cart {
		float: left;
		height: 48px;
		vertical-align: top;
		margin: 5px 0px 0px 5px;
	}
	button#order {
		margin-top: 3px;
		padding: 3px 10px;
		background: salmon;
		font-size: 16px;
		border-radius: 5px;
		border: solid 1px gold;
		color: cyan;
		width: auto;
		cursor: pointer;
	}
	button#order:hover {
		background: #ffc;
		color: red;
	}
	form {
		float: right;
		padding-right: 10px;
		margin-bottom: 5px;
	}
	br.clear {
		clear: both;
	}

  div#pagenum {
		width: 100%;
		text-align: center;
		margin-top: 60px;
    margin-bottom: 20px;
    color: white;
  }

	div#dialog {
		display: none;
	}
	.ui-dialog {
		z-index: 5000 !important;
	}
	.ui-widget-overlay {
		z-index: 4000 !important;
	}
	#dialog-content {
		width: 800px;

		text-align: left;
		font-size: 14px;
	}
	#dialog-content img {
		max-width: 200px;
		max-height: 200px;
		margin: 10px 10px;
		border: solid 1px white;
	}
	#dialog-content img:hover {
		border: solid 1px blue;
	}
	#dialog span {
		display: block;
		margin-bottom: 15px;
	}
	#dialog-pro-name {
		font-size: 16px;
		font-weight: bold;
		color: green;
		display: block;
		margin-top: 10px;
	}
	#dialog-pro-detail {

	}
	#dialog-cat, #dialog-add-cart {
		float: right;
		margin-right: 1px;
	}
	#dialog-quantity {
		width: 50px;
	}
	#dialog-add-cart {

	}
	#dialog-form {
		border: solid 1px gray;
		background: #FE9F9F;
		margin-bottom: 5px;
		display: block;
		width: 100%;
		padding: 5px;
	}
	span#cat-name {
		display: block;
		padding: 10px 3px 5px 10px;
		color: yellow;
		font-size: 18px;
		font-weight: bold;
		width: auto;
		border-bottom: dotted 1px silver;
	}
	span#cat-name > img {
		width: 20px;
		vertical-align: middle;
		margin-right: 3px;
	}


  span#bra-name {
		display: block;
		padding: 10px 3px 5px 10px;
		color: yellow;
		font-size: 18px;
		font-weight: bold;
		width: auto;
		border-bottom: dotted 1px silver;
	}
	span#bra-name > img {
		width: 20px;
		vertical-align: middle;
		margin-right: 3px;
	}

	a.category {
		display: block;
		border-bottom: dotted 1px silver;
		color: white;
	}
	a.category:hover {
		background: #ECD2DD;
    color: red;
	}
	a.category > li {
		padding: 5px 2px 5px 15px;
	}
	a.category li {
		list-style-position: inside;
	}

  a.brand {
		display: block;
		border-bottom: dotted 1px silver;
		color: white;
	}
	a.brand:hover {
		background: #ECD2DD;
		color: red;
	}
	a.brand > li {
		padding: 5px 2px 5px 15px;
	}
	a.brand li {
		list-style-position: inside;
	}
	span#pop {
		display: block;
		padding: 10px 3px 5px 10px;
		color: green;
		font-size: 16px;
		font-weight: bold;
		width: auto;
	}
	span#pop > img {
		width: 18px;
		vertical-align: middle;
		margin-right: 1px;
	}

	#out-of-stock {
		color:red;
		text-align:center;
		display: block;
	}







	#td-content {
		width: 1300px;
		text-align: center;
		background: black;
		border-style: solid;
		border-width: 2px;
	}


	.section-pro {
		float: left;
		width: 350px;
		height: 330px;
		margin: 15px 35px;
		border-style: solid;
		border-width:2px;
		border-color: red;
		background: white;
	}

  .section-brands{
 	 width: 250px;
 	 height: 85px;
 	 border-style: solid;
 	 border-width: 8px;
 	 border-color: #7B0964;
 	 background: #FAC365;
	}

	.div-img img {
		max-width: 100%;
		max-height: 100%;
	}

	.div-img {
		float: left;
		width: 140px;
	}
	.div-summary {
		float: right;
		width: 200px;
		text-align: left;
		font-size: 14px;
	}
	a.pro-name, span.pro-name {
		float: center;
		font-size: 12px;
		font-weight: bold;
		text-decoration: none;
		color:green;
	}
	.div-summary span.price {
		display: inline-block;
		margin: 5px 10px 0px 0px;

	}
	.div-summary a.more-detail {
		float: right;
		margin-right: 3px;
		text-decoration: none;
		margin-top: -20px;
    color:white;
	}
	.div-summary a.more-detail:hover {
		color:red;
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
				 							css: {padding:'2px 20px', background:'whitesmoke', color:'black', width: 'auto'}});
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


<script>
$(document).ready(function () {


    //stick in the fixed 100% height behind the navbar but don't wrap it
    $('#slide-nav.navbar-inverse').after($('<div class="inverse" id="navbar-height-col"></div>'));

    $('#slide-nav.navbar-default').after($('<div id="navbar-height-col"></div>'));

    // Enter your ids or classes
    var toggler = '.navbar-toggle';
    var pagewrapper = '#page-content';
    var navigationwrapper = '.navbar-header';
    var menuwidth = '100%'; // the menu inside the slide menu itself
    var slidewidth = '80%';
    var menuneg = '-100%';
    var slideneg = '-80%';


    $("#slide-nav").on("click", toggler, function (e) {

        var selected = $(this).hasClass('slide-active');

        $('#slidemenu').stop().animate({
            left: selected ? menuneg : '0px'
        });

        $('#navbar-height-col').stop().animate({
            left: selected ? slideneg : '0px'
        });

        $(pagewrapper).stop().animate({
            left: selected ? '0px' : slidewidth
        });

        $(navigationwrapper).stop().animate({
            left: selected ? '0px' : slidewidth
        });


        $(this).toggleClass('slide-active', !selected);
        $('#slidemenu').toggleClass('slide-active');


        $('#page-content, .navbar, body, .navbar-header').toggleClass('slide-active');


    });


    var selected = '#slidemenu, #page-content, body, .navbar, .navbar-header';


    $(window).on("resize", function () {

        if ($(window).width() > 767 && $('.navbar-toggle').is(':hidden')) {
            $(selected).removeClass('slide-active');
        }


    });




});
</script>

</head>
<body>
  <?php
     include "topbar.php";
     include "dblink.php";

  ?>






  <table id="table-bottom">
  <tr>

  <?php
  include "dblink.php";
  include "lib/pagination.php";
  $sql = "SELECT * FROM categories LIMIT 20";
  $r = mysqli_query($link, $sql);
  $self = $_SERVER['PHP_SELF'];
  $h = $self . "?catid=";
  //echo "<a href=\"$h\" class=\"category\"><li>ทั้งหมด</li></a>";
  while($cat = mysqli_fetch_array($r)) {
  	$h = $self . "?catid=" . $cat['cat_id'] . "&catname=" . $cat['cat_name'];
  	//echo "<a href=\"$h\" class=\"category\"><li>". $cat['cat_name'] . "</li></a>";
  }
  ?>



  <?php
  $sql = "SELECT * FROM brands LIMIT 20";
  $rb = mysqli_query($link, $sql);
  $self2 = $_SERVER['PHP_SELF'];
  $h2 = $self2 . "?braid=";
  while($bra = mysqli_fetch_array($rb)) {
  	$h2 = $self2 . "?braid=" . $bra['bra_id'] . "&braname=" . $bra['bra_name'];
  	//echo "<a href=\"$h2\" class=\"brand\"><li>". $bra['bra_name'] . "</li></a>";
  }
  ?>
  </td>


  <!--- white table-------->

  <td id="td-content">



    <font size="6" color="white"><br>
    <?php
  	$field = "ทั้งหมด";
  	$sql = "SELECT *  FROM products ";
  	if(isset($_GET['catid']) && !empty($_GET['catid'])) {
  		$cat_id  = $_GET['catid'];
  		$sql .= "WHERE cat_id  = '$cat_id' ";
  		$field = $_GET['catname'];
  	}

  	if(isset($_GET['braid']) && !empty($_GET['braid'])) {
  		$bra_id  = $_GET['braid'];
  		$sql .= "WHERE bra_id  = '$bra_id' ";
  		$field = $_GET['braname'];
  	}

  	$sql .= "ORDER BY pro_id DESC";
  	$result = page_query($link, $sql, 10);
  	$first = page_start_row();
  	$last = page_stop_row();
  	$total = page_total_rows();
  	if($total == 0) {
  		$first = 0;
  	}
    	$Productname = $field;

      if($Productname == "razer")
      {
        echo "<img src=\"images/razerlogo.jpg\" width=\"100\" height=\"100\">";
      }else if($Productname == "Apple")
      {
        echo "<img src=\"images/applelogo3.jpg\" width=\"250\" height=\"150\">";
      }else if($Productname == "Acer")
      {
        echo "<img src=\"images/acerlogo.jpg\" width=\"200\" height=\"200\">";
      }else if($Productname == "Asus")
      {
        echo "<img src=\"images/asuslogo2.jpg\" width=\"250\" height=\"150\">";
      }



      else if($Productname == "MSI")
      {
        echo "<img src=\"images/msilogo.png\" width=\"200\" height=\"150\">";
      }
      else if($Productname == "Dell")
      {
        echo "<img src=\"images/delllogo.jpg\" width=\"250\" height=\"150\">";
      }
      else if($Productname == "Hp")
      {
        echo "<img src=\"images/hplogo.png\" width=\"250\" height=\"150\">";
      }
      else if($Productname == "Toshiba")
      {
        echo "<img src=\"images/toshibalogo.jpg\" width=\"250\" height=\"150\">";
      }
      else if($Productname == "Samsung")
      {
        echo "<img src=\"images/samsunglogo.jpg\" width=\"250\" height=\"150\">";
      }
      else if($Productname == "Cisco")
      {
        echo "<img src=\"images/ciscologo.jpg\" width=\"300\" height=\"200\">";
      }
      else if($Productname == "Tplink")
      {
        echo "<img src=\"images/tplinklogo.jpg\" width=\"200\" height=\"120\">";
      }
      else if($Productname == "Dlink")
      {
        echo "<img src=\"images/dlinklogo.png\" width=\"250\" height=\"150\">";
      }
      else if($Productname == "microsoft")
      {
        echo "<img src=\"images/microsoftlogo.jpg\" width=\"250\" height=\"150\">";
      }
      else if($Productname == "lenovo")
      {
        echo "<img src=\"images/lenovologo.jpg\" width=\"300\" height=\"200\">";
      }
      else if($Productname == "razer")
      {
        echo "<img src=\"images/razerlogo.jpg\" width=\"250\" height=\"150\">";
      }
      else if($Productname == "sony")
      {
        echo "<img src=\"images/sonylogo.gif\" width=\"250\" height=\"150\">";
      }
      else if($Productname == "lg")
      {
        echo "<img src=\"images/lglogo.png\" width=\"250\" height=\"150\">";
      }
      else if($Productname == "kingston")
      {
        echo "<img src=\"images/kingstonlogo.jpg\" width=\"250\" height=\"150\">";
      }
      else if($Productname == "sandisk")
      {
        echo "<img src=\"images/sandisklogo.jpeg\" width=\"250\" height=\"150\">";
      }
      else if($Productname == "wd")
      {
        echo "<img src=\"images/wdlogo.png\" width=\"250\" height=\"150\">";
      }
      else if($Productname == "seagate")
      {
        echo "<img src=\"images/seagatelogo.png\" width=\"250\" height=\"150\">";
      }
      else if($Productname == "canon")
      {
        echo "<img src=\"images/canonlogo.jpg\" width=\"250\" height=\"150\">";
      }
      else if($Productname == "epson")
      {
        echo "<img src=\"images/epsonlogo.jpg\" width=\"250\" height=\"150\">";
      }
      else if($Productname == "logitech")
      {
        echo "<img src=\"images/logilogo.jpg\" width=\"250\" height=\"150\">";
      }





      else if($Productname == "ComputerComponents")
      {
        echo "Computer Components";
      }



     else if($Productname == "DesktopComputers")
     {
        echo "Desktop Computers";
     }

     else if($Productname == "GamingGear")
     {
        echo "Gaming Gear";
     }

     else if($Productname == "Keyboards")
     {
        echo "Keyboards";
     }

     else if($Productname == "Laptops")
     {
        echo "Laptops  & mobiles";
     }

     else if($Productname == "Monitors")
     {
        echo "Monitors";
     }

     else if($Productname == "Mouse")
     {
        echo "Mouse";
     }

     else if($Productname == "NetworkComponents")
     {
        echo "Network Components";
     }

     else if($Productname == "PrintersAccessories")
     {
        echo "Printers Accessories";
     }

     else if($Productname == "Software")
     {
        echo "Software";
     }

     else if($Productname == "Speakers")
     {
        echo "Speakers";
     }

     else if($Productname == "Storage")
     {
        echo "Storage";
     }

      //echo "$Productname";


  		?>
  	</font>


  <br>
  <br>
  <br>
  <br>


  <?php
  include "lib/IMGallery/imgallery-no-jquery.php";

  while($pro = mysqli_fetch_array($result)) {
  	 $id =  $pro['pro_id'];
  	 $src = "read-image.php?pro_id=" . $pro['pro_id'];

  	 //$id =  $data['pro_id'];
  	 //$src = "read-image.php?pro_id=" . $data['pro_id'];
   ?>


  <section class="section-pro">
  	<div class="div-img"><br>
      <?php
      //gallery_thumb_height('400px');
      gallery_thumb_width('135px');
      gallery_echo_img($src);

       ?></div>
      <div class="div-summary">
      <?php

  		echo "<a href=# class=\"pro-name\" data-id=\"$id\"><br>". $pro['pro_name'] . "</a><br>";
      echo mb_substr($pro['detail'], 0, 50, 'utf-8') . "...<br>";

  		$y_rand = rand(5 , $pro['price']);
  		$x_price = $pro['price'] + $y_rand;

  		$discount =  $x_price - $pro['price'];
  		$percount = ($discount*100.00)/$x_price;
  		echo "<del>"."<span class=\"glyphicon glyphicon-usd\"></span> ".$x_price."</del>"." "."-".number_format($percount)."%"."<br>";
  		echo "<p style='color:red;'>"."<span class=\"price\">ราคา: " . number_format($pro['price'])."</span>"."</p>";

      $randstart = rand(1, 5);
      for ($x = 1; $x <= $randstart; $x++) {
          echo "<font color=\"#FEB201\">"."<span class=\"glyphicon glyphicon-star\"></span>"."</font>";
      }
      echo "<br>";
  		echo "<span class=\"glyphicon glyphicon-user\"></span> ".rand(500, 2000)." views<br>";
  	?>

     <br>
     <br>
  	 <?php
       echo "<button type=\"button\" class =\"btn btn-primary\">"."<a href=# class=\"more-detail\" data-id=\"$id\"><br>รายละเอียด</a>"."</button>";
  	 ?>
      </div>
   </section>


  <?php
  }
  ?>
  <br class="clear">
  <?php
  	if(page_total() > 0.1) { 	 //ให้แสดงหมายเลขเพจเฉพาะเมื่อมีมากกว่า 1 เพจ
  		echo '<div id="pagenum">';

      page_link_border("solid", "2px", "white");
      page_link_bg_color("white", "pink");
      page_link_color("red");
      page_cur_border("solid", "2px", "white");
      page_cur_bg_color("red");
      page_cur_color("white");
      page_link_font("15px");


      page_echo_pagenums(6, true);

  		echo '</div>';
  	}
  ?>

  </td>
  </tr>
  <tr>
    <br><br><br>
    <?php include "foot.php" ?>
</table>
   <div id="dialog"></div>

   <?php
       include "loginwindow.php"
    ?>
</body>
</html>
