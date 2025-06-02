<?php 
include '../config/db/connect.php';
include '../config/functions.php';
include '../config/page/stylesFolder.php';

if (isAdmin($mysqli)) {
    header('Location: admin.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM guest WHERE email = ? AND password = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ss', $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
      $_SESSION['userid'] = $result->fetch_assoc()['id'];
      if (isAdmin($mysqli)) {
        header('Location: admin.php');
        exit();
      }
      session_destroy();
      echo '<script>alert("Invalid credentials")</script>';
    } else {
        echo '<script>alert("Invalid credentials")</script>';
    }
}


?>
<body>
    <section class="section bg-light">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-6">
            <div class="login-container" style="padding-top:20px;" data-aos="fade-up">
              <h1 class="text-center" style="font-weight: normal;">Admin Login</h1>
              <form action="" method="post">
                <div class="form-group">
                  <label for="email" class="font-weight-normal text-black">E-mail</label>
                  <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="form-group">
                  <label for="password" class="font-weight-normal text-black">Password</label>
                  <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <div class="form-group">
                  <input type="submit" value="Login" class="btn btn-primary btn-block text-white">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
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