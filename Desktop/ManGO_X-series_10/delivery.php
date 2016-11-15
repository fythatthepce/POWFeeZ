<?php
session_start();
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>ManGo</title>
    <link rel="shortcut icon" href="mangog.png">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/mango.css">
    <script src="js/mango.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>

<style>@import "global-order2.css";</style>

  <style>
      .jumbotron {
    margin-bottom: 0px;
    background-image: url(imgBackground/14155_1_other_wallpapers_dual_monitor_dual_screen.jpg);
    background-position: 0% 25%;
    background-size: cover;
    background-repeat: no-repeat;
    color: white;
    text-shadow: black 0.3em 0.3em 0.3em;
}
    </style>

  <body>
    <?php include "top.php"; ?>
    <?php
      include "dblink.php";

       if($_POST)
       {
         $email = $_POST['emaild'];
         $coded = $_POST['coded'];

         $sql = "SELECT COUNT(*) FROM customers WHERE email = '$email'";
         $rs = mysqli_query($link, $sql);
         $data = mysqli_fetch_array($rs);

         if(mysqli_num_rows($rs) == 0) {

           echo '<script language="javascript">';
           echo 'alert("ไม่พบอีเมลลูกค้า")';
           echo '</script>';

         }
         else{


         $to = "<$email>";
         $subject = "Mango store service";
         $txt = "Delivery codes : $coded ท่านสามารถเช็คสถานะการส่งสินค้าได้ที่ http://eggplant.ddns.net/thecarrier/track.html";
         $headers = "From:noreply@mango.com" . "\r\n" .
          "CC:noreply@mango.com";

          $flgSend = mail($to,$subject,$txt,$headers);
          if($flgSend)
          {
            echo "ทำการส่งรหัสยืนยันเรียบร้อย...";
          }
         else
          {
            echo "Mail cannot send.";
          }
        }
      }
    ?>

        <div class="jumbotron" style="text-align: center">
          <h1 style="text-align: center"><font size="6">Delivery | ManGO</font></h1>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p></p>

                    <form method="post">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Customer email</label>
                            <input type="email" class="form-control" name="emaild" placeholder="Email" required />
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Delivery code</label>
                            <input type="text" class="form-control" name="coded" placeholder="code" required />
                        </div>

                            <button type="submit" class="btn btn-default">send code</button>

                    </form>

    </body>
</html>
