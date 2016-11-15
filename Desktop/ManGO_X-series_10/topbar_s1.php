<?php
session_start();
ob_start();
?>

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
       //echo "ท่านใส่อีเมล หรือรหัสผ่านไม่ถูกต้อง";


       echo '<script language="javascript">';
       echo 'alert("ท่านใส่อีเมล หรือ รหัสผ่านไม่ถูกต้อง")';
       echo '</script>';

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
    <?php $status; ?>
<?php
   if(!isset($_SESSION['user'])) {
?>
    <?php
        echo $err;
        $status = "0";

    ?>



 <?php

  }
  else {
  $status = "1";
?>

<?php
  }
?>



<div class="hidden-xs hidden-sm">
<nav class="navbar navbar-inverse navbar-fixed-top">
<div class="container-fluid">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
      </button>
     <a class="navbar-brand" href="index2.php" onmouseenter='style="background-color:black"' onmouseleave='style="background-color:#222222"'><img src="mangowhite.png" alt="mango.com" style="float:left;width:20px;height:20px;">&nbsp;&nbsp; ManGO</a>
  </div>

  <div id="navbar" class="navbar-collapse collapse">
    <ul class="nav navbar-nav">
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Categories<span class="caret" ></span></a>
        <ul class="dropdown-menu">
                          <li><a href="http://notefeez.servegame.com:8080/x1.php?catid=">All</a></li>
                          <li><a href="http://notefeez.servegame.com:8080/x1.php?catid=1&catname=ComputerComponents">Computer Components</a></li>
                          <li><a href="http://notefeez.servegame.com:8080/x1.php?catid=2&catname=DesktopComputers">Desktop Computers</a></li>
                          <li><a href="http://notefeez.servegame.com:8080/x1.php?catid=3&catname=GamingGear">Gaming Gear</a></li>
                          <li><a href="http://notefeez.servegame.com:8080/x1.php?catid=4&catname=Keyboards">Keyboards</a></li>
                          <li><a href="http://notefeez.servegame.com:8080/x1.php?catid=5&catname=LaptopsMobiles">Laptops & mobiles</a></li>
                          <li><a href="http://notefeez.servegame.com:8080/x1.php?catid=6&catname=Monitors">Monitors</a></li>
                          <li><a href="http://notefeez.servegame.com:8080/x1.php?catid=7&catname=Mouse">Mouse</a></li>
                          <li><a href="http://notefeez.servegame.com:8080/x1.php?catid=8&catname=NetworkComponents">Network Components</a></li>
                          <li><a href="http://notefeez.servegame.com:8080/x1.php?catid=9&catname=PrintersAccessories">Printers Accessories</a></li>
                          <li><a href="http://notefeez.servegame.com:8080/x1.php?catid=10&catname=Software">Software</a></li>
                          <li><a href="http://notefeez.servegame.com:8080/x1.php?catid=11&catname=Speakers">Speakers</a></li>
                          <li><a href="http://notefeez.servegame.com:8080/x1.php?catid=12&catname=Storage">Storage</a></li>



        </ul>
        </li>
   </ul>


   <!--- brands ------>

   <div id="navbar" class="navbar-collapse collapse">
     <ul class="nav navbar-nav">
       <li class="dropdown">
         <a class="dropdown-toggle" data-toggle="dropdown" href="#">Brands<span class="caret" ></span></a>
         <ul class="dropdown-menu">
                          <li><a href="http://notefeez.servegame.com:8080/x1.php?braid=101&braname=Acer">Acer</a></li>
                           <li><a href="http://notefeez.servegame.com:8080/x1.php?braid=1&braname=Apple">Apple</a></li>
                           <li><a href="http://notefeez.servegame.com:8080/x1.php?braid=100&braname=Asus">Asus</a></li>

                            <li><a href="http://notefeez.servegame.com:8080/x1.php?braid=120&braname=canon">Canon</a></li>
                            <li><a href="http://notefeez.servegame.com:8080/x1.php?braid=108&braname=Cisco">Cisco</a></li>
                            <li><a href="http://notefeez.servegame.com:8080/x1.php?braid=104&braname=Dell">Dell</a></li>
                            <li><a href="http://notefeez.servegame.com:8080/x1.php?braid=110&braname=Dlink">D-link</a></li>

                            <li><a href="http://notefeez.servegame.com:8080/x1.php?braid=121&braname=epson">Epson</a></li>

                            <li><a href="http://notefeez.servegame.com:8080/x1.php?braid=105&braname=Hp">hp</a></li>

                            <li><a href="http://notefeez.servegame.com:8080/x1.php?braid=116&braname=kingston">Kingston</a></li>

                            <li><a href="http://notefeez.servegame.com:8080/x1.php?braid=112&braname=lenovo">Lenovo</a><li>

                            <li><a href="http://notefeez.servegame.com:8080/x1.php?braid=115&braname=lg">LG</a><li>

                            <li><a href="http://notefeez.servegame.com:8080/x1.php?braid=125&braname=logitech">Logitech</a><li>

                           <li><a href="http://notefeez.servegame.com:8080/x1.php?braid=102&braname=MSI">Msi</a></li>
                           <li><a href="http://notefeez.servegame.com:8080/x1.php?braid=111&braname=microsoft">Microsoft</a><li>
                          <li><a href="http://notefeez.servegame.com:8080/x1.php?braid=113&braname=razer">Razer</a><li>

                          <li><a href="http://notefeez.servegame.com:8080/x1.php?braid=117&braname=sandisk">Sandisk</a></li>

                          <li><a href="http://notefeez.servegame.com:8080/x1.php?braid=107&braname=Samsung">Samsung</a></li>

                          <li><a href="http://notefeez.servegame.com:8080/x1.php?braid=119&braname=seagate">Seagate</a></li>

                          <li><a href="http://notefeez.servegame.com:8080/x1.php?braid=118&braname=wd">Western digital</a></li>




                           <li><a href="http://notefeez.servegame.com:8080/x1.php?braid=106&braname=Toshiba">Toshiba</a></li>
                          <li><a href="http://notefeez.servegame.com:8080/x1.php?braid=109&braname=Tplink">Tp-link</a></li>




          </ul>
         </li>

       <li>
               <form method="get" class="navbar-form navbar-left" form action="searchpro.php">

                   <input type="text" class="form-control" placeholder="Search" style="width:350px" name="q" maxlength="30" value="<?php echo stripslashes($_GET['q']); ?>" required>



               </form>
       </li>

    </ul>



       <ul class="nav navbar-nav navbar-right">
         <li><a href="how-to-order.php" class="glyphicon glyphicon-usd">Payments</a></li>

         <li><a href="order-history.php" class="glyphicon glyphicon-time">Orders</a></li>

         <li><a href="order-history.php">
          <?php
            $x = "3";
            $y = "3";
            if($status == "1"){

              echo "<p class=\"text-right\">"."<font color=\"black\" size=\"$x\">"."<span class=\"glyphicon glyphicon-user\"></span>"." "."สวัสดีคุณ"." ".$_SESSION['user']."</font>"."<br>"."<a href=\"logout.php\">"."<font color=\"red\" size=\"$y\"> Log out</font>"."</a>"."</p>";
            }      
            else {

              echo "<a href=\"#\" data-toggle=\"modal\" data-target=\"#login-modal\">"."<span class=\"glyphicon glyphicon-log-in\"></span>"." "."Log in"."</a>";

          //echo "<a href=\"login.php\">"."<p class=\"text-right\">"."<font color=\"black\" size=\"$x\">"."<span class=\"glyphicon glyphicon-log-in\"></span>"." "."Log in"."</font>"."</p>"."</a>";

            }
          ?>
      
        </a></li>

         <li><td>
           <a href="order-cart.php" class="glyphicon glyphicon-shopping-cart">Bucket (<span id="cart-count">0</span>)</a>
         </td></li>

       </ul>

     </div>
   </div>
 </nav>
</div>
      <!-- end bar top-->
<br><br><br>
<ul id="log">
  <br>
  <li id="log">
    <?php
       $x = "3";
       $y = "3";
       if($status == "1")
       {

         echo "<p class=\"text-right\">"."<font color=\"black\" size=\"$x\">"."<span class=\"glyphicon glyphicon-user\"></span>"." "."สวัสดีคุณ"." ".$_SESSION['user']."</font>"."<br>"."<a href=\"logout.php\">"."<font color=\"red\" size=\"$y\"> Log out</font>"."</a>"."</p>";


       }else {

          echo "<a href=\"#\" data-toggle=\"modal\" data-target=\"#login-modal\">"."<span class=\"glyphicon glyphicon-log-in\"></span>"." "."Log in"."</a>";

          //echo "<a href=\"login.php\">"."<p class=\"text-right\">"."<font color=\"black\" size=\"$x\">"."<span class=\"glyphicon glyphicon-log-in\"></span>"." "."Log in"."</font>"."</p>"."</a>";

       }
    ?>
  </li>

</ul>
