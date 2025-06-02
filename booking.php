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

    <!-- Theme Style -->
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
    <?php
    include 'config/functions.php';
    include 'config/db/connect.php';
    include 'config/page/mainHeader.php';
    if ((isset($_POST['datein']) && isset($_POST['dateout'])) || (isset($_GET['in']) && isset($_GET['out']))) {
      $datein = isset($_POST['datein']) ? $_POST['datein'] : $_GET['in'];
      $dateout = isset($_POST['dateout']) ? $_POST['dateout'] : $_GET['out'];
    ?>
    
    
    <!-- END head -->

    <section class="site-hero inner-page overlay" style="background-image: url(images/hero_4.jpg)" data-stellar-background-ratio="0.5">
      <div class="container">
        <div class="row site-hero-inner justify-content-center align-items-center">
          <div class="col-md-10 text-center" data-aos="fade">
            <h1 class="heading mb-3">Available Rooms</h1>
            <ul class="custom-breadcrumbs mb-4">
              <li><a href="index">Home</a></li>
              <li>&bullet;</li>
              <li>Rooms</li>
            </ul>
          </div>
        </div>
      </div>
    </section>
    <!-- END section -->

    
    <section class="section">
      <div class="container">
        <div class="sortBy">
          <div class="dropdown">
            <button style="border-radius:5px;" class="btn btn-primary sortBtn">Sort by <i style="padding-left: 5px;" class="fa fa-caret-down"></i></button>
            <div class="sortOptions">
              <a href="booking?sort=rn&in=<?php echo $datein; ?>&out=<?php echo $dateout; ?>">Alphabet</a>
              <a href="booking?sort=pr&in=<?php echo $datein; ?>&out=<?php echo $dateout; ?>">Price</a>
            </div>
          </div>
        </div>
        <div class="row" id="rooms-container">
            <?php

            if(!isset($_GET['sort'])){
              $sort = "r.room_number";
            }else if($_GET['sort'] == "pr"){
              $sort = "r.price_per_night";
            }else if($_GET['sort'] == "rn"){
              $sort = "r.room_number";
            }




            $sqlAvailable = "SELECT r.id, r.room_number, r.sleeping_spaces, f.floor_number, r.price_per_night
            FROM rooms r
            INNER JOIN floors f ON f.id = r.floor_id
            LEFT JOIN room_booking rb ON r.id = rb.room_id
            LEFT JOIN booking b ON rb.booking_id = b.id
            WHERE b.id IS NULL
            OR (b.checkout_date <= '$datein' OR b.checkin_date >= '$dateout')
            ORDER BY $sort ASC";
            $resultAvailable = $mysqli->query($sqlAvailable);
            
            
            if ($resultAvailable->num_rows == 0) {
              echo "<h2>No rooms available at that time.</h2>";
              echo "<a href='index.html'>Go back</a>";
            }
              else {


            
            $sqlBooked = "SELECT r.id, r.room_number, r.sleeping_spaces, f.floor_number,r.price_per_night
            FROM rooms r
            INNER JOIN floors f ON f.id = r.floor_id
            INNER JOIN room_booking rb ON r.id = rb.room_id
            INNER JOIN booking b ON rb.booking_id = b.id
            WHERE NOT (b.checkout_date <= '$datein' OR b.checkin_date >= '$dateout')";
            $resultBooked = $mysqli->query($sqlBooked);

            $rooms = [];
            $bookedRooms = [];

            if ($resultAvailable->num_rows > 0) {
              while ($row = $resultAvailable->fetch_assoc()) {
                $rooms[$row["id"]] = $row;
              }
            }

            if ($resultBooked->num_rows > 0) {
              while ($row = $resultBooked->fetch_assoc()) {
                $bookedRooms[$row["id"]] = $row;
              }
            }
            echo "<form class='bigbookform' action='confirm' method='post'>";
            echo "<input type='hidden' name='datein' value='$datein'>";
            echo "<input type='hidden' name='dateout' value='$dateout'>";

            
            foreach ($bookedRooms as $roomId => $room) {
              echo "<input type='hidden' name='room[$roomId][adults]' value='0'>";
              echo "<input type='hidden' name='room[$roomId][children]' value='0'>";
            }

            
            foreach ($rooms as $roomId => $room) {
              $roomNumber = $room["room_number"];
              $sleepingSpaces = $room["sleeping_spaces"];
              $floorNumber = $room["floor_number"];
              $roomId = $room["id"];
              $sqlPhoto = "SELECT directory FROM photos WHERE room_id = $roomId and photo_id = 1";
              $resultPhoto = $mysqli->query($sqlPhoto);
              $photo = $resultPhoto->fetch_assoc();
              if($resultPhoto->num_rows > 0){
                $directory = $photo["directory"];
              }else{
                $directory = "images/room-1.jpg";
              }
              

              $floorNames = [
                  0 => "Ground",
                  1 => "First",
                  2 => "Second",
                  3 => "Third",
                  4 => "Fourth",
                  5 => "Fifth",
                  6 => "Sixth",
                  7 => "Seventh",
                  8 => "Eighth",
                  9 => "Ninth",
                  10 => "Tenth"
              ];
              
              $floor = isset($floorNames[$floorNumber]) ? $floorNames[$floorNumber] : "Unknown";

              $pricePerNight = $room["price_per_night"];
              
              echo '
              <a href="room?id=' . $roomId . '"><div style="margin-top:10px" class="col-md-6 col-lg-4 mb-5" data-aos="fade-up">
              <h2>Room ' . $roomNumber . '</h2>
              <div class="room-details" style="display: flex; justify-content: space-between;">
              <div>
              <figure class="img-wrap">
              <img src="' . htmlspecialchars($directory, ENT_QUOTES, 'UTF-8') . '" alt="Free website template" class="img-fluid mb-3">
              </figure>
              </a>
              <div class="p-3 text-center room-info">';
              
              echo "<span class='text-uppercase letter-spacing-1'>&euro;$pricePerNight  / per night</span>";
              echo "<div>";
              echo "Sleeping Spaces: $sleepingSpaces - $floor Floor<br>";
              echo "<label for='adults_$roomId'>Adults:</label>";
              echo "<input type='number' id='adults_$roomId' name='room[$roomId][adults]' min='0' value='0' onchange='validateRoom($roomId, $sleepingSpaces)'><br>";
              echo "<label for='children_$roomId'>Children:</label>";
              echo "<input type='number' id='children_$roomId' name='room[$roomId][children]' min='0' value='0' onchange='validateRoom($roomId, $sleepingSpaces)'><br>";
              echo "</div>
                    </div>
                    </div>
                    </div>
                    </div>
                    ";
            }

            echo '<input type="submit" value="Book now" class="btn btn-primary btn-block text-white">';
            echo "</form>";
          }
        }else {
          header ("Location: index");
        }

          ?>
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
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank" >Colorlib</a>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
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
    <script>
    function validateRoom(roomId, sleepingSpaces) {
        var adults = parseInt(document.getElementById('adults_' + roomId).value);
        var children = parseInt(document.getElementById('children_' + roomId).value);
        if (adults + children > sleepingSpaces) {
            alert('The total number of adults and children cannot exceed the number of sleeping spaces.');
            document.getElementById('adults_' + roomId).value = 0;
            document.getElementById('children_' + roomId).value = 0;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
    var inputs = document.querySelectorAll('input[type="number"]');

    inputs.forEach(function(input) {
        input.addEventListener('focus', function() {
            if (this.value === '0') {
                this.value = '';
            }
        });

        input.addEventListener('blur', function() {
            if (this.value === '') {
                this.value = '0';
            }
        });
    });
});

 
</script>
  </body>
</html>