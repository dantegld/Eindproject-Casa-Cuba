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
            <h1>Users</h1>
            <a href="user?add=true">Add User
            </a><br>

            <?php
            if (isset($_POST['add_user_submit'])) {
                $first_name = $_POST['add_first_name'];
                $last_name = $_POST['add_last_name'];
                $email = $_POST['add_email'];
                $phone_number = $_POST['add_phone_number'];
                $type = $_POST['add_type'];
                if ($first_name && $last_name && $email && $type) {
                    $sql = "INSERT INTO guest (first_name, last_name, email, phone_number, type_id) VALUES (?, ?, ?, ?, ?)";
                    $stmt = $mysqli->prepare($sql);
                    $stmt->bind_param('ssssi', $first_name, $last_name, $email, $phone_number, $type);
                    if ($stmt->execute()) {
                        $notification = 'User added.';
                        $alert = 'success';
                    } else {
                        $notification = 'Failed to add user.';
                        $alert = 'danger';
                    }
                } else {
                    $notification = 'Please fill in all required fields.';
                    $alert = 'danger';
                }
                ?>
                <div class="alert alert-<?php echo $alert; ?>" role="alert" id="notification"><?php echo $notification; ?></div>
                <?php
            }
            ?>

            <?php if (isset($_GET['add']) && $_GET['add'] === 'true'): ?>
            <div style="background: #fff; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 30px; margin-bottom: 30px; width: 100%; max-width: 600px;">
                <h3 style="margin-bottom: 20px;">Add New User</h3>
                <form action="user.php?add=true" method="post" class="informationform">
                    <div class="form-group">
                        <label for="add_first_name">First Name</label>
                        <input type="text" class="form-control" id="add_first_name" name="add_first_name" required>
                    </div>
                    <div class="form-group">
                        <label for="add_last_name">Last Name</label>
                        <input type="text" class="form-control" id="add_last_name" name="add_last_name" required>
                    </div>
                    <div class="form-group">
                        <label for="add_email">Email</label>
                        <input type="email" class="form-control" id="add_email" name="add_email" required>
                    </div>
                    <div class="form-group">
                        <label for="add_phone_number">Phone Number</label>
                        <input type="text" class="form-control" id="add_phone_number" name="add_phone_number">
                    </div>
                    <div class="form-group">
                        <label for="add_type">Type</label>
                        <select class="form-control" id="add_type" name="add_type" required>
                            <option value="">Select type</option>
                            <option value="1">Owner</option>
                            <option value="2">Admin</option>
                            <option value="3">Guest</option>
                        </select>
                    </div>
                    <button type="submit" name="add_user_submit" class="btn btn-primary" style="margin-top: 10px;">Add User</button>
                    <a href="user.php" class="btn btn-secondary" style="margin-top: 10px; margin-left: 10px;">Cancel</a>
                </form>
            </div>
            <?php endif; ?>

            <form action="user.php" method="get" class="mb-4">
                <input type="text" name="search" placeholder="Search by name or email" class="form-control" style="width: 300px; display: inline-block;">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
            <?php
            if (isset($_POST['submit'])) {
                $id = $_POST['id'];
                $first_name = $_POST['first_name'];
                $last_name = $_POST['last_name'];
                $email = $_POST['email'];
                $phone_number = $_POST['phone_number'];
                $type = $_POST['type'];
           
                $sql = "UPDATE guest SET first_name = ?, last_name = ?, email = ?, phone_number = ?, type_id = ? WHERE id = ?";
                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param('sssssi', $first_name, $last_name, $email, $phone_number, $type, $id);
                if ($stmt->execute()) {
                    $notification = 'User updated.';
                    $alert = 'success';
                } else {
                    $notification = 'Failed to update user.';
                    $alert = 'danger';
                }
                ?>
                <div class="alert alert-<?php echo $alert; ?>" role="alert" id="notification"><?php echo $notification; ?></div>
                <?php
            }

            if (isset($_GET['did'])) {
                $delete_id = $_GET['did'];
                $sql = "DELETE FROM guest WHERE id = ?";
                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param('i', $delete_id);
                if ($stmt->execute()) {
                    $notification = "User $delete_id deleted.";
                    $alert = 'success';
                } else {
                    $notification = 'Failed to delete user.';
                    $alert = 'danger';
                }
                ?>
                <div class="alert alert-<?php echo $alert; ?>" role="alert" id="notification"><?php echo $notification; ?></div>
                <?php
            }
            ?>
            <table class="table editable-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Type</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $search = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '%';
                    $userid = $_SESSION['userid'];
                    $sql = "SELECT * FROM guest WHERE (first_name LIKE ? OR last_name LIKE ? OR email LIKE ?) AND id != ?";
                    if($userid == 2) {
                        $sql .= " AND type_id != 1";
                    }
                    $stmt = $mysqli->prepare($sql);
                    $stmt->bind_param('sssi', $search, $search, $search, $userid);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <form action="user.php" method="post">
                                <td><?php echo $row['id']; ?></td>
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <td><input class="text-black" type="text" name="first_name" value="<?php echo $row['first_name']; ?>"></td>
                                <td><input class="text-black" type="text" name="last_name" value="<?php echo $row['last_name']; ?>"></td>
                                <td><input class="text-black" type="email" name="email" value="<?php echo $row['email']; ?>"></td>
                                <td><input class="text-black" type="text" name="phone_number" value="<?php echo $row['phone_number']; ?>"></td>
                                <td>
                                    <select class="text-black" name="type">
                                        <option value="1" <?php if ($row['type_id'] == '1') { echo 'selected'; } ?>>Owner</option>
                                        <option value="2" <?php if ($row['type_id'] == '2') { echo 'selected'; } ?>>Admin</option>
                                        <option value="3" <?php if ($row['type_id'] == '3') { echo 'selected'; } ?>>Guest</option>
                                    </select>
                                </td>
                                <td><button type="submit" name="submit" class="btn btn-primary">Save</button></td>
                                <td><a href="user.php?did=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a></td>
                            </form>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
            <script>
                setTimeout(function() {
                    var notification = document.getElementById('notification');
                    if (notification) {
                        notification.style.display = 'none';
                    }
                }, 3000);
            </script>
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