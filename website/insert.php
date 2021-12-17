<?php
$fullname = $_POST['fullname'];
$phonenumber = $_POST['phonenumber'];
$email = $_POST['email'];
$roomtype = $_POST['roomtype'];
$checkindate = $_POST['checkindate'];
$checkoutdate = $_POST['checkoutdate'];
$paymentmethod = $_POST['paymentmethod'];
if (!empty($fullname) || !empty($phonenumber) || !empty($email) || !empty($roomtype) || !empty($checkindate) || !empty($checkoutdate) || !empty($paymentmethod)) {
 $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "epiz_27057044_booknow";
    //create connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
    if (mysqli_connect_error()) {
     die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
    } else {
     $SELECT = "SELECT email From bookingdata Where email = ? Limit 1";
     $INSERT = "INSERT Into bookingdata (fullname,phonenumber,email,roomtype,checkindate,checkoutdate,paymentmethod) values(?, ?, ?, ?, ?, ?, ?)";
     //Prepare statement

     $stmt = $conn->prepare($SELECT);
     $stmt->bind_param("s", $email);
     $stmt->execute();
     $stmt->bind_result($email);
     $stmt->store_result();
     $rnum = $stmt->num_rows;
     if ($rnum==0) {
      $stmt->close();
      $stmt = $conn->prepare($INSERT);
      $stmt->bind_param("sisssss", $fullname, $phonenumber, $email, $roomtype, $checkindate, $checkoutdate, $paymentmethod);
      $stmt->execute();
      readfile("thankyou.html");
     } else {
      echo "Someone already register using this email";
     }
     $stmt->close();
     $conn->close();
    }
} else {
 echo "All field are required";
 die();
}
?>