<?php include 'config/db/connect.php';
if(!isset($_GET['id'])){
  header('Location: index.php');
}
$id = $_GET['id'];
$sqlcheck = "SELECT * FROM rooms WHERE id = ?";
$stmt = $mysqli->prepare($sqlcheck);
$stmt->bind_param('i', $id);
$stmt->execute();
$resultcheck = $stmt->get_result();
if($resultcheck->num_rows == 0){
  header('Location: index.php');
}



$sql = "SELECT * FROM rooms WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$room_number = $row['room_number'];
$pricePerNight = $row['price_per_night'];
$floorId = $row['floor_id'];
$sleepingPlaces = $row['sleeping_spaces'];
$description = $row['description'];

$sql = "SELECT * FROM floors WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('i', $floorId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$floor = $row['floor_number'];

$sql = "SELECT * FROM equipment WHERE room_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$amenities = array();
while($row = $result->fetch_assoc()){
  $amenities[] = $row['amenity'];
}


?>
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
    session_start();
    include 'config/page/mainHeader.php';
    ?>
    <!-- END head -->

    <section class="site-hero inner-page overlay" style="background-image: url(images/hero_4.jpg)" data-stellar-background-ratio="0.5">
      <div class="container">
        <div class="row site-hero-inner justify-content-center align-items-center">
          <div class="col-md-10 text-center" data-aos="fade">
            <h1 class="heading mb-3">Room <?php echo "$room_number";?></h1>
            <ul class="custom-breadcrumbs mb-4">
              <li><a href="index.html">Home</a></li>
              <li>&bullet;</li>
              <li>Rooms</li>
            </ul>
          </div>
        </div>
      </div>
    </section>
    <!-- END section -->

    
    <section style="padding: 4em 0;" class="section">
      <div class="container">
      <div class="rowroom">
        <div class="headerPrice"><h1 class="nomarg">Room <?php echo "$room_number";?></h1> <h1 class="nomarg">&euro;<?php echo"$pricePerNight"; ?></h1></div>
        <?php
        
        switch ($floor){
            case 0:
                echo "<div class='floor'>Ground Floor</div>";
                break;
            case 1:
                echo "<div class='floor'>First Floor</div>";
                break;
            case 2:
                echo "<div class='floor'>Second Floor</div>";
                break;
                default:
                echo "<div class='floor'></div>";
            }

        ?>
        <div class="roomcontainer">
            <div style="height:fit-content; width: 500px;">
              <!-- TODO: GET IMAGE FROM DATABASE -->
                <img src="images/img_1.jpg" alt="Free website template" style="max-width: 500px; padding-right:20px">
            </div>
            <div class="roominfo">
                <div class="description">
                    <h2>Description</h2>
                    <p>
                        <?php
                        if(empty($description)){
                            echo "No description available";
                        }
                        

                        echo "$description"; ?>
                    </p>
                </div>
                
                <div class="amenities">

                </div>
            </div>

            
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
            <!-- <li>198 West 21th Street, <br> Suite 721 New York NY 10016</li> -->
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
  </body>
</html>