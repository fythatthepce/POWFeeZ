<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Include Sidr bundled CSS theme -->
    <link rel="stylesheet" href="dist/stylesheets/jquery.sidr.dark.css">
    <!-- Your CSS -->
    <link rel="stylesheet" href="style.css">
    <style>
     body{
       background-color: black;
       
     }

     h1 {
       color: white;
       text-align: left;
     }
    </style>
  </head>
  <body>
    <span>
    <h1><img src="mangowhite.png"  height="60" width="60"> ManGO</h1>
      <form method="get" form action="searchpro.php">
        <input type="text" placeholder="Search me" name="q" maxlength="30" value="<?php echo stripslashes($_GET['q']); ?>" required>
      </form>

    </span>

    <a id="simple-menu" href="#sidr">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      &nbsp;&nbsp;&nbsp;&nbsp;
      <img src="menu.gif"></a>
    <div id="sidr">
      <ul>
          <li><a href="order-cart.php">รถเข็น</a></li>
          <li><a href="index2.php">Home</a></li>
          <li><a href="login.php">Sign in</a></li>
          <li><a href="http://notefeez.servegame.com:8080/index2.php?catid=">All Products</a></li>
          <li>
              <a href="#">Categories</a>
              <ul>
                <li><a href="http://notefeez.servegame.com:8080/index2.php?catid=100&catname=Notebook">Laptop</a></li>
                <li><a href="http://notefeez.servegame.com:8080/index2.php?catid=101&catname=Tablet">Tablet & Phone</a></li>
                <li><a href="http://notefeez.servegame.com:8080/index2.php?catid=102&catname=PC-Desktop">Desktop Computer</a></li>
                <li><a href="http://notefeez.servegame.com:8080/index2.php?catid=103&catname=Other">Other</a></li>
              </ul>
          </li>


          <li>
              <a href="#">Brands</a>
              <ul>
                <li><a href="http://notefeez.servegame.com:8080/index2.php?braid=1&braname=Apple">Apple</a></li>
                <li><a href="http://notefeez.servegame.com:8080/index2.php?braid=100&braname=Asus">Asus</a></li>
                <li><a href="http://notefeez.servegame.com:8080/index2.php?braid=101&braname=Acer">Acer</a></li>
                <li><a href="http://notefeez.servegame.com:8080/index2.php?braid=102&braname=MSI">Msi</a></li>
                <li><a href="http://notefeez.servegame.com:8080/index2.php?braid=104&braname=Dell">Dell</a></li>
                <li><a href="http://notefeez.servegame.com:8080/index2.php?braid=105&braname=Hp">hp</a></li>
                <li><a href="http://notefeez.servegame.com:8080/index2.php?braid=106&braname=Toshiba">Toshiba</a></li>
                <li><a href="http://notefeez.servegame.com:8080/index2.php?braid=107&braname=Samsung">Samsung</a></li>
                <li><a href="http://notefeez.servegame.com:8080/index2.php?braid=108&braname=Cisco">Cisco</a></li>
                <li><a href="http://notefeez.servegame.com:8080/index2.php?braid=109&braname=Tplink">Tp-link</a></li>
                <li><a href="http://notefeez.servegame.com:8080/index2.php?braid=110&braname=Dlink">D-link</a></li>
              </ul>
          </li>


          <li><a href="how-to-order.php">Payments</a></li>
          <li><a href="order-history.php">Orders</a></li>
          <li><a href="logout.php">Sign out</a></li>
      </ul>





    </div>


    <!-- Include jQuery -->
    <script src="js/jquery-2.1.1.min.js"> </script>
    <script src="js/jquery-ui.min.js"> </script>
    <script src="js/jquery.form.min.js"> </script>
    <script src="js/jquery.blockUI.js"> </script>

    <!-- Try it also with jQuery 1.x or other version from the CDN -->
    <!-- <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script> -->
    <!-- Include the Sidr JS -->
    <script src="dist/jquery.sidr.js"></script>

    <!-- Your code -->
    <script>

    $(document).ready(function () {
      $('#simple-menu').sidr({
        timing: 'ease-in-out',
        speed: 500
      });
    });

    $( window ).resize(function () {
      $.sidr('close', 'sidr');
    });

    </script>

  </body>
</html>
