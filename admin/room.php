<?php
include '../config/page/stylesFolder.php';
?>
<body style="padding-top: 85px;">
    <?php
    include '../config/db/connect.php';
    include '../config/page/adminHeader.php';
    include '../config/functions.php';
    adminCheck($mysqli);
    ?>
    
    <div style="padding-top: 85px;" class="body2">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Rooms</h1>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Room Number</th>
                                <th>Floor</th>
                                <th>Price</th>
                                <th>Sleeping Spaces</th>
                                <th>Description</th>
                                <th>Submit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if(isset($_GET['did'])){
                                $delete_id = $_GET['did'];
                                $sql = "DELETE FROM rooms WHERE id = ?";
                                $stmt = $mysqli->prepare($sql);
                                $stmt->bind_param('i', $delete_id);

                                $exists = false;
                                $esql = "SELECT * FROM rooms WHERE id = ?";
                                $estmt = $mysqli->prepare($esql);
                                $estmt->bind_param('i', $delete_id);
                                $estmt->execute();
                                $result = $estmt->get_result();
                                if ($result->num_rows > 0) {
                                    $exists = true;
                                }
                                if ($stmt->execute()) {
                                    if(!$exists){
                                        $notification = 'Room not found.';
                                        $alert = 'danger';
                                    }else{
                                    $notification = 'Room deleted.';
                                    $alert = 'success';
                                    }
                                } else {
                                    $notification = 'Failed to delete room.';
                                    $alert = 'danger';
                                }

                                ?>
                                <div class="alert alert-<?php echo $alert; ?>" role="alert" id="notification"><?php echo $notification; ?></div>
                                <?php
                            }
                            if (isset($_POST['submit'])) {
                                $id = $_POST['id'];
                                $floor_id = $_POST['floor_id'];
                                $price_per_night = $_POST['price_per_night'];
                                $sleeping_spaces = $_POST['sleeping_spaces'];
                                $description = $_POST['description'];

                                $sql = "UPDATE rooms SET floor_id=?, price_per_night=?, sleeping_spaces=?, description=? WHERE id=?";
                                $stmt = $mysqli->prepare($sql);
                                $stmt->bind_param('iidii', $floor_id, $price_per_night, $sleeping_spaces, $description, $id);

                                if ($stmt->execute()) {
                                    ?>
                                    <div class="alert alert-success" role="alert" id="notification">Room updated successfully.</div>
                                    <?php
                                } else {
                                    ?>
                                    <div class="alert alert-danger" role="alert" id="notification">Failed to update room.</div>
                                    <?php
                                }
                            }
                        ?>
            
                        <script>
                            setTimeout(function() {
                                var notification = document.getElementById('notification');
                                if (notification) {
                                    notification.style.display = 'none';
                                }
                            }, 3000);
                        </script>
                            <?php
                            $sql = "SELECT r.*, COALESCE(rb_count.bookings, 0) 
                                    AS bookings
                                    FROM rooms r
                                    LEFT JOIN (
                                        SELECT rb.room_id, COUNT(*) AS bookings
                                        FROM room_booking rb
                                        JOIN booking b ON rb.booking_id = b.id
                                        GROUP BY rb.room_id
                                    ) rb_count ON r.id = rb_count.room_id
                                    ORDER BY bookings DESC;";
                                    
                            $result = $mysqli->query($sql);
                            while ($row = $result->fetch_assoc()) {
                            ?>
                                <tr>
                                <form action="" method="post">
                                <td><?php echo $row['id']; ?></td>
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <td><input class="text-black" type="text" name="floor_id" value="<?php echo $row['floor_id']; ?>"></td>
                                <td><input class="text-black" type="number" name="price_per_night" value="<?php echo $row['price_per_night']; ?>"></td>
                                <td><input class="text-black" type="number" name="sleeping_spaces" value="<?php echo $row['sleeping_spaces']; ?>"></td>
                                <td><input class="text-black" type="text" name="description" value="<?php echo $row['description']; ?>"></td>
                                <td><button type="submit" name="submit" class="btn btn-primary">Save</button></td>
                                <td><a href="user.php?did=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a></td>
                            </form>
                        </tr>
                        <?php
                            }
                        ?>
                        </tbody>
                    </table>
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