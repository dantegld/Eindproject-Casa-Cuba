<?php include 'config/page/styles.php'; ?>
<body style="padding-top: 85px;">
<?php

include 'config/db/connect.php';
include 'config/page/blackHeader.php';
?>

    <div class="body2">
      <div class="confirmcontainer">
      <?php
        if (isset($_POST['datein']) && isset($_POST['dateout']) && isset($_POST['room'])) {

          $datein = $_POST['datein'];
          $dateout = $_POST['dateout'];
          $rooms = $_POST['room'];
          
      
          $checkinDate = new DateTime($datein);
          $checkoutDate = new DateTime($dateout);
          $interval = $checkinDate->diff($checkoutDate);
          $numDays = $interval->days;
      
          $numRooms = 0;
          $totalPrice = 0;

          $totalAdults = 0;
          $totalChildren = 0;
  
          $numNights = $numDays;
          $numDays++;

          $formattedCheckinDate = $checkinDate->format('j M Y'); 
          $formattedCheckoutDate = $checkoutDate->format('j M Y'); 
          
          foreach ($rooms as $roomId => $roomData) {
            $adults = isset($roomData['adults']) ? (int)$roomData['adults'] : 0;
            $children = isset($roomData['children']) ? (int)$roomData['children'] : 0;
  
            if ($adults + $children > 0) {
                
                $sqlPrice = "SELECT price_per_night FROM rooms WHERE id = '$roomId'";
                $resultPrice = $mysqli->query($sqlPrice);
                if ($resultPrice) {
                    $roomData = $resultPrice->fetch_assoc();
                    if ($roomData) {
                        $price = $roomData['price_per_night'];
                        $pricePerRoom = $price * $numNights;
                        $totalPrice += $pricePerRoom;
                    }
                }
                $totalAdults += $adults;
                $totalChildren += $children;
            }
          }
          $serializedRooms = htmlspecialchars(serialize($rooms));
      ?>

        <div class="informationformcontainer">
        <h1 class="pi">Personal information</h1>
        <br>
        
        <form id="myForm" action="calc/book.php" method="post" class="informationform">
          <div class="names">
            <input type="hidden" name="datein" value="<?php echo $datein; ?>">
            <input type="hidden" name="dateout" value="<?php echo $dateout; ?>">
            <input type="hidden" name="totalPrice" value="<?php echo $totalPrice; ?>">
            <input type="hidden" name="room" value="<?php echo $serializedRooms; ?>">
            <input type="hidden" name="totalAdults" value="<?php echo $totalAdults; ?>">
            <input type="hidden" name="totalChildren" value="<?php echo $totalChildren; ?>">
            <div class="formfirstname">
            <label for="firstName">First Name</label><br> 
            <input type="text" name="firstName" placeholder="" autocomplete="off" required class="form-control"><br><br>
            </div>
            <div class="formlastname">
            <label for="lastName">Last Name</label><br>
            <input type="text" name="lastName" placeholder="" autocomplete="off" required class="form-control"><br><br>
            </div>
          </div>
          <div class="emailTel">
            <label for="email">Email</label><br>
            <div>
            <input id="email" type="email" name="email" placeholder="" autocomplete="off" required class="form-control"><br><br>
            </div>
          </div>
          <div class="emailTel">
            <label for="phoneNumber">Phone Number</label><br>
            <input type="tel" name="phoneNumber" placeholder="" autocomplete="off" required class="form-control"><br><br>
          </div>
          <div class="emailTel">
            <label for="comment">Comments</label><br>
            <input type="text" name="comment" autocomplete="off" placeholder="Leave an extra comment..." class="form-control"><br><br>
          </div>
          <div class="rules">
            <input type="checkbox" id="exampleCheck1" required>
            <?php
            
            //$ruledirectory = "http://localhost/dante/2025/Casa-Cuba/images/rules/Casa-Cuba-Rules.pdf";
            $ruledirectory = "images/rules/Casa-Cuba-Rules.pdf";
            ?>
            <label for="exampleCheck1">I agree to the <a href="<?= $ruledirectory; ?>" target="_blank">rules and regulations</a> of Casa Cuba</label>
          </div>

          <input type="submit" value="Proceed to checkout" class="btn btn-primary btn-block text-white">
        </form>
        </div>

        <div class="bookinginfo">
        <h1 class="ys">Your Stay</h1>
        <br>
        <?php

        ?>

        <div class="checkinInfo">
          <p>Duration: <?php echo $numDays;?> days and <?php echo $numNights;?> nights</p>
          <div class="checkinScheme">
            <div>
              <p class='nomarg arivdep'>Arrival</p>
              <p class='nomarg'><?php echo $formattedCheckinDate; ?></p>
              <p class='nomarg'>15:00</p>
            </div>
            <div class="arrow">
              <i class="fa fa-arrow-right" aria-hidden="true"></i>
            </div>
            <div>
              <p class='nomarg arivdep'>Departure</p>
              <p class='nomarg'><?php echo $formattedCheckoutDate; ?></p>
              <p class='nomarg'>11:00</p>
            </div>
          </div>
        </div>
        <br>
        <?php
        $totalPrice = 0;
        if ($numRooms == 1) {
            echo "<h2>Room</h2>";
        } else {
            echo "<h2>Rooms</h2>";
        }

        foreach ($rooms as $roomId => $roomData) {
          $adults = isset($roomData['adults']) ? (int)$roomData['adults'] : 0;
          $children = isset($roomData['children']) ? (int)$roomData['children'] : 0;

          if ($adults + $children > 0) {
              
              $sqlPrice = "SELECT price_per_night, room_number FROM rooms WHERE id = '$roomId'";
              $resultPrice = $mysqli->query($sqlPrice);
              if ($resultPrice) {
                  $roomData = $resultPrice->fetch_assoc();
                  if ($roomData) {
                      $price = $roomData['price_per_night'];
                      $roomNumber = $roomData['room_number'];
                      $pricePerRoom = $price * $numNights;
                      $totalPrice += $pricePerRoom;
                      echo '<div class="roominfo">';
                      echo '<div class="roomprice">';
                      echo "<h5>Room $roomNumber</h5>";
                      echo "<p>&euro; $pricePerRoom</p>";
                      echo '</div>';
                      if ($adults > 0) {
                        if ($adults == 1 && $children == 0) {
                          echo "<p><i class='fa fa-user' aria-hidden='true'></i>$adults Adult</p>";
                        } elseif ($adults == 1 && $children > 0) {
                          echo "<p class='nomarg'><i class='fa fa-user' aria-hidden='true'></i>$adults Adult</p>";
                        } elseif ($adults > 1 && $children == 0) {
                          echo "<p><i class='fa fa-users' aria-hidden='true'></i>$adults Adults</p>";
                        } elseif ($adults > 1 && $children > 0) {
                          echo "<p class='nomarg'><i class='fa fa-users' aria-hidden='true'></i>$adults Adults</p>";
                        }
                      }
                      if ($children > 0) {
                        if ($children == 1) {
                          echo "<p><i class='fa fa-user' aria-hidden='true'></i>$children Child</p>";
                        } else {
                          echo "<p><i class='fa fa-users' aria-hidden='true'></i>$children Children</p>";
                        }
                      }
                      echo '</div>';
                  }
              }
          }
        }
        ?>
        <div class="totalprice">
        <h2 style="width: 50%;">Total</h2>
        <p class="nomarg">&euro; <?php echo "$totalPrice"; ?> </p>
        </div>
        <div class="totalprice">
        <h2 style="width: 50%;">Subtotal <br> (21% BTW)</h2>
        <p class="nomarg">&euro; <?php $totalPricebtw = $totalPrice * 1.21; echo "$totalPricebtw"; ?> </p>
        </div>
        </div>
        <?php 
        }else{
          header('Location: index');
        }
         ?>
      </div>
      </div>

      <!-- js -->
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