<?php
include '../config/db/connect.php';
include '../config/functions.php';
require '../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST["datein"]) && isset($_POST["dateout"]) && isset($_POST["totalPrice"]) 
    && isset($_POST["firstName"]) && isset($_POST["lastName"]) && isset($_POST["email"])
    && isset($_POST["phoneNumber"]) && isset($_POST["comment"]) && isset($_POST["totalAdults"]) 
    && isset($_POST["totalChildren"]) && isset($_POST["room"])) {

    $datein = $_POST["datein"]; 
    $dateout = $_POST["dateout"];
    
    $datetime1 = new DateTime($datein);
    $datetime2 = new DateTime($dateout);
    $interval = $datetime1->diff($datetime2);
    $nights = $interval->format('%a');
    $nights = (int)$nights;
    $nights = $nights;
    $totalPrice = $_POST["totalPrice"];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    $phoneNumber = $_POST["phoneNumber"];
    $comment = $_POST["comment"];
    $totalAdults = $_POST["totalAdults"];
    $totalChildren = $_POST["totalChildren"];
    $rooms = unserialize(htmlspecialchars_decode($_POST['room']));

    $checkinDate = new DateTime($datein);
    $checkoutDate = new DateTime($dateout);
    $formattedCheckinDate = $checkinDate->format('j M Y');
    $formattedCheckoutDate = $checkoutDate->format('j M Y');

    $firstName = ucfirst($firstName);
    $lastName = ucwords($lastName);


    $sqlUser = "INSERT INTO guest (first_name, last_name, email, phone_number) VALUES ('$firstName', '$lastName', '$email', '$phoneNumber')";
    $resultUser = $mysqli->query($sqlUser);
    if ($resultUser) {
        $guestId = $mysqli->insert_id;
        $datetoday = date("Y-m-d");
        if (empty($comment)) {
            $sql = "INSERT INTO booking (checkin_date, checkout_date, price, guest_id, adults, children,booking_date) VALUES ('$datein', '$dateout', '$totalPrice', '$guestId', '$totalAdults', '$totalChildren' ,'$datetoday')";
        } else {
            $sql = "INSERT INTO booking (checkin_date, checkout_date, price, guest_id, comment, adults, children,booking_date) VALUES ('$datein', '$dateout', '$totalPrice', '$guestId', '$comment', '$totalAdults', '$totalChildren','$datetoday')";
        }
        $result = $mysqli->query($sql);
        if ($result) {
            $bookingId = $mysqli->insert_id;
            foreach ($rooms as $roomId => $roomData) {
                $adults = isset($roomData['adults']) ? (int)$roomData['adults'] : 0;
                $children = isset($roomData['children']) ? (int)$roomData['children'] : 0;
                
                if (($adults + $children) > 0) {
                    $sqlRoom = "INSERT INTO room_booking (booking_id, room_id) VALUES ('$bookingId', '$roomId')";
                    $resultRoom = $mysqli->query($sqlRoom);
                }
            }
        }
    }

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com';  
        $mail->SMTPAuth = true;
        $mail->Username = 'casacuba@zoobagogo.com';  
        $mail->Password = 'C4sacuba!';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;  

        $mail->setFrom('casacuba@zoobagogo.com', 'Casa Cuba');  
        $mail->addAddress($email); 

        $mail->isHTML(true);
        $mail->Subject = 'Booking details for Casa Cuba';

        
        $roomDetails = '';
        $sqlbookingdate = "SELECT booking_date FROM booking WHERE id = $bookingId";
        $resultbookingdate = $mysqli->query($sqlbookingdate);
        $rowbookingdate = $resultbookingdate->fetch_assoc();
        $bookingdate = $rowbookingdate['booking_date'];
        
        foreach ($rooms as $roomId => $roomData) {
            
            $sqlPrice = "SELECT price_per_night FROM rooms WHERE id = $roomId";
            $resultPrice = $mysqli->query($sqlPrice);
            $row = $resultPrice->fetch_assoc();
            $price = $row['price_per_night'];

            $sqlRoom = "SELECT room_number FROM rooms WHERE id = $roomId";
            $resultRoom = $mysqli->query($sqlRoom);
            $rowRoom = $resultRoom->fetch_assoc();
            $roomNumber = $rowRoom['room_number'];


            $adults = isset($roomData['adults']) ? (int)$roomData['adults'] : 0;
            $children = isset($roomData['children']) ? (int)$roomData['children'] : 0;
            
            if($adults + $children > 0) {
                $roomDetails .= "<tr>
                <td style='padding: 8px; text-align: left;'>Room $roomNumber</td>
                <td style='padding: 8px; text-align: left;'>$adults</td>
                <td style='padding: 8px; text-align: left;'>$children</td>
                <td style='padding: 8px; text-align: left;'>$" . $price . "</td>
             </tr>";
            }

        }

        $btw = $totalPrice * 0.21;
        $totalWithBtw = $totalPrice + $btw;

        $mail->Body =  "<!DOCTYPE html PUBLIC '-//W3C//DTD XTHML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>

<html xmlns='http://www.wr.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
<meta http-equiv='X-UA-Compatible' content='IE=edge'/>
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <style>
        body {
            font-family: 'Playfair Display', times, serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            width: 100vw;
            overflow-x: hidden;
        }
        .container {
            width: 100%;
            max-width: 600px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
        }
        header {
            color: #ffffff;
            width: 100%;
        }
        .header1 {
            color: #ffffff;
            width: 100%;
        }
        h1 {
            margin: 0;
            font-size: 2em;
            color: #386FA4;
        }
        .hotelinfo {
            width: 95%;
            font-size: 10px;
            margin: 0 auto;
            padding-top: 25px;
        }
        a {
            color: #6c757d;
            transition: 1s;
        }
        a:hover {
            text-decoration: underline;
        }
        p {
            color: #6c757d;
        }
        .empty {
            color: #f4f4f4;
        }
        hr {
            width: 95%;
            border: 0;
            height: 1px;
            background-color: #386FA4;
        }
        .bookinginfo {
            margin-left: 15px;
        }
        h4, h5 {
            color: #386FA4;
            font-weight: bold;  
        }
        .roominfo {
            width: 50%;
        }
        .info {
            width: 50%;
        }
        .userinfo {
            width: 95%;
        }
        .guestinfo {
            width: 50%;
            text-align: left;
        }
        .bookingid {
            width: 50%;
            text-align: right;
        }
        .h5 {
            color: #386FA4;
            font-weight: bold;
        }
        .bookingrow {
            width: 100%;
            padding-bottom: 12px;
        }
        .bookingrow .h5 {
            margin-right: 10px;
        }
        .bookingrow span {
            white-space: nowrap;
        }
        table.table {
            width: 95%;
            border-collapse: separate;
            border-spacing: 0;
            border: 2px solid #285885;
            margin: 0 auto;
        }
        .table th, td {
            padding: 8px;
            text-align: left;
            border: none;
        }
        .table th {
            background-color: #285885;
            color: white;
        }
        .table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .total-row td {
            font-weight: bold;
            background-color: #f2f2f2;
            border-top: 2px solid #285885;
        }
        .btw-row td {
            font-weight: bold;
            background-color: #f2f2f2;
        }
        table.userinfo {
            width: 95%;
            margin: 0 auto;
        }
        .guestinfo {
            padding: 0;
        }
        .bookingid {
            padding: 0;
            display: table-cell;
            vertical-align: top;
        }
        .detailstxt{
            color: black; font-size: 12px;
        }
        .detailstxtpadding{
            color: black; font-size: 12px;padding-left: 20px;
        }
       .hotelinfotxt{
        font-size: 10px;
       }
       .bookingid, .bookingrow{
        transform: scaleY(-1);
       }

       @media (orientation:portrait){
        .bookingrow .h5{
            margin-right: 0px;
        }
        .hotelinfo{
            padding-top: 0px;
        }
       }

    </style>
</head>
<body>
    <div class='container'>
        <header>
        <div class='header1'>
            <div style='width:fit-content;margin: 0 auto;padding-top:50px'><h1>Casa Cuba</h1></div>
            <table class='hotelinfo'>
            <tr>
            <td><p class='hotelinfotxt'><span>Korte Pennincstraat 17 </span><span>2800 Mechelen, Belgium</span></p></td>
            <td><p class='hotelinfotxt'><span>0494468201</span></p></td>
            <td><p class='hotelinfotxt'><a href='mailto:casacuba@zoobagogo.com' style='color: #6c757d;'>casacuba@zoobagogo.com</a></p></td>
            <td><p class='hotelinfotxt'><a href='casacuba.zoobagogo.com'>casacuba.com</a></p></td>
            </tr>
            </table>
        </div>
        </header>
        <hr style='width: 95%; border: 0; height: 1px; background-color: #386FA4;'>

        <div class='bookinginfo'>
            <div class='info'>
                <h4>Booking Details</h4>
                <p class='detailstxt'>Check-in: $formattedCheckinDate</p>
                <p class='detailstxt'>Check-out: $formattedCheckoutDate</p>
                <p class='detailstxt'>Comments: $comment</p>
            </div>
            <div class='roominfo'>
            </div>
        </div>

        <table class='userinfo'>
        <tr>
            <td class='guestinfo'>
                <h4>Guest Details</h4>
                <p class='detailstxt'>Name: $firstName $lastName</p>
                <p class='detailstxt'>Email: $email</p>
                <p class='detailstxt'>Phone: $phoneNumber</p>
            </td>
            <td class='bookingid'>
                <div class='bookingrow'><span class='h5'>Booking Number</span><span class='detailstxtpadding'>$bookingId</span></div>
                <div class='bookingrow'><span class='h5'>Booking Date</span><span class='detailstxtpadding'>$bookingdate</span></div>
                <div class='bookingrow'><span class='h5'>Nights</span><span class='detailstxtpadding'>$nights</span></div>
            </td>
        </tr>
        </table>
                <table class='table'>
            <thead>
                <tr>
                    <th>Room</th>
                    <th>Adults</th>
                    <th>Children</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                $roomDetails
                <tr class='total-row'>
                    <td colspan='3'>Total</td>
                    <td>$$totalPrice</td>
                </tr>
                <tr class='btw-row'>
                    <td colspan='3'>BTW (21%)</td>
                    <td>$$btw</td>
                </tr>
                <tr class='total-row'>
                    <td colspan='3'>Total with BTW</td>
                    <td>$$totalWithBtw</td>
                </tr>
            </tbody>
        </table>
        <br>
    </div>
</body>
</html>";

        $mail->send();
        $message = 'Booking confirmation has been sent to your email.';
        $message_class = 'success';
        processPayPalPayment($totalWithBtw);
    } catch (Exception $e) {
        $message = "Error sending email. Mailer Error: {$mail->ErrorInfo}";
        $message_class = 'error';
    }

} else {
    echo "Required data is missing.";
}
?>