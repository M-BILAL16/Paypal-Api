<?php
session_start();

//Include DB configuration file
require_once("../admin/database.php");

$checkout=$_SESSION['checkout_success'];

if($checkout=='1'){


    $email=$_SESSION['email'];
    $order_id=$_SESSION['order_id'];
    $course_id=$_SESSION['course_id'];

    // print_r($user_id);
    // print_r($order_id);
    // print_r(123);
    // exit();

    $query="UPDATE orders SET payment_status='2' where email='$email'  AND order_id='$order_id' AND course_id='$course_id'";
    $run=db::query($query);

    echo "<script>location='../final_message.php?status=1'</script>";

}elseif($checkout=='2'){



    $email=$_SESSION['email'];
    $order_id=$_SESSION['order_id'];

    // print_r($user_id);
    // print_r($order_id);
    // print_r(123);
    // exit();

    $query="UPDATE donation SET payment_status='2' where email='$email'  AND order_id='$order_id'";
    $run=db::query($query);

    if($run!=NULL){
    
    $query="SELECT * from donation WHERE email='$email'  AND order_id='$order_id'";
    $donation=db::getRecord($query);


    
    $email =$donation['email'];
    $message=file_get_contents("invoice.html");
    $date = date("m-d-Y");
    $full_name = $donation['name'];
    $phone = $donation['phone'];
    $purchased_pack_price = $donation['amount'];
            
    // echo $purchased_pack_price;
    $variables= array(
        "{{date}}" => $date,
        "{{order_id}}" => $order_id,
        "{{full_name}}" => $full_name,
        "{{phone}}" => $phone,
        "{{user_email}}" => $email,
        "{{purchased_package_price}}" => $purchased_pack_price
    );
    

    foreach($variables as $key => $value){
        $message= str_replace($key, $value, $message);
    }
    // echo $email;
    $to = "$email";
    $subject = "ALBAHEEJ Invoice Of Donation";

    $headers = NULL;
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
    $headers .= "MIME-Version: 1.0\r\n";

    // echo $mail=mail($to,$subject,$message,$headers);
    // echo $email;
    // exit();


    }



    echo "<script>location='../final_message.php?status=2'</script>";

}elseif($checkout=='3'){




    $email=$_SESSION['email'];
    $order_id=$_SESSION['order_id'];
    $event_id=$_SESSION['event_id'];

    // print_r($user_id);
    // print_r($order_id);
    // print_r(123);
    // exit();


    $query = "SELECT * from events where id='$event_id' AND status='0'";
    $event = db::getRecord($query);

    if($event!=NULL){

        $registered_users = $event['users_registered']+1;

        $query="UPDATE events SET users_registered='$registered_users' where id='$event_id'";
        $run=db::query($query);


        $query="UPDATE event_bookings SET payment_status='2' where email='$email' AND order_id='$order_id' AND event_id='$event_id'";
        $run=db::query($query);
    }

    echo "<script>location='../final_message.php?status=3'</script>";

}


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment Successful</title>
</head>

<body>
    <h1>Thank You</h1>
    <p>Your payment was successful. Thank you.</p>
    <div id="query">
        <?php
            $date=date('Y-m-d');
            //$subscriber=date("Y-m-d",strtotime(date("Y-m-d",strtotime($date))."+".$duration."month"));
            $dateExpired= date('Y/m/d',strtotime('+30 days',strtotime($date))) . PHP_EOL;
            $six_digit_random_number = mt_rand(100000, 999999);
            $_SESSION[SID.'six_digit_random_number'] =$six_digit_random_number;
            $category="subscribe";

            $ab="INSERT into customers (id,email,password,category,joindate,uniquee,expiredate,ipaddress)
    values('','','','$category','$date','$six_digit_random_number','$dateExpired','');
";
            $run=db::query($ab);



            ?>


    </div>
</body>

</html>
