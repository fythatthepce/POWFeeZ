<html>
<head>
  <meta http-equiv="refresh" content="2;url=login.php" />
  <title>ManGo</title>
  <link rel="shortcut icon" href="mangog.png">
</head>
<body>
<?php
    require_once 'dblink.php';
    $activation_key = $_GET['key'];
    if(isset($activation_key) && !empty($activation_key)){
        $activation_key = $link->real_escape_string($activation_key);
        $checkActivationKey = "SELECT cust_id,verify FROM customers WHERE activation_key = '".$activation_key."'";
        $resKey=$link->query($checkActivationKey);
        $rows_returned = $resKey->num_rows;
        if($rows_returned > 0){
            $rowKey = $resKey->fetch_assoc();
                if($rowKey['verify'] == 'N'){
                    $sqlUpdateUser = $link->query("UPDATE customers SET verify = ' ' WHERE cust_id = '".$rowKey['cust_id']."'");
                    $msg="Your account is activated";
                }else{
                    $msg ="Your account is already active.";
                }
            }else{
                $msg ="Wrong activation code.";
        }
    }

    echo $msg;
?>
<br>
<p>Redirecting in 2 seconds...</p>
</body>
<html>
