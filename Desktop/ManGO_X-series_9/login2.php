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

<style>@import "global-order.css";</style>

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

    

    <style>
/* Full-width input fields */
input[type=text], input[type=password] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

/* Set a style for all buttons */
button {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
}

/* Extra styles for the cancel button */
.cancelbtn {
    width: auto;
    padding: 10px 18px;
    background-color: #f44336;
}

/* Center the image and position the close button */
.imgcontainer {
    text-align: center;
    margin: 24px 0 12px 0;
    position: relative;
}

img.avatar {
    width: 40%;
    border-radius: 50%;
}

.container {
    padding: 16px;
}

span.psw {
    float: right;
    padding-top: 16px;
}

/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    padding-top: 60px;
}

/* Modal Content/Box */
.modal-content {
    background-color: #fefefe;
    margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
    border: 1px solid #888;
    width: 80%; /* Could be more or less, depending on screen size */
}

/* The Close Button (x) */
.close {
    position: absolute;
    right: 25px;
    top: 0;
    color: #000;
    font-size: 35px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: red;
    cursor: pointer;
}

/* Add Zoom Animation */
.animate {
    -webkit-animation: animatezoom 0.6s;
    animation: animatezoom 0.6s
}

@-webkit-keyframes animatezoom {
    from {-webkit-transform: scale(0)}
    to {-webkit-transform: scale(1)}
}

@keyframes animatezoom {
    from {transform: scale(0)}
    to {transform: scale(1)}
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
    span.psw {
       display: block;
       float: none;
    }
    .cancelbtn {
       width: 100%;
    }
}
</style>


<script>
// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>


  <body>
  <!--- php --->

 <!-- End php -->
 <?php
 	 if(!isset($_SESSION['user'])) {
 ?>




    <!--bar top-->
    <?php
     include "dblink.php";
     include "topbar.php";
    ?>
    <!-- end bar top-->

        <br><br>
        <div class="jumbotron" style="text-align: center">
          <h1 style="text-align: center"><font size="6">SIGN IN | ManGO store</font></h1>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p></p>

                    <form method="post">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" class="form-control" name="email" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" name="pswd" placeholder="Password">
                        </div>

                        <input type="checkbox" name="save_account">
                        <span>เก็บข้อมูลไว้ในเครื่องนี้</span><br><br>
                            <p style="text-align: center"><input type="submit" Class="btn" /></p>
                          <br><br><a href="forget-password.php" id="forget">ลืมรหัสผ่าน</a>

                    </form>

                   <a href="index2.php">กลับสู่หน้าหลัก</a>


                </div>
                <div class="col-md-6">
                    <h3>NOT HAVE ACCOUNT ?</h3>
                    <h5>Creating an account is easy and only takes a few seconds! Having an account makes shopping at Firebox so much better:</h5>
                    <ul>
                        <li>Use our Express Checkout</li>
                        <li>Track the status of all your orders</li>
                        <li>Receive exclusive special offers</li>
                        <li>Access to any cool new features</li>
                    </ul>
                    <a href="new-member.php"><button type="submit" class="btn btn-default">Create Account</button></a>
                </div>
            </div>
        </div>

        <?php
          }
          else {
       ?>
        <p>ท่านเข้าสู่ระบบแล้ว</p>
            <?php echo $_SESSION['user']; ?><br><br>
            <a href="logout.php">ออกจากระบบ</a>
        <?php
         header("Location: index2.php");
        }
       ?>
       <br>

       <!--footer-->
       <?php
           include "foot.php";
        ?>
       <!--end footer-->
       <?php include "cartscript.php"; ?>
    </body>
</html>
<?php ob_end_flush(); ?>
