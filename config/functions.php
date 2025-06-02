<?php

function getUserType($mysqli){
    if (!isset($_SESSION['userid'])) {
        return null;
    }

    $sql = "SELECT g.type_id, t.type,t.id FROM guest g ,type t WHERE g.id = ? and g.type_id = t.id";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $_SESSION['userid']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        return $user['type'];
    } else {
        return null;
    }
}

function isAdmin($mysqli){
    return getUserType($mysqli) == 'admin' || getUserType($mysqli) == 'owner';
}

function adminCheck($mysqli){
    if (!isAdmin($mysqli)) {
        header('Location: ../index.php');
        exit();
    }
}

function processPayPalPayment($amount)
{
   $paypalUrl = "https://sandbox.paypal.com";
   $businessEmail = "sb-0ngzp38396927@business.example.com";
   $currency = "EUR";


   header("Location: $paypalUrl?cmd=_xclick&business=$businessEmail&amount=$amount&currency_code=$currency&return=https://casacuba.zoobagogo.com/payment_succes&cancel_return=https://casacuba.zoobagogo.com/payment_cancelled&item_name=Booking Payment");
   exit();
}
?>

