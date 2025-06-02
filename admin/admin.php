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
            <p>Hello admin.</p>
            <p>Use the menu to naviagte admin commands.</p>
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