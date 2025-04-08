<?php
session_start();
if (!isset($_SESSION['user-username']) || $_SESSION['user-role'] != "user") {
    header('location:../index.php');
    exit();
}

include("dbinfo.php");

$alert_message = '';  // Variable to hold alert messages
$old_password_error = false;
$confirm_password_error = false;
$user_id = $_SESSION['user-id'];

if (isset($_POST['submit'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Select current user data
    $select_qur = "SELECT * FROM user_tbl WHERE user_id = '$user_id'";
    $res_select = mysqli_query($con, $select_qur);
    $row = mysqli_fetch_array($res_select);
    $user_password = $row['user_password'];

    // Check if old password matches the stored password
    if ($old_password == $user_password) {
        // Check if the new password and confirm password match
        if ($new_password == $confirm_password) {
            // Update password in the database
            $qur = "UPDATE user_tbl SET user_password = '$new_password' , confirm_password = '$confirm_password' WHERE user_id = '$user_id'";
            $res = mysqli_query($con, $qur);

            if ($res) {
                // Redirect to user page after successful password change
                header('location:user.php');
                exit();
            } else {
                $alert_message = 'Error updating password. Please try again later.';
            }
        } else {
            $confirm_password_error = true;
            $alert_message = 'New password and confirm password do not match!';
        }
    } else {
        $old_password_error = true;
        $alert_message = 'Your old password is incorrect!';
    }
}
?>
<?php
include("admin-header.php");
?>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <?php
            if ($alert_message) {
                echo "<div class='alert alert-danger' role='alert'>$alert_message</div>";
            }
            ?>
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Change Password</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Change Password</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Centering the login box without extra top margin -->
    <div class="container-fluid d-flex justify-content-center align-items-center mt-5" style=" margin-top: 0;">
    <div class="login-box">
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Change your password</p>
                <form action="" method="post">
                    <div class="input-group mb-3">
                        <input type="password" name="old_password" class="form-control" placeholder="Enter old Password" required>
                        <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" name="new_password" class="form-control" placeholder="New Password" required>
                        <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
                        <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <div class="d-grid gap-2">
                                <button type="submit" name="submit" class="btn btn-primary">Change</button>
                            </div>
                        </div>
                    </div>
                </form>
             
            </div>
        </div>
    </div>
</div>

</main>


<?php
include("footer.php");
?>