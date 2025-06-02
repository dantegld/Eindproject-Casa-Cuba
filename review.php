<?php include 'config/db/connect.php'; ?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sogo Hotel by Colorlib.com</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=|Roboto+Sans:400,700|Playfair+Display:400,700">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">
    <link rel="stylesheet" href="css/fancybox.min.css">
    <link rel="stylesheet" href="fonts/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="fonts/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<style>
    .star-rating {
        direction: rtl;
        display: inline-block;
        padding: 20px;
    }
    .star-rating input[type="radio"] {
        display: none;
    }
    .star-rating label {
        font-size: 2em;
        color: #ddd;
        cursor: pointer;
    }
    .star-rating input[type="radio"]:checked ~ label {
        color: #ffba5a!important;
    }
    .star-rating label:hover,
    .star-rating label:hover ~ label {
        color: #ffba5a!important;
    }
</style>

<?php
include 'config/functions.php';
include 'config/page/mainHeader.php';

?>


<section class="site-hero inner-page overlay" style="background-image: url(images/hero_4.jpg)">
    <div class="container">
        <div class="row site-hero-inner justify-content-center align-items-center">
            <div class="col-md-10 text-center" data-aos="fade">
                <h1 class="heading mb-3">Review</h1>
                <ul class="custom-breadcrumbs mb-4">
                    <li><a href="index">Home</a></li>
                    <li>&bullet;</li>
                    <li>Review</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section style="padding: 4em 0;" class="section">
    <div class="container">
        <h1 style="color: #fff; padding-bottom:20px; user-select: none; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none;" id="form1">aaaaa</h1>
        <h1 style="width:fit-content; margin: 0 auto;">Post a review</h1>
        <div class="row">
            <div class="col-md-7" data-aos="fade-up" data-aos-delay="100">
                <?php
                if (isset($_POST['name']) && isset($_POST['booking_id']) && isset($_POST['rating']) && isset($_POST['review'])) {
                    $name = $_POST['name'];
                    $booking_id = $_POST['booking_id'];
                    $rating = $_POST['rating'];
                    $review = $_POST['review'];

                    
                    $sql = "SELECT * FROM booking WHERE id = ?";
                    $stmt = $mysqli->prepare($sql);
                    $stmt->bind_param("i", $booking_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    $stmt->close();

                    if ($row) {
                        $guest_id = $row['guest_id'];

                        
                        $sql = "SELECT * FROM guest WHERE id = ?";
                        $stmt = $mysqli->prepare($sql);
                        $stmt->bind_param("i", $guest_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $row = $result->fetch_assoc();
                        $stmt->close();

                        if ($row) {
                            $firstName = $row['first_name'];
                            $lastName = $row['last_name'];
                            $fullName = $firstName . " " . $lastName;

                            if ($name == $fullName) {
                                if (ctype_lower($review[0])) {
                                    $review = ucfirst($review);
                                }
                                if ($review[strlen($review) - 1] != '.') {
                                    $review .= '.';
                                }
                                $review = htmlspecialchars($review);
                                $review = trim($review);
                                $sql = "INSERT INTO reviews (guest_id, rating, text) VALUES (?, ?, ?)";
                                $stmt = $mysqli->prepare($sql);
                                $stmt->bind_param("iis", $guest_id, $rating, $review);
                                $stmt->execute();
                                $stmt->close();

                                echo '<div class="alert alert-success" role="alert">Successfully posted review</div>';
                            } else {
                                echo '<div class="alert alert-danger" role="alert">Name does not match booking</div>';
                            }
                        } else {
                            echo '<div class="alert alert-danger" role="alert">Guest not found</div>';
                        }
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Booking not found</div>';
                    }
                }
                ?>

                <form action="#form" id="form" method="post" class="bg-white p-md-5 p-4 mb-5 border">
                    
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="name">Name on booking</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="John Doe">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="booking_id">Booking Number</label>
                            <input type="text" name="booking_id" id="booking_id" class="form-control" placeholder="123">
                        </div>
                    </div>
                    <br>
                    <div style="padding-left:0;" class="col-md-12 form-group">
                        <div class="ratingrow">
                        <label style="margin-right:10px;" for="rating">Rating</label>
                            <div class="rating">
                                <input type="radio" id="star5" name="rating" value="5" />
                                <label for="star5"></label>
                                <input type="radio" id="star4" name="rating" value="4" />
                                <label for="star4"></label>
                                <input type="radio" id="star3" name="rating" value="3" />
                                <label for="star3"></label>
                                <input type="radio" id="star2" name="rating" value="2" />
                                <label for="star2"></label>
                                <input type="radio" id="star1" name="rating" value="1" />
                                <label for="star1"></label>
                            </div>
                        </div>

                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12 form-group">
                            <label for="review">Review</label>
                            <textarea name="review" id="review" class="form-control" cols="30" rows="8" placeholder="Text here..."></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group center">
                            <input type="submit" value="Send Review" class="btn btn-primary text-white font-weight-bold">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<footer class="section footer-section">
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-3 mb-5">
                <ul class="list-unstyled link">
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Terms &amp; Conditions</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Rooms</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-5">
                <ul class="list-unstyled link">
                    <li><a href="#">The Rooms &amp; Suites</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">Restaurant</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-5 pr-md-5 contact-info">
                <p><span class="d-block"><span class="ion-ios-location h5 mr-3 text-primary"></span>Address:</span> <span> 198 West 21th Street, <br> Suite 721 New York NY 10016</span></p>
                <p><span class="d-block"><span class="ion-ios-telephone h5 mr-3 text-primary"></span>Phone:</span> <span> (+1) 435 3533</span></p>
                <p><span class="d-block"><span class="ion-ios-email h5 mr-3 text-primary"></span>Email:</span> <span> info@domain.com</span></p>
            </div>
            <div class="col-md-3 mb-5">
                <p>Sign up for our newsletter</p>
                <form action="#" class="footer-newsletter">
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="Email...">
                        <button type="submit" class="btn"><span class="fa fa-paper-plane"></span></button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row pt-5">
            <p class="col-md-6 text-left">
                Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
            </p>
            <p class="col-md-6 text-right social">
                <a href="#"><span class="fa fa-tripadvisor"></span></a>
                <a href="#"><span class="fa fa-facebook"></span></a>
                <a href="#"><span class="fa fa-twitter"></span></a>
                <a href="#"><span class="fa fa-linkedin"></span></a>
                <a href="#"><span class="fa fa-vimeo"></span></a>
            </p>
        </div>
    </div>
</footer>

<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/jquery-migrate-3.0.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/jquery.stellar.min.js"></script>
<script src="js/jquery.fancybox.min.js"></script>
<script src="js/aos.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/jquery.timepicker.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>