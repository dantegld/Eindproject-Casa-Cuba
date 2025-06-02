<?php
include '../config/page/stylesFolder.php';
?>
<body style="padding-top: 85px;">
    <?php 
    include '../config/page/adminHeader.php';
    include '../config/db/connect.php';
    include '../config/functions.php';
    adminCheck($mysqli);
    ?>
    
    <div style="padding-top: 85px;" class="body2">
        <div class="center">
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload']) && $_POST['upload'] == 'true') {
                if (isset($_FILES['file'])) {
                    $file = $_FILES['file'];
                    $fileName = $file['name'];
                    $fileTmpName = $file['tmp_name'];
                    $fileSize = $file['size'];
                    $fileError = $file['error'];
                    $fileType = $file['type'];

                    $fileExt = explode('.', $fileName);
                    $fileActualExt = strtolower(end($fileExt));

                    $allowed = array('pdf');

                    if (in_array($fileActualExt, $allowed)) {
                        if ($fileError === 0) {
                            if ($fileSize < 1000000) {
                                $fileNameNew = "Casa-Cuba-Rules.pdf";
                                $fileDestination = '../images/rules/' . $fileNameNew;
                                if (file_exists($fileDestination)) {
                                    unlink($fileDestination);
                                }
                                move_uploaded_file($fileTmpName, $fileDestination);
                                echo '<div class="alert alert-success" role="alert">File uploaded successfully.</div>';
                            } else {
                                echo '<div class="alert alert-danger" role="alert">File is too big.</div>';
                            }
                        } else {
                            echo '<div class="alert alert-danger" role="alert">There was an error uploading your file.</div>';
                        }
                    } else {
                        echo '<div class="alert alert-danger" role="alert">You cannot upload files of this type.</div>';
                    }
                }
            }
            ?>
            <embed style="width:80vw;height: 800px;" src="../images/rules/Casa-Cuba-Rules.pdf" width="800px" height="2100px" />
            <a href="../images/rules/Casa-Cuba-Rules.pdf" download class="btn btn-primary">Download Rules</a><br>
            <form action="hotelRules.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="upload" value="true">
                <input type="file" name="file" class="btn btn-secondary">
                <input type="submit" value="Upload" class="btn btn-primary">
            </form>
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