<?php
include '../config/page/stylesFolder.php';
include '../config/page/adminHeader.php';
include '../config/db/connect.php';
include '../config/functions.php';


adminCheck($mysqli);
?>
<body style="padding-top: 85px;overflow-y:hidden;">
    
    <div class="body2">
        <div class="reviews pico">
            <?php
            if (isset($_GET['vid']) || isset($_GET['did'])) {
                if (isset($_GET['vid'])) {
                    $id = $_GET['vid'];

                    $exists = false;
                    $sql = "SELECT * FROM reviews WHERE id = ? AND verified = 0";
                    $stmt = $mysqli->prepare($sql);
                    $stmt->bind_param('i', $id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        $exists = true;
                    }




                    $sql = "UPDATE reviews SET verified = 1 WHERE id = ?";
                    $stmt = $mysqli->prepare($sql);
                    $stmt->bind_param('i', $id);
                    if ($stmt->execute()) {
                        if(!$exists){
                            $notification = 'Review not found.';
                            $alert = 'danger';
                        }else{
                        $notification = 'Review verified.';
                        $alert = 'success';
                        }
                    } else {
                        $notification = 'Failed to verify review.';
                        $alert = 'danger';
                    }
                } else {
                    $id = $_GET['did'];

                    $exists = false;
                    $sql = "SELECT * FROM reviews WHERE id = ?";
                    $stmt = $mysqli->prepare($sql);
                    $stmt->bind_param('i', $id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        $exists = true;
                    }



                    $sql = "DELETE FROM reviews WHERE id = ?";
                    $stmt = $mysqli->prepare($sql);
                    $stmt->bind_param('i', $id);
                    if ($stmt->execute()) {
                        if(!$exists){
                            $notification = 'Review not found.';
                            $alert = 'danger';
                        }else{
                        $notification = 'Review deleted.';
                        $alert = 'success';
                        }
                    } else {
                        $notification = 'Failed to delete review.';
                        $alert = 'danger';
                    }
                    ?>
                    <div class="alert alert-<?php echo $alert; ?>" role="alert" id="notification"><?php echo $notification; ?></div>
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
            $sql = "SELECT * FROM reviews WHERE verified = 0";
            $stmt = $mysqli->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result(); 

            if ($result->num_rows > 0) {
                ?>
                <div class="wrapper">
                    <?php
                while ($row = $result->fetch_assoc()) {
                    $rating = $row['rating'];
                    $guest_id = $row['guest_id'];
                    $id = $row['id'];
                    $sql2 = "SELECT * FROM guest WHERE id = ?";
                    $stmt2 = $mysqli->prepare($sql2);
                    $stmt2->bind_param('i', $guest_id);
                    $stmt2->execute();
                    $result2 = $stmt2->get_result();
                    $row2 = $result2->fetch_assoc();
                    ?>
                    
                    <article class="card">
                        <header>
                            <h3 style="width: fit-content; margin: 0 auto;"><?php echo $row2['first_name'] . ' ' . $row2['last_name']; ?></h3>
                            <div style="width: fit-content; margin: 0 auto;">
                            <?php for ($i = 0; $i < $rating; $i++) { ?>
                                <span class="fa fa-star checked text-warning"></span>
                            <?php } ?>
                            </div>
                        </header>
                        <p class="overflow-auto"><?php echo $row['text']; ?></p>
                        <footer>
                            <span class="reviewButtons">
                                <a role="button" class="secondary" href="verifyReviews.php?vid=<?php echo $id; ?>">Verify</a>
                                <a role="button" class="contrast" href="verifyReviews.php?did=<?php echo $id; ?>">Delete</a>
                            </span>
                        </footer>
                    </article>
                    
                    <?php
                }
                ?>
                </div>
                <?php
            } else {
                ?>
                <p>No reviews to verify.</p>
                <?php
            }
            ?>
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