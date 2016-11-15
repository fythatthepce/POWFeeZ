<?php
if($_GET['q']) {
	include "pagination.php";

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



	$q =  trim($_GET['q']);
	$pat = "/[ ]{1,}/";
	$w = preg_split($pat, $q);

	//(title LIKE '%a%') OR (title LIKE '%b%) OR (title LIKE '%c%')
	$title = array();
	foreach($w as $k) {
		$x = "(title LIKE '%$k%')";  //เติมคำแทรกระหว่าง %...%
		array_push($title, $x);
	}
	$title = implode(" OR ", $title);

	//(content LIKE '%a%') OR (content LIKE '%b%) OR (content LIKE '%c%')
	$content = array();
	foreach($w as $k) {
		$x = "(content LIKE '%$k%')";  //เติมคำแทรกระหว่าง %...%
		array_push($content, $x);
	}
	$content = implode(" OR ", $content);

	//(picture LIKE '%a%') OR (content LIKE '%b%) OR (content LIKE '%c%')
	$picture = array();
	foreach($w as $k) {
		$x = "(content LIKE '%$k%')";  //เติมคำแทรกระหว่าง %...%
		array_push($picture, $x);
	}

	$picture = implode(" OR ", $picture);

	$condition = "$title OR $content OR $picture";  //(title LIKE '%a%') ... OR (content LIKE '%b%) ...

	$sql = "SELECT * FROM sitesearch WHERE $condition";		//echo $sql;
	$rs = page_query($link, $sql, 5);




	echo "ค้นหา:  " . stripslashes($_GET['q']);

	$first = page_start_row();
	$last = page_stop_row();
	$total = page_total_rows();
	if($total == 0) {
		$first = 0;
	}



 	echo "<span id=\"result\">  ผลลัพธ์ที่: $first - $last จากทั้งหมด $total </span><br><br>";



   //$pic = 123;
	//ต่อไปเป็นขั้นตอนการทำให้คีย์เวิร์ดเป็นตัวหนา ใช้หลักการตามที่เราเคยทำในบทที่ 7
	//ขั้นแรกนำคีย์เวิร์ดแต่ละคำมาเชื่อมโยงด้วย "|" เพื่อให้แต่ละคำคือ 1 แพตเทิร์น (a|b|c)
	$p = implode("|", $w);
	$p = "/$p/i";
	while($data = mysqli_fetch_array($rs)) {
		//เปลี่ยนคีย์เวิร์ดแต่ละคำใน title และ content ให้เป็นตัวหนา
		$title = htmlspecialchars($data['title']);
		$cont = htmlspecialchars($data['content']);
		$title = preg_replace($p, "<b>\\0</b>", $title);
		$cont = preg_replace($p, "<b>\\0</b>", $cont);
    $pic  = $data['picture'];


		//แสดงผลการสืบค้น
		echo "<br><br><a href=\"{$data['url']}\" target=\"_blank\">$title</a>";
		echo "<br><span class=\"desc\">$cont</span>";
		//echo "<span class=\"url\">{$data['url']}</span>";
	  //echo "<br><span class=\"desc\">$pic</span>";
		echo "<br><span class=\"desc\"></span>";
		echo '<br><img src="'.$pic.'" alt="HTML5 Icon" style="width:128px;height:128px">';


  }

	//ต่อไปให้แสดงหมายเลขเพจเฉพาะเมื่อมีมากกว่า 1 เพจ
	if(page_total() > 1) {
		echo '<p id="pagenum">';
		page_echo_pagenums();
		echo '</p>';
	  }
	mysqli_close($link);
}
//else {
	//echo '<h3>ค้นหาข้อมูลสินค้า</h3>';
//}

?>
