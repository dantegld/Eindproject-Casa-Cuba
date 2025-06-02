<?php
include '../config/page/stylesFolder.php';
?>
<body style="padding-top: 85px;">
    <?php 
    include '../config/page/adminHeader.php';
    include '../config/db/connect.php';
    include '../config/functions.php';

    if(!isset($_GET['id'])){
        header('Location: admin.php');
    }
    $id = $_GET['id'];
    ?>
    
    <style>
        .expandable-card {
            min-height: 200px; 
            overflow: auto;
        }
    </style>

    <div style="padding-top: 85px;" class="body2">
        <div class="center">
            <?php
            
            $sql_booking = "SELECT guest_id, checkin_date, checkout_date, price, adults, children, booking_date, comment FROM booking b WHERE id = ?";
            $stmt_booking = $mysqli->prepare($sql_booking);
            $stmt_booking->bind_param('i', $id);
            $stmt_booking->execute();
            $result_booking = $stmt_booking->get_result();
            $row_booking = $result_booking->fetch_assoc();
            $guest_id = $row_booking['guest_id'];

           
            $sql_room = "SELECT r.room_number FROM room_booking rb JOIN rooms r ON rb.room_id = r.id WHERE rb.booking_id = ?";
            $stmt_room = $mysqli->prepare($sql_room);
            $stmt_room->bind_param('i', $id);
            $stmt_room->execute();
            $result_room = $stmt_room->get_result();
            $room_numbers = array();
            while($room_row = $result_room->fetch_assoc()){
                $room_numbers[] = $room_row['room_number'];
            }
            
            
            $sql_guest = "SELECT first_name, last_name, email, phone_number FROM guest WHERE id = ?";
            $stmt_guest = $mysqli->prepare($sql_guest);
            $stmt_guest->bind_param('i', $guest_id);
            $stmt_guest->execute();
            $result_guest = $stmt_guest->get_result();
            $row_guest = $result_guest->fetch_assoc();
            ?>
<div class="container">
    <h2 class="text-center mb-4">Booking Details</h2>
    <div class="row">
        
        <div class="col-md-4">
            <div class="card mb-4 expandable-card">
                <div class="card-header bg-light text-dark">
                    <h5>Booking Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>Check-in Date:</strong> <?php echo $row_booking['checkin_date']; ?></p>
                    <p><strong>Check-out Date:</strong> <?php echo $row_booking['checkout_date']; ?></p>
                    <p><strong>Price:</strong> $<?php echo $row_booking['price']; ?></p>
                    <p><strong>Adults:</strong> <?php echo $row_booking['adults']; ?></p>
                    <p><strong>Children:</strong> <?php echo $row_booking['children']; ?></p>
                    <p><strong>Booking Date:</strong> <?php echo $row_booking['booking_date']; ?></p>
                    <?php if (!empty($row_booking['comment'])): ?>
                        <p><strong>Comment:</strong> <?php echo $row_booking['comment']; ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-light text-dark">
                    <h5>Rooms Booked</h5>
                </div>
                <div class="card-body">
                    <ul>
                        <?php foreach ($room_numbers as $room_number): ?>
                            <li>Room <?php echo $room_number; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>

        
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-light text-dark">
                    <h5>Guest Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>First Name:</strong> <?php echo $row_guest['first_name']; ?></p>
                    <p><strong>Last Name:</strong> <?php echo $row_guest['last_name']; ?></p>
                    <p><strong>Email:</strong> <?php echo $row_guest['email']; ?></p>
                    <p><strong>Phone Number:</strong> <?php echo $row_guest['phone_number']; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/jquery-migrate-3.0.1.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/owl.carousel.min.js"></script>
    <script src="../js/jquery.stellar.min.js"></script>
    <script src="../js/jquery.fancybox.min.js"></script>
    <script src="../js/aos.js"></script>
    <script src="../js/bootstrap-datepicker.js"></script> 
    <script src="../js/jquery.timepicker.min.js"></script> 
    <script src="../js/main.js"></script>
</body>
</html>